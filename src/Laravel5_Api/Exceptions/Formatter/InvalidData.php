<?php

namespace SehrGut\Laravel5_Api\Exceptions\Formatter;

class InvalidData extends FormatterException
{
    /**
     * {@inheritdoc}
     */
    protected $message = 'Data must be either Collection or Model.';

    /**
     * {@inheritdoc}
     */
    protected $status = 500;
}
