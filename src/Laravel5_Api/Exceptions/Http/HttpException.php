<?php

namespace SehrGut\Laravel5_Api\Exceptions\Http;

use SehrGut\Laravel5_Api\Exceptions\Exception as BaseException;

class HttpException extends BaseException
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'HTTP Exception';

    /**
     * {@inheritdoc}
     */
    protected $status = 500;
}
