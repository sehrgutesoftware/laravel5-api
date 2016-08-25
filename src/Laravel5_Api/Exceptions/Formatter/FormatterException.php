<?php

namespace SehrGut\Laravel5_Api\Exceptions\Formatter;

use SehrGut\Laravel5_Api\Exceptions\Exception as BaseException;

class FormatterException extends BaseException
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'Error while formatting response';

    /**
     * {@inheritdoc}
     */
    protected $status = 500;
}