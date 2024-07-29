<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidCredentialsException extends HttpException
{
    public function __construct(string $message = 'Email or password incorrect.', int $status = 401)
    {
        parent::__construct($status, $message);
    }
}
