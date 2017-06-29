<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Support\Collection;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;

/**
 * This plugin separates relations from the actually requested models
 * and puts them under separate keys in the response payload.
 */
class RelationSplitter extends Plugin implements FormatCollection
{
    protected $default_config = [
        'result_key' => 'result',
        'includes_key' => 'includes'
    ];

    protected $includes = [];

    /** {@inheritdoc} */
    public function formatCollection(Array $collection)
    {
        $this->splitRelations($collection);

        $result = [
            $this->config['result_key'] => $collection,
            $this->config['includes_key'] => $this->uniqueIncludes(),
        ];

        return $result;
    }

    /**
     * Separate the related models from each model in the passed-in collection.
     *
     * @param  mixed $collection
     * @return void
     */
    protected function splitRelations($collection)
    {
        $collection = $this->ensureArray($collection);

        foreach ($collection as $model) {
            // Check if the model has eloquent-like relations
            if (is_callable([$model, 'getRelations'])) {
                foreach ($model->getRelations() as $name => $relatives) {
                    // Save the relatives to the "includes" array
                    $this->includeRelatives($name, $relatives);
                    // Repeat the entire process for relatives (recurse)
                    $this->splitRelations($relatives);
                }
                // Remove all relatives from all relations on the model
                $model->setRelations([]);
            }
        }
    }

    /**
     * Add passed-in relatives to `$this->includes` under the `$name` key.
     *
     * @param  String $name
     * @param  mixed $relatives
     * @return void
     */
    protected function includeRelatives(String $name, $relatives)
    {
        $relatives = $this->ensureArray($relatives);

        if (!array_key_exists($name, $this->includes)) {
            $this->includes[$name] = [];
        }

        $this->includes[$name] = array_merge($this->includes[$name], $relatives);
    }

    /**
     * Wrap the subject into an array if it's not already an
     * array, convert it to array if it's a collection.
     *
     * @param  mixed $subject
     * @return Array
     */
    protected function ensureArray($subject)
    {
        if (is_array($subject)) return $subject;
        if ($subject instanceof Collection) return $subject->all();
        return [$subject];
    }

    /**
     * Return all includes after removing duplicates.
     *
     * @return Array
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