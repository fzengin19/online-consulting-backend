<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class DuplicateEmailException extends HttpException
{
    public function __construct(string $message = 'This email address is already registered.', int $status = 409)
    {
        parent::__construct($status, $message);
    }
}
