<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This hook is called after the records have been retrieved
 * from the db and stored into `$context->collection`.
 */
interface FormatCollection extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function formatCollection();
}
