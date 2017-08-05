<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface BeginAction extends Hook
{
    /**
     * This is the first hook in any action, right after $context->action was set.
     *
     * @param Context $context
     *
     * @return Context
     */
    public function beginAction(Context $context);
}
