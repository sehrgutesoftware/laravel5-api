<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Database\Eloquent\Builder;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;

class Order extends Plugin implements AdaptCollectionQuery
{
    protected $default_config = [
        'query_param' => 'order',
        'allowed_attributes' => [],
    ];

    public function adaptCollectionQuery(Builder $query)
    {
        $rules = $this->controller
            ->request_adapter
            ->getValueByKey($this->config['query_param'], null);

        if (!is_array($rules) OR count($rules) < 1) {
            return $query;
        }

        $allowed_attributes = $this->flattenAllowedAttributes();

        $query = $this->joinRelations($query, $rules);

        foreach ($rules as $field => $direction) {
            if (in_array($field, $allowed_attributes)) {
                $query = $this->applyRule($query, $field, $direction);
            }
        }

        return $query;
    }

    protected function applyRule(Builder $query, $field, $direction)
    {
        return $query->orderBy($field, $direction);
    }

    protected function joinRelation(Builder $query, String $field)
    {

    }

    protected function flattenAllowedAttributes()
    {
       $dotted_array = [];
       $allowed_attributes = array_dot($this->config['allowed_attributes']);
       foreach ($allowed_attributes as $key => $value) {
            if (is_int($key)) {
               $dotted_array[] = $value;
            } else {
                $fragments = explode('.', $key);
                array_pop($fragments);
                $dotted_array[] = implode('.', $fragments);
            }
       }
       return $dotted_array;
    }
}
