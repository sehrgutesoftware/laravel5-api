<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This Hook is called after a resource is saved (on store & update actions).
 */
interface AfterSave extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function afterSave();
}
