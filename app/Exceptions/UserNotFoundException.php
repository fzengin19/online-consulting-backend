<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserNotFoundException extends HttpException
{

    public function __construct(string $message = 'Email or password incorrect.', int $status = 404)
    {
        parent::__construct($status, $message);
    }
}
