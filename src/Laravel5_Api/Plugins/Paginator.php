<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Database\Eloquent\Builder;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;

/**
 * A basic paginator that takes `limit` and `page` from the
 * request and adapts the colleciton queries accordingly.
 */
class Paginator extends Plugin implements AdaptCollectionQuery
{
    public function adaptCollectionQuery(Builder $query)
    {
        $limit = $this->controller->request_adapter->getValueByKey('limit', 10);
        $page = $this->controller->request_adapter->getValueByKey('page', 1);

        $query->limit($limit)->skip(($page - 1)*$limit);
        return $query;
    }
}
