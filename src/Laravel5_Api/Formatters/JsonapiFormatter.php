<?php

namespace SehrGut\Laravel5_Api\Formatters;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

use SehrGut\Laravel5_Api\Exceptions\Formatter\InvalidData;

class JsonapiFormatter extends Formatter
{

    /**
     * {@inheritdoc}
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

        $wrapped_data = [
            'links' => [
                'self' => $this->controller->request->url()
            ],
            'data' => $formatted_data,
        ];

        return $this->serialize($wrapped_data);
    }

    /**
     * {@inheritdoc}
     *
     * WARNING: Any attribute named `type` or `id` will
     * be removed according to the jsonapi spec!
     */
    protected function formatResource(Model $model)
    {
        // `id` and `type` are forbidden as attribute names in the jsapi spec
        $attributes = array_except($this->transform($model), ['id', 'type']);

        $resource = [
            'id' => $model->getKey(),
            'type' => $this->getModelType($model),
            'links' => [
                'self' => $this->mapping->getUrlFor($model)
            ],
            'attributes' => $attributes,
        ];

        // dd($model->getRelations());
        // $relations = [];
        // foreach ($model->getRelations() as $name => $relation) {
        //     $relations[$name] = [
        //         'links' => [
        //             'self' => $this->mapping->getUrlFor($model).'/'.$this->getModelType($relation)
        //         ],
        //         'data' => [
        //             'type' => $this->getModelType($relation),
        //             'id' => $relation->getKey(),
        //         ]
        //     ];
        // }
        // if (count($relations) > 0) {
        //     $resource['relationships'] = $relations;
        // }

        return $resource;
    }

    /**
     * master(Functional programming)
     *
     * @param  Model  $model
     * @return string
     */
    protected function getModelType(Model $model)
    {
        return str_slug(str_plural(snake_case(class_basename($model))));
    }
}