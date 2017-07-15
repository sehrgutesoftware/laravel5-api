<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface BeforeSave extends Hook
{
    /**
     * This Hook is called before a resource is saved (on store & update actions).
     *
     * @param  Context $context
     * @return Context
     */
    public function beforeSave(Context $context);
}
