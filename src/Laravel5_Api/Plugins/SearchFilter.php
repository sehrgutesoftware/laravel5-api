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
     * Configuration Options:.
     *
     * - searchable: An array of fieldnames on the model to compare with
     * - search_param: Name of the request parameter that holds the search query
     *
     * Example for searching only on a model's local attributes:
     *
     * ```
     * 'searchable' => [
     *     'name',
     *     'description',
     *     'bio'
     * ]
     * ```
     *
     * Example for searching also on the fields of a model's relationships:
     *
     * ```
     * 'searchable' => [
     *     'name',
     *     'description',
     *     'posts' => [  // Search the following fields on the `post` relation
     *         'title',
     *         'body'
     *         'comments' => [  // Supports recursive nesting
     *             'message'
     *         ]
     *     ]
     * ]
     * ```
     *
     * @var array
     */
    protected $default_config = [
        'searchable'   => [],
        'search_param' => 'filter',
    ];

    public function adaptCollectionQuery(Builder $query)
    {
        $fields = $this->config['searchable'];
        $condition = (string) $this->controller
            ->request_adapter
            ->getValueByKey($this->config['search_param'], '');

        if (!empty($condition) and count($fields) > 0) {
            $query = $this->applyFilter($query, $fields, $condition);
        }

        return $query;
    }

    /**
     * Add filter conditions to the `$query`.
     *
     * @param Builder $query
     * @param array   $fields
     * @param string  $condition
     *
     * @return Builder
     */
    protected function applyFilter(Builder $query, array $fields, String $condition)
    {
        $query->where(function ($subquery) use ($fields, $condition) {
            foreach ($fields as $relation => $field) {
                $subquery = $this->addCondition($subquery, $relation, $field, $condition);
            }

            return $subquery;
        });

        return $query;
    }

    /**
     * Add a where filter to the `$query`. When `$field` is an array, the fields
     * in the array will be compared against `$relation`. This works recursively.
     *
     * @param Builder      $query     The query on which to apply the "wheres"
     * @param string|int   $relation  The relation on which to compare (ignored if $field is not an array)
     * @param string|array $field     Name of the field (or fields)
     * @param string       $condition The search term
     */
    protected function addCondition(Builder $query, $relation, $field, String $condition)
    {
        if (is_array($field)) {
            // Recursive search on relations
            $that = $this;
            $query->orWhereHas($relation, function ($subquery) use ($that, $condition, $field) {
                $subquery->where(function ($subsubquery) use ($that, $condition, $field) {
                    foreach ($field as $subrelation => $subfield) {
                        $subsubquery = $that->addCondition($subsubquery, $subrelation, $subfield, $condition);
                    }

                    return $subsubquery;
                });

                return $subquery;
            });
        } else {
            // Search on a model attribute
            $query->orWhere($field, 'ilike', "%$condition%");
        }

        return $query;
    }
}
