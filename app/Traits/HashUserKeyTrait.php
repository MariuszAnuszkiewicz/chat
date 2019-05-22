<?php

namespace App\Traits;

trait HashUserKeyTrait
{
    private $hash = "ihdaQ5@3!za";

    public function createHashKey($name, $id)
    {
        return $hash = $this->hash . sha1($this->hash . $name . "abgz67" . $id);
    }
}