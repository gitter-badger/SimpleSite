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

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function profile()
    {
        $user = auth()->user();
        $isOwner = true;

        return view('users.profile', compact('user', 'isOwner'));
    }
    
    public function userProfile($id)
    {
        $user = User::findOrFail($id);
        $isOwner = false;
        return view('users.profile', compact('user', 'isOwner'));
    }
}
