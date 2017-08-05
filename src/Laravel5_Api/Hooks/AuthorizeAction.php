<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * Hook in here to check authorization for an action in general
 * (before any records are fetched from the db).
 */
interface AuthorizeAction extends Hook
{
    /**
     * Apply the hook.
     *
     * Throw an exception if the check fails, otherwise return $action.
     *
     * @return void
     */
    public function authorizeAction();
}
