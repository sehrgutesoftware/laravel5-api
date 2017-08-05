<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This hook receives an array of relations to be side-loaded with the queried model.
 */
interface AdaptRelations extends Hook
{
    /**
     * Apply the hook.
     *
     * @param array $relations
     *
     * @return array
     */
    public function adaptRelations(array $relations);
}
