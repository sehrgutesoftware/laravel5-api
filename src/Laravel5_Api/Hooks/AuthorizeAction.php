<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface AuthorizeAction extends Hook
{
    /**
     * Hook in here to check authorization for an action in general
     * (before any records are fetched from the db).
     *
     * Throw an exception if the check fails, otherwise return $action.
     *
     * @return string
     */
    public function authorizeAction(Context $context);
}
