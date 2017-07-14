<?php

namespace SehrGut\Laravel5_Api\Hooks;

interface FormatCollection extends Hook
{
    /**
     * This hook receives a Collection of resources before they are transformed.
     *
     * @param array $collection
     *
     * @return array The modified Collection
     */
    public function formatCollection(array $collection);
}
