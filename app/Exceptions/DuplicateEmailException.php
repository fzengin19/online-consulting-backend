<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DuplicateEmailException extends Exception
{
    protected $message;
    protected $statusCode;

    public function __construct(string $message = 'This email address is already registered.', int $statusCode = 409)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        parent::__construct($message, $statusCode);
    }

    public function report()
    {
    }

    public function render($request)
    {
        return new JsonResponse([
            'message' => $this->getMessage(),
            'errors' => [
                'email' => [$this->getMessage()],
            ],
        ], $this->statusCode);
    }
}
