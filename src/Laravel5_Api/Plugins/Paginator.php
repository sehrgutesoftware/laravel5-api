<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Database\Eloquent\Builder;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;
use SehrGut\Laravel5_Api\Hooks\ResponseHeaders;

/**
 * A basic paginator that takes `limit` and `page` from the
 * request and adapts the colleciton queries accordingly.
 *
 * By default, the plugin adds http headers with meta info to the response:
 * `X-Pagination-Total`, `X-Pagination-Limit` and `X-Pagination-Page`
 *
 * These can be renamed or moved to the response payload
 * instead, through the plugin's configuration options.
 */
class Paginator extends Plugin implements AdaptCollectionQuery, FormatCollection, ResponseHeaders
{
    /**
     * Configuration options for this Plugin:.
     *
     * - `limit_param`: Name of the request parameter that contains the limit value (page size)
     * - `page_param`: Name of the request parameter that contains the page number
     * - `limit_default`: Default limit value if none present in request
     * - `page_default`: Default page number if none present in request
     * - `meta_in_payload`: Key under which to meta info (total, limit, current page)
     *                      to response body (or `false` to disable)
     * - `meta_in_headers`: (Boolean) Whether or not to add meta info as http headers
     * - `meta_structure`: An array describing how meta info is formatted (in payload) or
     *                     naming headers (in http headers). '$total', '$limit',
     *                     '$page', '$last_page' will be replaced with their
     *                     actual values. (Remember to use single quotes)
     *
     * @var array
     */
    protected $default_config = [
        'limit_param'     => 'limit',
        'page_param'      => 'page',
        'limit_default'   => 10,
        'page_default'    => 1,
        'meta_in_payload' => false,
        'meta_in_headers' => true,
        'meta_structure'  => [
            'X-Pagination-Total' => '$total',
            'X-Pagination-Limit' => '$limit',
            'X-Pagination-Page'  => '$page',
        ],
    ];

    protected $meta_counts;

    /** {@inheritdoc} */
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

        $this->saveMetaCounts($total, $limit, $page);

        return $query->limit($limit)->skip(($page - 1) * $limit);
    }

    /** {@inheritdoc} */
    public function formatCollection(array $collection)
    {
        if ($meta_key = $this->config['meta_in_payload']) {
            $collection[$meta_key] = $this->meta_counts;
        }

        return $collection;
    }

    /** {@inheritdoc} */
    public function responseHeaders(array $headers)
    {
        if ($this->config['meta_in_headers']) {
            $headers = array_merge($headers, $this->meta_counts);
        }

        return $headers;
    }

    /**
     * Replace $placeholders with their actual values in config['meta_structure']
     * and store the resulting array into `$this->meta_counts`.
     *
     * @param int $total
     * @param int $limit
     * @param int $page
     *
     * @return void
     */
    protected function saveMetaCounts(int $total, int $limit, int $page)
    {
        $values = [
            '$total' => $total,
            '$limit' => $limit,
            '$page' => $page,
            '$last_page' => ceil($total/$limit),
        ];
        $this->meta_counts = $this->config['meta_structure'];
        array_walk_recursive($this->meta_counts, function (&$node) use ($values) {
            if (array_key_exists($node, $values)) {
                $node = $values[$node];
            }

            return $node;
        });
    }
}
