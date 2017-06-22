<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Database\Eloquent\Builder;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;

/**
 * This plugin allows filtering results index requests by applying `orWhere` conditions
 * to the collection query, searching all `searchable` fields for the string
 * passed in through the `search_param` request parameter.
 *
 * Configre the searchable fields on the model and the name
 * of the `search_param` from inside the controller:
 *
 * ```
 * protected function afterConstruct()
 * {
 *     $this->configurePlugin(SearchFilter::class, [
 *         'searchable' => ['name', 'description'],  // compare to those fields on the model
 *         'search_param' => 'query',                // `?query=some+search+query`
 *     ]);
 * }
 * ```
 */
class SearchFilter extends Plugin implements AdaptCollectionQuery
{
    /**
     * Configuration Options:
     *
     * - searchable: An array of fieldnames on the model to compare with
     * - search_param: Name of the request parameter that holds the search query
     *
     * @var array
     */
    protected $default_config = [
        'searchable' => [],
        'search_param' => 'filter',
    ];

    public function adaptCollectionQuery(Builder $query)
    {
        $fields = $this->config['searchable'];
        $condition = (string) $this->controller
            ->request_adapter
            ->getValueByKey($this->config['search_param'], '');

        if (!empty($condition) AND count($fields) > 0) {
            $query = $this->applyFilter($query, $fields, $condition);
        }

        return $query;
    }

    /**
     * Add filter conditions to the `$query`.
     *
     * @param  Builder $query
     * @param  Array   $fields
     * @param  String  $condition
     * @return Builder
     */
    protected function applyFilter(Builder $query, Array $fields, String $condition)
    {
        $query->where(function($subquery) use ($fields, $condition) {
            foreach ($fields as $field) {
                $subquery->orWhere($field, 'ilike', "%$condition%");
            }
            return $subquery;
        });

        return $query;
    }
}
