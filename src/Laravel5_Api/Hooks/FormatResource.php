<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This hook is called after the singl record has been retrieved
 * from the db and stored into `$context->resource`.
 */
interface FormatResource extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function formatResource();
}
