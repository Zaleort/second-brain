<?php

namespace App\Categories\Domain;

class CustomException extends \Exception
{
    private int $httpCode;

    public function __construct(string $message = "", int $httpCode = 500)
    {
        $this->httpCode = $httpCode;
        parent::__construct($message);
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

}