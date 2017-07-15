<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface BeforeRespond extends Hook
{
    /**
     * Hook in here to manipulate the response headers or other stuff before responding.
     *
     * @param Context $context
     *
     * @return Context
     */
    public function beforeRespond(Context $context);
}
