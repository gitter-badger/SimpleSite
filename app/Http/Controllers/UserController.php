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
        $users = User::orderBy('chief_id')->get()->toArray();

        $tree = $this->convertToTree($users);

        return view('users.tree', compact('tree'));
    }

    function convertToTree(array $flat, $idField = 'id', $parentIdField = 'chief_id', $childNodesField = 'childNodes') {
        $indexed = [];
        // first pass - get the array indexed by the primary id
        foreach ($flat as $row) {
            $indexed[$row[$idField]] = $row;
            $indexed[$row[$idField]]['is_root'] = true;
            $indexed[$row[$idField]][$childNodesField] = [];
        }

        //second pass
        $roots = [];
        foreach ($indexed as $id => $row) {
            $indexed[$row[$parentIdField]][$childNodesField][$id] =& $indexed[$id];
            $indexed[$id]['is_root'] = false;

            if (! $row[$parentIdField]) {
                $roots[] = $id;
            }
        }
        return [$root => $indexed[$root]];
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
