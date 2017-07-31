<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Support\Collection;
use SehrGut\Laravel5_Api\Context;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;
use SehrGut\Laravel5_Api\Hooks\FormatResource;

/**
 * This plugin separates relations from the actually requested models
 * and puts them under separate keys in the response payload.
 *
 * ** Config options: **
 *
 * - `result_key`: The key under which the actual results will appear in the response payload (default: 'result')
 * - `includes_key`: The key under which the extracted relations will appear in the response payload (default: 'includes')
 * - `replace_with_ids`: Whether to replace the removed relations with their ids on the parent model (default: true)
 * - `ignore_relations`: An array of relation names that are ingored when splitting (default: [])
 * - `ignore_pivots`: Drop all pivots if true (default: true)
 */
class RelationSplitter extends Plugin implements FormatCollection, FormatResource
{
    const SINGULAR_RELATIONS = [
        'Illuminate\Database\Eloquent\Relations\BelongsTo',
        'Illuminate\Database\Eloquent\Relations\HasOne',
        'Illuminate\Database\Eloquent\Relations\MorphTo',
        'Illuminate\Database\Eloquent\Relations\MorphOne',
    ];

    /**
     * Config options for this plugin:.
     *
     * @var array
     */
    protected $default_config = [
        'result_key'       => 'result',
        'includes_key'     => 'includes',
        'replace_with_ids' => true,
        'ignore_relations' => [],
        'ignore_pivots'    => true,
    ];

    protected $includes = [];

    /** {@inheritdoc} */
    public function formatCollection(Context $context)
    {
        $this->splitRelationsFromCollection($context->collection);

        $context->collection = [
            $this->config['result_key']   => $context->collection,
            $this->config['includes_key'] => $this->uniqueIncludes(),
        ];

        return $context;
    }

    /** {@inheritdoc} */
    public function formatResource(Context $context)
    {
        $this->splitRelationsFromCollection($context->resource);

        $context->resource = [
            $this->config['result_key']   => $context->resource,
            $this->config['includes_key'] => $this->uniqueIncludes(),
        ];

        return $context;
    }

    /**
     * Separate the related models from each model in the passed-in collection.
     *
     * @param mixed $collection
     *
     * @return void
     */
    protected function splitRelationsFromCollection($collection)
    {
        $collection = static::ensureArray($collection);

        foreach ($collection as $model) {
            // Check if the model has eloquent-like relations
            if (!is_callable([$model, 'getRelations'])) {
                continue;
            }

            $this->splitRelationsFromModel($model);
        }
    }

    /**
     * Split away relations from a single resource.
     *
     * @param Model $model
     *
     * @return void
     */
    protected function splitRelationsFromModel($model)
    {
        foreach ($model->getRelations() as $name => $relatives) {
            $this->includeRelativesAndRecurse($name, $relatives);
        }

        $this->replaceWithIdsOrClear($model);
    }

    /**
     * Add relatives to `$this->includes` and run them through the splitter in turn, recursively.
     *
     * @param string $name
     * @param array  $relatives
     *
     * @return void
     */
    protected function includeRelativesAndRecurse(string $name, $relatives)
    {
        if (in_array($name, $this->config['ignore_relations'])) {
            return;
        }

        // Save the relatives to the "includes" array
        $this->includeRelatives($name, $relatives);

        // Repeat the entire process for relatives (recurse)
        $this->splitRelationsFromCollection($relatives);
    }

    /**
     * Add passed-in relatives to `$this->includes` under the `$name` key.
     *
     * @param string $name
     * @param mixed  $relatives
     *
     * @return void
     */
    protected function includeRelatives(string $name, $relatives)
    {
        $relatives = static::ensureArray($relatives);

        $this->includeAs($name, $relatives);
    }

    /**
     * Add given relatives to `$this->includes` under `$name`.
     *
     * @param string $name
     * @param array  $relatives
     *
     * @return void
     */
    protected function includeAs(string $name, $relatives)
    {
        if ($name === 'pivot' and $this->config['ignore_pivots']) {
            return;
        }

        if (!array_key_exists($name, $this->includes)) {
            $this->includes[$name] = [];
        }

        $this->includes[$name] = array_merge($this->includes[$name], $relatives);
    }

    /**
     * Replace related models with their ids.
     *
     * @param Model $model
     *
     * @return void
     */
    protected function replaceWithIdsOrClear($model)
    {
        if (!$this->config['replace_with_ids']) {
            // Remove all relatives from all relations on the model
            $model->setRelations([]);
            return;
        }

        $ids = [];

        foreach ($model->getRelations() as $name => $relatives) {
            if ($name === 'pivot' or in_array($name, $this->config['ignore_relations'])) {
                continue;
            }

            if (static::isSingularRelation($model, $name)) {
                $ids[$name] = $relatives ? $relatives->getKey() : null;
                continue;
            }

            $ids[$name] = $relatives->map(function ($relative) {
                return $relative->getKey();
            });
        }

        $model->setRelations([]);
        $new_attributes = array_merge($model->getAttributes(), $ids);
        $model->setRawAttributes($new_attributes);
    }

    /**
     * Return all includes after removing duplicates.
     *
     * @return array
     */
    protected function uniqueIncludes()
    {
        $includes = [];
        foreach ($this->includes as $name => $relatives) {
            $includes[$name] = array_values(array_unique($relatives));
        }

        return $includes;
    }

    /**
     * Check if a relation on a model is singular, meaning that
     * it refers to a single record, as opposed to multiple.
     *
     * @param Model  $model    The model whose relation to check
     * @param string $relation Name of the relation on the model
     *
     * @return bool
     */
    protected static function isSingularRelation($model, $relation)
    {
        $class = get_class($model->$relation());

        return in_array($class, static::SINGULAR_RELATIONS);
    }

    /**
     * Wrap subject into an array if it isn't one already, convert to array if it's a collection.
     *
     * @param mixed $subject
     *
     * @return array
     */
    protected static function ensureArray($subject)
    {
        if (is_array($subject)) {
            return $subject;
        }
        if ($subject instanceof Collection) {
            return $subject->all();
        }
        if (is_null($subject)) {
            return [];
        }

        return [$subject];
    }
}
