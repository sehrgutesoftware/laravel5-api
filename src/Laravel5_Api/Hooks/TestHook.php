<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * A dummy hook for testing that is regularly not called from the controller.
 */
interface TestHook extends Hook
{
    /**
     * Just pass in anything here….
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public function testHook($input);
}
