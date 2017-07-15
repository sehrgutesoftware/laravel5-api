<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface BeforeCreate extends Hook
{
    /**
     * This Hook is called before a resource created (on store action).
     *
     * @param  Context $context
     * @return Context
     */
    public function beforeCreate(Context $context);
}
