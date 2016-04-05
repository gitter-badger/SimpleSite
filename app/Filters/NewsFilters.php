<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class NewsFilters extends QueryFilters
{
    /**
     * Filter by type
     *
     * @param string $type
     *
     * @return Builder
     */
    public function type($type)
    {
        return $this->builder->where('type', $type);
    }
}