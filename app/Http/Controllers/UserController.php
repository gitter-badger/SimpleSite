<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderByName()->get()->groupBy(function (User $user, $key) {
            return strtoupper(Str::substr($user->name, 0, 1));
        });

        return view('users.index', [
            'users' => $users,
        ]);
    }
}
