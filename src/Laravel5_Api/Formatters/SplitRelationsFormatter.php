<?php

namespace SehrGut\Laravel5_Api\Formatters;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use SehrGut\Laravel5_Api\Transformers\SplitRelationsTransformer;

/**
 * This response Formatter is meant to work together with the `SplitRelationsTransformer`.
 *
 * It extracts the corresponding values from the Transformer's
 * return values and presents them as an appropriate response:
 * ```
 * [
 *     'result': ['id': 1, 'name': 'Some Record', 'some_relation': [1]],
 *     'relations': [
 *         'some_relation': [
 *                ['id': 1, 'type': 'Another Record']
 *         ]
 *     ]
 * ]
 * ```
 */
class SplitRelationsFormatter extends Formatter
{
    /**
     * The name under which the actual results are listed in the response.
     *
     * @var string
     */
    protected $results_key = 'result';

    /**
     * The name under which the included relations are listed in the response.
     *
     * @var string
     */
    protected $relations_key = 'relations';

    /** {@inheritdoc} */
    protected function formatCollection(EloquentCollection $collection)
    {
        $result = [];
        $relations = [];

        // We get an ['result' => …, 'relations' => …] array for each item
        // from the transformer. These arrays need to be merged into one
        // ['result' => […, …], 'relations' => […, …]] array.
        foreach ($collection as $item) {
            $transformed = $this->transform($item);
            $result[] = $transformed[SplitRelationsTransformer::RESULTS_KEY];
            $relations = $this->mergeRelations($relations, $transformed[SplitRelationsTransformer::RELATIONS_KEY]);
        }

        return [
            $this->results_key   => $result,
            $this->relations_key => $relations,
        ];
    }

    /** {@inheritdoc} */
    protected function formatResource(Model $model)
    {
        $transformed = $this->transform($model);

        return [
            $this->results_key   => $transformed[SplitRelationsTransformer::RESULTS_KEY],
            $this->relations_key => $transformed[SplitRelationsTransformer::RELATIONS_KEY],
        ];
    }

    /**
     * Merge `new` into `old` relations, returning a new deduplicated array.
     *
     * @param array $old
     * @param array $new
     *
     * @return array
     */
    protected function mergeRelations($old, $new)
    {
        foreach ($new as $name => $relations) {
            if (!array_key_exists($name, $old)) {
                $old[$name] = new Collection();
            }
            $old[$name] = $old[$name]->merge($relations)->unique()->sortBy('id')->values();
        }

        return $old;
    }
}
