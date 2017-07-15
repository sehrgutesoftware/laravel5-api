<?php

namespace SehrGut\Laravel5_Api\Hooks;

use SehrGut\Laravel5_Api\Context;

interface AdaptCollectionQuery extends Hook
{
    /**
     * This hook receives the query on "index requests" after the request
     * parameters have been applied, before the records are retrieved.
     *
     * @param Context $context
     *
     * @return Context
     */
    public function adaptCollectionQuery(Context $context);
}
