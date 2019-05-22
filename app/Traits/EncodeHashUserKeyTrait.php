<?php

namespace App\Traits;

trait EncodeHashUserKeyTrait {
   use HashUserKeyTrait;

    public function encodeHashKey($name, $id, $pattern)
    {
         $status = false;
         if ($this->createHashKey($name, $id) == $pattern) {
            $status = true;
         }
         return $status;
    }
}