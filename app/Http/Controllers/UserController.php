<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $users = User::orderByName()->get()->groupBy(function (User $user, $key) {
            return strtoupper(Str::substr($user->name, 0, 1));
        });

        return view('users.index', compact('users'));
    }

    public function profile()
    {
        $user = auth()->user();
        
        return view('users.profile', compact('user'));
    }
}
