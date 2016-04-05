<?php

namespace App\Traits;

use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Filterable
 * @package App\Traits
 *
 * @method static filter(QueryFilters $filters)
 */
trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  Builder      $query
     * @param  QueryFilters $filters
     *
     * @return Builder
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}