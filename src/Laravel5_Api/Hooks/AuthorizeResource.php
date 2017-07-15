<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface AuthorizeResource extends Hook
{
    /**
     * Hook in here to check authorization for a single resource (db record).
     *
     * Throw an exception if the check fails, otherwise return $action.
     * The resource can be retrieved as `$this->controller->resource`.
     *
     * @param  Context $context
     * @return Context
     */
    public function authorizeResource(Context $context);
}
