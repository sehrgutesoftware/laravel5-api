<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * Hook in here to check authorization for a single resource (db record).
 */
interface AuthorizeResource extends Hook
{
    /**
     * Apply the hook.
     *
     * Throw an exception if the check fails.
     *
     * @return void
     */
    public function authorizeResource();
}
