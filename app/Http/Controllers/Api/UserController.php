<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        return new JsonResponse(
            User::get()
                ->sortBy('display_name')
                ->groupBy(function (User $user, $key) {
                    return Str::upper(Str::substr($user->display_name, 0, 1));
                })
        );
    }
}