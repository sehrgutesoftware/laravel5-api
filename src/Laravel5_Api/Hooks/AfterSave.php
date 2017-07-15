<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface AfterSave extends Hook
{
    /**
     * This Hook is called after a resource is saved (on store & update actions).
     *
     * @param Context $context
     *
     * @return Context
     */
    public function afterSave(Context $context);
}
