<?php

namespace SehrGut\Laravel5_Api\Hooks;

interface AuthorizeAction
{
    /**
     * Hook in here to check authorization for an action in general
     * (before any records are fetched from the db).
     *
     * Throw an exception if the check fails, otherwise return $action.
     *
     * Possible values for `$action` are:
     * - index
     * - store
     * - show
     * - update
     * - destroy
     *
     * @param string $action Name of the action to check
     *
     * @return string
     */
    public function authorizeAction(String $action);
}
