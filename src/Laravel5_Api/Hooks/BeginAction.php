<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This is the first hook in any action, right after `$context->action` was set.
 */
interface BeginAction extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function beginAction();
}
