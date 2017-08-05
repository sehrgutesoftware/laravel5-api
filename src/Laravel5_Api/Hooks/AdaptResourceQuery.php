<?php

namespace SehrGut\Laravel5_Api\Hooks;

/**
 * This is called on "single resource" requests after the request
 * parameters have been applied, before the record is retrieved.
 */
interface AdaptResourceQuery extends Hook
{
    /**
     * Apply the hook.
     *
     * @return void
     */
    public function adaptResourceQuery();
}
