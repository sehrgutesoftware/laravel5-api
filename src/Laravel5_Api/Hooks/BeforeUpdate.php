<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface BeforeUpdate extends Hook
{
    /**
     * This Hook is called before a resource is update (on update action).
     *
     * @param  Context $context
     * @return Context
     */
    public function beforeUpdate(Context $context);
}
