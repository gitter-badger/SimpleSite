<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($ability != 'participate') {
            if ($user->isManager()) {
                return true;
            }
        }
    }

    /**
     * @param User $user
     * @param Post $post
     *
     * @return bool
     */
    public function participate(User $user = null, Post $post)
    {
        return $post->isEvent() and ! $post->isPastEvent() and (is_null($user) or ($user and ! $post->hasMember($user)));
    }
}
