<?php

namespace SehrGut\Laravel5_Api\Hooks;

interface AuthorizeResource extends Hook
{
    /**
     * Hook in here to check authorization for a single resource (db record).
     *
     * Throw an exception if the check fails, otherwise return $action.
     * The resource can be retrieved as `$this->controller->resource`.
     *
     * Possible values for `$action` are:
     * - show
     * - update
     * - destroy
     *
     * @param string $action Name of the action to check
     *
     * @return string
     */
    public function authorizeResource(String $action);
}
