<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This Hook is called before a resource is updated (update action).
 */
interface BeforeUpdate extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function beforeUpdate();
}
