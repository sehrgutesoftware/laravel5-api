<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * A dummy hook for testing that is regularly not called from the controller.
 */
interface TestHook extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function testHook();
}
