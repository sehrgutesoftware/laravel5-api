<?php

namespace SehrGut\Laravel5_Api\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SehrGut\Laravel5_Api\ModelMapping;

/**
 * Responsible for applying transformations to Eloquent Models
 * in order to customize their representation at the API.
 */
class Transformer
{
    /**
     * Attributes or relations that shall appear under a different
     * key in the output.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Name the attributes that shall be omitted from the output.
     *
     * @var array
     */
    protected $drop_attributes = [];

    /**
     * Name the relations that shall be omitted from the output.
     *
     * @var array
     */
    protected $drop_relations = [];

    /**
     * Stores an instance of a model_mapping to retrieve transformers
     * for related models.
     *
     * @var ModelMapping
     */
    protected $model_mapping;

    /**
     * Holds the eloquent instance to be transformed.
     *
     * @var Model
     */
    protected $model;

    /**
     * Holds the array form of the model.
     *
     * @var array
     */
    protected $output = [];

    public function __construct(ModelMapping $model_mapping)
    {
        $this->model_mapping = $model_mapping;
    }

    /**
     * Transform a single eloquent record.
     *
     * @param Model $model The eloquent model record to transform
     *
     * @return array
     */
    public function transform(Model $model)
    {
        $this->model = null;
        $this->output = [];

        $this->model = $model;
        $this->output = $this->model->attributesToArray();
        $this->handleRelations();
        $this->dropAttributes();
        $this->formatAttributes();

        $this->alias();
        $this->beforeSerialize();

        return $this->serialize();
    }

    /**
     * Add the relations to the output.
     *
     * @return void
     */
    protected function handleRelations()
    {
        $relations = $this->model->getRelations();
        foreach ($relations as $name => $relation) {
            if (!in_array($name, $this->drop_relations)) {
                $this->addRelation($name, $relation);
            }
        }
    }

    /**
     * Add a single relation.
     *
     * @param string           $name
     * @param Model|Collection $relation
     */
    protected function addRelation(String $name, $relation)
    {
        $this->output[$name] = $this->transformAny($relation);
    }

    /**
     * Transform either Collection or Model using the known $model_mapping.
     *
     * @param Collection|Model $thing to transform
     *
     * @return array
     */
    public function transformAny($thing)
    {
        if ($thing instanceof Model) {
            $transformer = $this->model_mapping->getTransformerFor(get_class($thing));

            return $transformer->transform($thing);
        } elseif ($thing instanceof Collection) {
            return $thing->map(function ($item) {
                return $this->transformAny($item);
            });
        } elseif (is_array($thing)) {
            return array_map(function ($item) {
                return $this->transformAny($item);
            }, $thing);
        }

        return $thing;
    }

    protected function dropAttributes()
    {
        $this->output = array_except($this->output, $this->drop_attributes);
    }

    /**
     * Format all attributes if a function exists that matches their name.
     *
     * If you want to transform the attribute `post_type`, just define a
     * `formatPostType` method that takes the old value of the
     * attribute and returns a new one.
     *
     * @return void
     */
    protected function formatAttributes()
    {
        foreach (array_keys($this->output) as $key) {
            $method_name = camel_case('format_' . $key);
            if (method_exists($this, $method_name)) {
                $value = $this->model[$key];
                $this->output[$key] = call_user_func([$this, $method_name], $value);
            }
        }
    }

    /**
     * Apply all rules in $this->aliases and replace key accordingly in output.
     *
     * @return void
     */
    protected function alias()
    {
        foreach ($this->aliases as $old => $new) {
            if (array_key_exists($old, $this->output)) {
                $this->output[$new] = $this->output[$old];
                unset($this->output[$old]);
            }
        }
    }

    /**
     * Here you can hook in to change the output before serializing.
     *
     * @return void
     */
    protected function beforeSerialize()
    {
        //
    }

    /**
     * Serialize a single record to an array.
     *
     * @return array
     */
    protected function serialize()
    {
        return $this->output;
    }
}
