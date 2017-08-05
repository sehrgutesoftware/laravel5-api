<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This Hook is called before a resource is saved (on store & update actions).
 */
interface BeforeSave extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function beforeSave();
}
