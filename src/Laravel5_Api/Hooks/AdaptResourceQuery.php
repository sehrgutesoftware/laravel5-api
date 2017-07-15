<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface AdaptResourceQuery extends Hook
{
    /**
     * This hook receives the query on "single resource" requests after the
     * request parameters have been applied, before the record is retrieved.
     *
     * @param  Context $context
     * @return Context
     */
    public function adaptResourceQuery(Context $context);
}
