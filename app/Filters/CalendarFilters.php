<?php

namespace App\Filters;

class CalendarFilters extends QueryFilters
{
    /**
     * @param array $dates
     *
     * @return mixed
     */
    public function between($dates)
    {
        return $this->builder->whereBetween("start_at", $dates);
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        $dates = array_filter($this->request->only('start', 'end'));

        if (count($dates) == 2) {
            return [
                'between' => $dates,
            ];
        }

        return [];
    }
}