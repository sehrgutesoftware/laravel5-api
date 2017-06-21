<?php

namespace SehrGut\Laravel5_Api\Hooks;

use Illuminate\Database\Eloquent\Builder;

interface AdaptCollectionQuery
{
    /**
     * This hook receives the query on "index requests" after the request
     * parameters have been applied, before the records are retrieved.
     *
     * @param  Builder $query
     * @return Builder  The modified query instance
     */
    public function adaptCollectionQuery(Builder $query);
}
