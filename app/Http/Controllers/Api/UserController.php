<?php

namespace App\Http\Controllers\Api;

use App\Calendar;
use App\Filters\CalendarFilters;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @param CalendarFilters $filters
     * @param int|null        $userId
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function calendar(CalendarFilters $filters, $userId = null)
    {
        $calendar = Calendar::filter($filters);

        if (! is_null($userId)) {
            $calendar->where('user_id', $userId);
        }

        return $calendar->get();
    }
}