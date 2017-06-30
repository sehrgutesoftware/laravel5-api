<?php

namespace SehrGut\Laravel5_Api\Hooks;

interface ResponseHeaders
{
    /**
     * Hook in here to manipulate the response headers.
     *
     * @param array $headers Default headers.
     *
     * @return array Updated headers
     */
    public function responseHeaders(array $headers);
}
