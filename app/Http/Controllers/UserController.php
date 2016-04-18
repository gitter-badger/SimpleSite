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
        \Assets::loadPackage('filterTable');

        $users = User::get()
            ->sortBy('display_name')
            ->groupBy(function (User $user, $key) {
                return Str::upper(Str::substr($user->display_name, 0, 1));
            });

        return view('users.index', compact('users'));
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function profile()
    {
        return $this->renderProfile(
            auth()->user()
        );
    }

    /**
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function tree()
    {
        \Assets::loadPackage('treant');
        $tree = User::tree();

        return view('users.tree', compact('tree'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function userProfile($id)
    {
        return $this->renderProfile(
            User::with('events')->findOrFail($id)
        );
    }

    protected function renderProfile(User $user)
    {
        \Assets::loadPackage('fullcalendar');

        $events = $user->events;
        $contacts = $user->contacts();
        $chief = $user->chief;

        return view('users.profile', compact('user', 'events', 'contacts', 'chief'));
    }
}
