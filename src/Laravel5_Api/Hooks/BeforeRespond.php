<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * Hook in here to manipulate the response headers or other stuff before responding.
 */
interface BeforeRespond extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function beforeRespond();
}
