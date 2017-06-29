<?php

namespace SehrGut\Laravel5_Api\Hooks;

use Illuminate\Database\Eloquent\Model;

interface FormatResource
{
    /**
     * This hook receives a single resource before it is transformed.
     *
     * @param Model $resource
     *
     * @return Model The modified resource
     */
    public function formatResource(Model $resource);
}
