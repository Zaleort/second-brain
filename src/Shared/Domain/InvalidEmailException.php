<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Categories\Domain\CustomException;

class InvalidEmailException extends CustomException
{

    public function __construct()
    {
        parent::__construct('Invalid email', 400);
    }
}