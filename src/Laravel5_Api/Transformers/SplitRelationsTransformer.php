<?php

namespace SehrGut\Laravel5_Api\Transformers;

use Illuminate\Support\Collection;

/**
 * Formatter that splits off relations and attributes and returns them as separate arrays.
 *
 * **Format:**
 * ```
 * [
 *     'result': [
 *         'id': …,
 *         …,
 *         'some_relation': [12, 13, 14]
 *     ],
 *     'relations': [
 *         'some_relation': [
 *             ['id': 12, …],
 *             ['id': 13, …],
 *             ['id': 14, …]
 *         ]
 *     ]
 * ]
 * ```
 */
class SplitRelationsTransformer extends Transformer
{
    /**
     * These constants are only there for internal purposes and
     * to let the Formatter know where to find the two parts.
     */
    const RESULTS_KEY = 'result';
    const RELATIONS_KEY = 'relations';

    /**
     * Holds the related models grouped by their relation name.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Add a single relation.
     *
     * @param string           $name
     * @param Model|Collection $relation
     */
    protected function addRelation(String $name, $relation)
    {
        $relations = $this->transformAny($relation);
        $this->attachIncludes($name, $relations);
        $this->output[$name] = $this->extractIds($relation);
    }

    protected function attachIncludes(String $name, $model_or_array)
    {
        if (array_values($model_or_array) === $model_or_array) {
            // We have a numeric (non associative) array here
            foreach ($model_or_array as $item) {
                $this->attachIncludes($name, $item);
            }
        } else {
            $model = $model_or_array;

            if (array_key_exists(self::RESULTS_KEY, $model) and array_key_exists(self::RELATIONS_KEY, $model)) {
                $this->relations[$name][] = $model[self::RESULTS_KEY];
                $this->relations = array_merge_recursive($this->relations, $model[self::RELATIONS_KEY]);
            } else {
                $this->relations[$name] = $model;
            }
        }
    }

    /**
     * Serialize a single record to an array.
     *
     * @return array
     */
    protected function serialize()
    {
        return [
            self::RESULTS_KEY   => $this->output,
            self::RELATIONS_KEY => $this->relations,
        ];
    }

    /**
     * Get the primary identifiers for either a single model or a collection of models.
     *
     * @param Model|Colleciton $model_or_collection
     *
     * @return mixed|Array<mixed>
     */
    protected function extractIds($model_or_collection)
    {
        if (is_null($model_or_collection)) {
            return;
        }

        if ($model_or_collection instanceof Collection) {
            return $model_or_collection->map(function ($item) {
                return $item->getKey();
            });
        }

        return $model_or_collection->getKey();
    }
}
