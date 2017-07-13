<?php

namespace SehrGut\Laravel5_Api\Exceptions;

use SehrGut\Laravel5_Api\Exceptions\Exception as BaseException;

class Unauthorized extends BaseException
{
    protected $message = 'Not authorized!';
    protected $status = 403;
}
