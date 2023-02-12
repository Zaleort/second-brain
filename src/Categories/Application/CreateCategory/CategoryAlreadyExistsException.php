<?php

namespace App\Categories\Application\CreateCategory;

use App\Shared\Domain\Exceptions\CustomException;

class CategoryAlreadyExistsException extends CustomException
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 409);
    }
}