<?php

namespace SehrGut\Laravel5_Api\Formatters;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use SehrGut\Laravel5_Api\Controller;
use SehrGut\Laravel5_Api\ModelMapping;
use SehrGut\Laravel5_Api\Exceptions\Formatter\InvalidData;

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

	public function __construct(ModelMapping $mapping, Controller $controller)
    {
        $this->mapping = $mapping;
        $this->controller = $controller;
    }

    /**
     * Generate a HTTP response body from an Eloquent Collection or Model.
     *
     * @param   mixed  $data  An Eloquent Collection or Model
     * @return  string  A response body
     * @throws  SehrGut\Laravel5_Api\Exceptions\Formatter\InvalidData  In case the input is neither Model nor Collection
     */
    public function format($data)
    {
        if ($data instanceof Model) {
            $formatted_data = $this->formatResource($data);
        }
        elseif ($data instanceof Collection) {
            $formatted_data = $this->formatCollection($data);
        }
        else {
            throw new InvalidData();
        }
        return $this->serialize($formatted_data);
    }

    protected function formatResource(Model $model)
    {
        return $this->transform($model);
    }

    protected function formatCollection(Collection $collection)
    {
        $that = $this;
        return $collection->map(function($model) use ($that) {
            return $that->formatResource($model);
        });
    }

    protected function serialize($data)
    {
        return json_encode($data);
    }

    protected function transform(Model $model)
    {
        $transformer = $this->mapping->getTransformerFor(get_class($model));
        return $transformer->transform($model);
    }
}