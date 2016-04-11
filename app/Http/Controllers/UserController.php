<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            'users' => \App\User::orderByName()->get(),
        ]);
    }
}
