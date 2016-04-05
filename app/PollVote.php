<?php

namespace App;

use App\Traits\Authored;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PollVote
 * @package App
 *
 * @property integer    $id
 * @property integer    $author_id
 * @property User       $author
 *
 * @property integer    $poll_id
 * @property Poll       $poll
 *
 * @property integer    $answer_id
 * @property PollAnswer $answer
 *
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 */
class PollVote extends Model
{
    use Authored;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (PollVote $vote) {
            $vote->answer->decrement('votes');
            $vote->answer->update();
        });
    }

    /**
     * @param Poll $poll
     */
    public function associatePoll(Poll $poll)
    {
        $this->poll()->associate($poll);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answer()
    {
        return $this->belongsTo(PollAnswer::class, 'answer_id');
    }
}
