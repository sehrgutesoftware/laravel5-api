<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Support\Collection;
use SehrGut\Laravel5_Api\Context;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;
use SehrGut\Laravel5_Api\Hooks\FormatResource;

/**
 * This plugin separates relations from the actually requested models
 * and puts them under separate keys in the response payload.
 */
class RelationSplitter extends Plugin implements FormatCollection, FormatResource
{
    /**
     * Config options for this plugin:.
     *
     * - `result_key`: The key under which the actual results will appear in the response payload
     * - `includes_key`: The key under which the extracted relations will appear in the response payload
     * - `replace_with_ids`: Whether to replace the removed relations with their ids on the parent model
     *
     * @var array
     */
    protected $default_config = [
        'result_key'       => 'result',
        'includes_key'     => 'includes',
        'replace_with_ids' => true,
        'ignore_relations' => [],
    ];

    protected $includes = [];

    /** {@inheritdoc} */
    public function formatCollection(Context $context)
    {
        $this->splitRelations($context->collection);

        $context->collection = [
            $this->config['result_key']   => $context->collection,
            $this->config['includes_key'] => $this->uniqueIncludes(),
        ];

        return $context;
    }

    /** {@inheritdoc} */
    public function formatResource(Context $context)
    {
        $this->splitRelations($context->resource);

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
    protected function splitRelations($collection)
    {
        $collection = $this->ensureArray($collection);

        foreach ($collection as $model) {
            // Check if the model has eloquent-like relations
            if (is_callable([$model, 'getRelations'])) {

                // Save away the ids for merging them later
                $ids = [];

                foreach ($model->getRelations() as $name => $relatives) {
                    // Skip relations listed in config['ignore_relations']
                    if (!in_array($name, $this->config['ignore_relations'])) {

                        // Save the relatives to the "includes" array
                        $ids[$name] = $this->includeRelatives($name, $relatives);
                        // Repeat the entire process for relatives (recurse)
                        $this->splitRelations($relatives);
                    }
                }

                // Remove all relatives from all relations on the model
                $model->setRelations([]);

                // Add relative's ids instead to the model
                if ($this->config['replace_with_ids']) {
                    foreach ($ids as $relation => $relative_ids) {
                        $model[$relation] = $relative_ids;
                    }
                }
            }
        }
    }

    /**
     * Add passed-in relatives to `$this->includes` under the `$name` key.
     *
     * @param string $name
     * @param mixed  $relatives
     *
     * @return void
     */
    protected function includeRelatives(String $name, $relatives)
    {
        $relatives = $this->ensureArray($relatives);

        if (!array_key_exists($name, $this->includes)) {
            $this->includes[$name] = [];
        }

        $this->includes[$name] = array_merge($this->includes[$name], $relatives);

        if ($this->config['replace_with_ids']) {
            return array_map(function ($model) {
                return $model->getKey();
            }, $relatives);
        }
    }

    /**
     * Wrap the subject into an array if it's not already an
     * array, convert it to array if it's a collection.
     *
     * @param mixed $subject
     *
     * @return array
     */
    protected function ensureArray($subject)
    {
        if (is_array($subject)) {
            return $subject;
        }
        if ($subject instanceof Collection) {
            return $subject->all();
        }

        return [$subject];
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
}
