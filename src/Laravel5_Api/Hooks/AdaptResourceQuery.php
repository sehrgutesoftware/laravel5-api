<?php

namespace SehrGut\Laravel5_Api\Hooks;

use Illuminate\Database\Eloquent\Builder;

interface AdaptResourceQuery
{
    /**
     * This hook receives the query on "single resource" requests after the
     * request parameters have been applied, before the record is retrieved.
     *
     * @param Builder $query
     *
     * @return Builder The modified query instance
     */
    public function adaptResourceQuery(Builder $query);
}
