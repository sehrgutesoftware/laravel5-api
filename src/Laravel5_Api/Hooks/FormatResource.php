<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface FormatResource extends Hook
{
    /**
     * This hook receives a single resource before it is transformed.
     *
     * @param  Context $context
     * @return Context
     */
    public function formatResource(Context $context);
}
