<?php

namespace App;

use App\Exceptions\PollVoteException;
use App\Traits\Authored;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PollQuestion
 * @package App
 *
 * @property integer               $id
 * @property integer               $author_id
 * @property User                  $author
 *
 * @property integer               $poll_id
 * @property Poll                  $poll
 *
 * @property PollVote[]|Collection $votes
 *
 * @property Carbon                $created_at
 * @property Carbon                $updated_at
 */
class PollAnswer extends Model
{
    use Authored;


    protected static function boot()
    {
        parent::boot();

        static::saving(function (PollAnswer $answer) {
            $answer->author_id = auth()->user()->id;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'votes' => 'integer',
    ];

    /**
     * @param User $voter
     *
     * @return bool
     * @throws PollVoteException
     */
    public function vote(User $voter)
    {
        if (! $this->exists) {
            throw new PollVoteException('Answer not exists');
        }

        if (! $voter->exists) {
            throw new PollVoteException('Voter not exists');
        }

        if (! $this->isVotedBy($voter)) {
            $this->increment('votes');

            $vote = new PollVote();
            $vote->assignAuthor($voter);
            $vote->associatePoll($this->poll);

            $this->votes()->save($vote);

            return true;
        }

        return false;
    }

    /**
     * @param User $voter
     *
     * @return bool
     */
    public function isVotedBy(User $voter)
    {
        return ! is_null($this->votes()->where('author_id', $voter->id)->first());
    }

    /**
     * @param Poll $poll
     */
    public function associatePoll(Poll $poll)
    {
        $this->poll()->associate($poll);
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param string $title
     */
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = trim($title);
    }

    /**
     * @param string $description
     */
    public function setDescriptionAttribute($description)
    {
        $this->attributes['description'] = trim($description);
    }

    /**********************************************************************
     * Relations
     **********************************************************************/
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(PollVote::class, 'answer_id');
    }
}
