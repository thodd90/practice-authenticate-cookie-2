<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ObjectNotFoundException extends BaseException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_NOT_FOUND);
    }
}
