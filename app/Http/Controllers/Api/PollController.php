<?php

namespace App\Http\Controllers\Api;

use App\Poll;
use App\PollAnswer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PollController extends Controller
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $polls = Poll::with('answers', 'votes', 'author')->active()->get();

        foreach ($polls as $poll) {
            $poll->is_voted    = $poll->isVotedBy($request->user());
            $poll->total_votes = $poll->totalVotes();
            foreach ($poll->answers as $answer) {
                if ($poll->total_votes) {
                    $answer->percentage = $answer->votes / $poll->total_votes * 100;
                } else {
                    $answer->percentage = 0;
                }
            }
        }

        return new JsonResponse($polls);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function vote(Request $request, $id)
    {
        $poll = Poll::with('answers', 'votes')->active()->findOrFail($id);

        $votes = $request->get('votes', []);

        $pollVotes = PollAnswer::whereIn('id', $votes)->get();

        if (! $poll->isMultiple()) {
            $pollVotes = [$pollVotes->first()];
        }

        foreach ($pollVotes as $vote) {
            $poll->vote($vote, $request->user());
        }

        return $this->index($request);
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return JsonResponse
     */
    public function reset(Request $request, $id)
    {
        $poll = Poll::with('answers', 'votes')->active()->findOrFail($id);

        $poll->resetVotesFor($request->user());

        return $this->index($request);
    }
}