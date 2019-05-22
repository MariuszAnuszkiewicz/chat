<?php

namespace App\Exceptions;

use Exception;

class PageNotFoundHttpException extends Exception
{
    public function render($request)
    {
        dd("PageNotFoundHttpException");
    }

    public function some()
    {
        dd("X");
    }
}
