<?php

namespace App\Traits;

use App\User;

trait Authored
{

    /**
     * @param User $author
     */
    public function assignAuthor(User $author)
    {
        $this->author()->associate($author);
    }

    /**********************************************************************
     * Relations
     **********************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}