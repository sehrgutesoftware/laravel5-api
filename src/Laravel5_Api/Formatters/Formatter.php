<?php

namespace SehrGut\Laravel5_Api\Formatters;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SehrGut\Laravel5_Api\Controller;
use SehrGut\Laravel5_Api\Exceptions\Formatter\InvalidData;
use SehrGut\Laravel5_Api\ModelMapping;

class Formatter
{
    /**
     * The Content-Type this Formatter returns.
     *
     * @var string
     */
    public $content_type = 'application/json';

    /**
     * Holds the mapping used to determine the
     * appropriate Transformer for each Model.
     *
     * @var ModelMapping
     */
    protected $mapping;

    /**
     * Holds the instanced of the calling controller.
     *
     * @var Controller
     */
    protected $controller;

    /**
     * Create a new instance.
     *
     * @param ModelMapping $mapping    The ModelMapping to use to determine the correct Validator/Transformer for each formatted record
     * @param Controller   $controller The controller instance that this call originates from
     */
    public function __construct(ModelMapping $mapping, Controller $controller)
    {
        $this->mapping = $mapping;
        $this->controller = $controller;
    }

    /**
     * Generate a HTTP response body from an Eloquent Collection or Model.
     *
     * @param mixed $data An Eloquent Collection or Model
     *
     * @throws InvalidData In case the input is neither Model nor Collection
     *
     * @return string A response body
     */
    public function format($data)
    {
        if ($data instanceof Model) {
            $formatted_data = $this->formatResource($data);
        } elseif ($data instanceof Collection) {
            $formatted_data = $this->formatCollection($data);
        } else {
            throw new InvalidData();
        }

        return $this->serialize($formatted_data);
    }

    /**
     * Format a single record.
     *
     * @param Model $model The Eloquent Model instance to format
     *
     * @return array
     */
    protected function formatResource(Model $model)
    {
        return $this->transform($model);
    }

    /**
     * Format an entire collection.
     *
     * @param Collection $collection The Eloquent Collection to format
     *
     * @return array
     */
    protected function formatCollection(Collection $collection)
    {
        $that = $this;

        return $collection->map(function ($model) use ($that) {
            return $that->formatResource($model);
        });
    }

    /**
     * Turn the transformed data into a JSON string.
     *
     * @param array $data The raw data array
     *
     * @return string
     */
    protected function serialize($data)
    {
        return json_encode($data);
    }

    /**
     * Apply the transformer to an Eloquent Model.
     *
     * @param Model $model The Eloquent Model instance to transform
     *
     * @return array
     */
    protected function transform(Model $model)
    {
        $transformer = $this->mapping->getTransformerFor(get_class($model));

        return $transformer->transform($model);
    }
}
