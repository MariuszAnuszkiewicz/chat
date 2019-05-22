<?php

namespace App\Classes;

use App\User;

class DataStore
{
    const DATA_FILE = 'data.txt';
    const DEFAULT_FILE = 'default-avatar.jpg';
    private $username = [];

    public function generatePathForGuestFile($username, $id)
    {
        $catalogue = $username . '_' . $id . md5("149a^@$34dDFte242");
        return public_path('\data\profiles\\') . $catalogue. "\\";
    }

    public function storeUsername(User $modelUser, $id, $typeValue, $keyValue)
    {
        foreach ($modelUser->getUsernameById($id) as $key => $value) {
            if ($key == $keyValue) {
                $this->username[$key] = $value->name;
            }
        }
        switch ($typeValue) {
            case "array":
                return $this->username;
            break;
            case "string":
                return implode(" ", $this->username);
            break;
        }
    }
}