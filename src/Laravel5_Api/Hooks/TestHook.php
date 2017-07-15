<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

/**
 * A dummy hook for testing that is regularly not called from the controller.
 */
interface TestHook extends Hook
{
    /**
     * Just pass in anything here…
     *
     * @param  Context $context
     * @return Context
     */
    public function testHook(Context $context);
}
