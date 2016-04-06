<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function members(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $members = $post->members;

        $isMember = ! is_null($request->user()) && ! is_null($post->members()->where('user_id', $request->user()->id)->first());

        return new JsonResponse([
            'members'   => $members,
            'count'     => count($members),
            'is_member' => $isMember,
        ]);
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function addMember(Request $request, $id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($id);

        if (! $post->members()->where('user_id', $request->user()->id)->first()) {
            $post->members()->attach($request->user());
        }

        return $this->members($request, $id);
    }
}