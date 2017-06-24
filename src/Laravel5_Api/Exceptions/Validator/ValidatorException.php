<?php

namespace SehrGut\Laravel5_Api\Exceptions\Validator;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use SehrGut\Laravel5_Api\Exceptions\Exception as BaseException;

class ValidatorException extends BaseException
{
    /**
     * The error message displayed to the user.
     *
     * @var string
     */
    protected $message = 'Error validating input';

    /**
     * The HTTP status code to respond with on this exception.
     *
     * @var int
     */
    protected $status = 400;

    /**
     * Holds the validation errors.
     *
     * @var MessageBag
     */
    protected $fields;

    public function __construct(MessageBag $fields)
    {
        parent::__construct();
        $this->fields = $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function errorResponse()
    {
        return new JsonResponse([
                'error' => [
                    'message' => $this->message,
                    'status'  => $this->status,
                    'fields'  => $this->fields,
                ],
            ],
            $this->status
        );
    }
}
