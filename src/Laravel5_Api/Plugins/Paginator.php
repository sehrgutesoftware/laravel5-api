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
    protected $default_config = [
        'limit_param' => 'limit',
        'page_param' => 'page',
        'limit_default' => 10,
        'page_default' => 1,
    ];

    public function adaptCollectionQuery(Builder $query)
    {
        $limit = (int) $this->controller->request_adapter->getValueByKey(
            $this->config['limit_param'],
            $this->config['limit_default']
        );
        $page = (int) $this->controller->request_adapter->getValueByKey(
            $this->config['page_param'],
            $this->config['page_default']
        );

        return $query->limit($limit)->skip(($page - 1)*$limit);
    }
}
