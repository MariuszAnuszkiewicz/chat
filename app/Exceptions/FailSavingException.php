<?php

namespace App\Exceptions;

class FailSavingException extends Exception
{
    public function __toString()
    {
        return "Problem to save data: $this->getMessage()";
    }
}