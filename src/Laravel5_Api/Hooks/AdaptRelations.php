<?php

namespace SehrGut\Laravel5_Api\Hooks;

interface AdaptRelations extends Hook
{
    /**
     * This hook receives an array of relations to be side-loaded with the queried model.
     *
     * @param array $relations
     *
     * @return array
     */
    public function adaptRelations(array $relations);
}
