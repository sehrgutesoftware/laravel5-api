<?php

namespace SehrGut\Laravel5_Api\Hooks;

use ArrayAccess;

interface FormatCollection
{
    /**
     * This hook receives a Collection of resources before they are transformed.
     *
     * @param ArrayAccess $collection
     *
     * @return ArrayAccess The modified Collection
     */
    public function formatCollection(ArrayAccess $collection);
}
