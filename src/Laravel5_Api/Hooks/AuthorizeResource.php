<?php

namespace SehrGut\Laravel5_Api\Hooks;

interface AuthorizeResource
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
     * @param  String $action Name of the action to check
     * @return String
     */
    public function authorizeResource(String $action);
}
