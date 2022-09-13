<?php

namespace App\Categories\Application\CreateCategory;

use App\Categories\Domain\CustomException;

class CategoryAlreadyExistsException extends CustomException
{
    public function __construct(string $message = "")
    {
        parent::__construct($message, 409);
    }
}