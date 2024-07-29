<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class InvalidSalarySetException extends Exception
{
    public function __construct(string $message = "Invalid Salary Set!", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
