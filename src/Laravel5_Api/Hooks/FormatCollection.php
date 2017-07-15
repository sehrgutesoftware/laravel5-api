<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface FormatCollection extends Hook
{
    /**
     * This hook receives a Collection of resources before they are transformed.
     *
     * @param Context $context
     *
     * @return Context
     */
    public function formatCollection(Context $context);
}
