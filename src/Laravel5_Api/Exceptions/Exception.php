<?php

namespace SehrGut\Laravel5_Api\Exceptions;

use Illuminate\Http\JsonResponse;

class Exception extends \Exception
{
    /**
     * The error message displayed to the user.
     *
     * @var string
     */
    protected $message = 'Internal Server Error';

    /**
     * The HTTP status code to respond with on this exception (if applicable).
     *
     * @var int
     */
    protected $status = 500;

    /**
     * Gather the message status and error and return
     * them as a formatted JSON response.
     *
     * @return [type] [description]
     */
    public function errorResponse()
    {
        return new JsonResponse([
            'error' => [
                'message' => $this->getMessage(),
                'status'  => $this->getStatus(),
            ],
        ], $this->getStatus());
    }

    /**
     * Get the HTTP status associated with this Exception (if applicable).
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
