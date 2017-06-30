<?php

namespace SehrGut\Laravel5_Api\Hooks;

interface FormatCollection
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
