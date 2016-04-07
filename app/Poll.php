<?php

namespace App;

use App\Traits\Authored;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Poll
 * @package App
 *
 * @property integer                 $id
 * @property integer                 $author_id
 * @property User                    $author
 *
 * @property string                  $title
 * @property string                  $description
 * @property bool                    $multiple
 *
 * @property PollAnswer[]|Collection $answers
 *
 * @property Carbon                  $created_at
 * @property Carbon                  $updated_at
 * @property Carbon                  $deleted_at
 */
class Poll extends Model
{
    use SoftDeletes, Authored;

    /**
     * @param array $pollData
     * @param User  $author
     *
     * @return Poll
     */
    public static function createFromArray(array $pollData, User $author)
    {
        $answers = (array) array_pull($pollData, 'answers');

        $poll = new static($pollData);

        $poll->assignAuthor($author);

        $poll->save();

        foreach ($answers as $answerData) {
            if (is_string($answerData)) {
                $answerData = [
                    'title' => $answerData,
                ];
            }

            $answer = new PollAnswer($answerData);
            $answer->assignAuthor($author);
            $poll->answers()->save($answer);
        }

        return $poll;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Poll $poll) {
            $poll->author_id = auth()->user()->id;
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
        'multiple',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'multiple' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'expired_at'];

    /**
     * @param PollAnswer $answer
     * @param User       $voter
     *
     * @return bool
     */
    public function vote(PollAnswer $answer, User $voter)
    {
        if (! $this->isMultiple() and $this->isVotedBy($voter)) {
            return false;
        }

        return $answer->vote($voter);
    }

    /**
     * @param User $voter
     *
     * @return bool
     */
    public function isVotedBy(User $voter = null)
    {
        if (is_null($voter)) {
            return false;
        }

        return ! is_null($this->votes()->where('author_id', $voter->id)->first());
    }

    /**
     * @return bool
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * @return int
     */
    public function totalVotes()
    {
        $total = 0;

        foreach ($this->answers()->get() as $answer) {
            $total += $answer->votes;
        }

        return $total;
    }

    /**
     * @param User $voter
     */
    public function resetVotesFor(User $voter)
    {
        $this->votes()->where('author_id', $voter->id)->get()->each(function ($vote) {
            $vote->delete();
        });
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @return in
     */
    public function getTotalVotesAttribute()
    {
        return $this->totalVotes();
    }


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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(PollAnswer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(PollVote::class);
    }

    /**********************************************************************
     * Scopes
     **********************************************************************/

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->orWhere('expired_at', '>=', Carbon::now()->toDateString());
            $q->orWhereNull('expired_at');
        });
    }
}
