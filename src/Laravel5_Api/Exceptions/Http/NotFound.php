<?php

namespace SehrGut\Laravel5_Api\Exceptions\Http;

class NotFound extends HttpException
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'Not Found';

    /**
     * {@inheritdoc}
     */
    protected $status = 404;
}
