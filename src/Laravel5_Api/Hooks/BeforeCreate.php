<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This Hook is called before a resource created (on store action).
 */
interface BeforeCreate extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function beforeCreate();
}
