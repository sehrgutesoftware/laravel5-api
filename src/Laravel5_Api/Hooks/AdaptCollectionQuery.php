<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This is called on "index requests" after the request parameters
 * have been applied, before the records are retrieved.
 */
interface AdaptCollectionQuery extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function adaptCollectionQuery();
}
