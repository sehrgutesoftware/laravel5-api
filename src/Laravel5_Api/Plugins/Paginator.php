<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Database\Eloquent\Builder;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;

/**
 * A basic paginator that takes `limit` and `page` from the
 * request and adapts the colleciton queries accordingly.
 */
class Paginator extends Plugin implements AdaptCollectionQuery, FormatCollection
{
    protected $default_config = [
        'limit_param'   => 'limit',
        'page_param'    => 'page',
        'limit_default' => 10,
        'page_default'  => 1,
        'meta_counts'   => false,
        'result_key'    => 'result',
    ];

    protected $counts;

    /* {@inheritdoc} **/
    public function adaptCollectionQuery(Builder $query)
    {
        $total = $query->count();

        $limit = (int) $this->controller->request_adapter->getValueByKey(
            $this->config['limit_param'],
            $this->config['limit_default']
        );
        $page = (int) $this->controller->request_adapter->getValueByKey(
            $this->config['page_param'],
            $this->config['page_default']
        );

        $this->counts = [
            'total' => $total,
            $this->config['limit_param'] => $limit,
            $this->config['page_param'] => $page,
        ];

        return $query->limit($limit)->skip(($page - 1) * $limit);
    }

    /* {@inheritdoc} **/
    public function formatCollection(Array $collection)
    {
        if ($meta_key = $this->config['meta_counts']) {
            return [
                $this->config['result_key'] => $collection,
                $meta_key => $this->counts,
            ];
        }

        return $collection;
    }
}
