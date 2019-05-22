<?php

namespace App\Traits;

trait GetFilesTrait {

    public function getDirectoryElements($file)
    {
        if ($file) {
            $path = strstr($file, 'img');
            return '/' . $path;
        }
    }

    public function getDirectoryUserProfilesFromServer($documentRoot, $id)
    {
        $listOfFolders = glob($documentRoot . '/img/profiles/' . "*");
        $folders = [];
        foreach ($listOfFolders as $folder) {
           if (preg_match("/_{$id}_/", $folder)) {
               $folders[] = $folder;
           }
        }
        return $folders;
    }

    public function getDirectoryUserProfiles($modelUserProfile, $id)
    {

        if (!is_object($modelUserProfile)) {
            return false;
        }
        $directoryFolder = $modelUserProfile->getAvatarImage($id);
        foreach ($directoryFolder as $folder)
        $substr = strstr($folder->avatar, 'profiles');
        $splitStrArr = explode("/", $substr);
        $endPos = strrpos($splitStrArr[1], '\\');
        $targetPartString = substr($splitStrArr[1], 0, $endPos);
        return $targetPartString . '/';

    }

    public function getFileNameFromUserProfile($modelUserProfile, $id)
    {

        if (!is_object($modelUserProfile)) {
            return false;
        }
        $directoryFolder = $modelUserProfile->getAvatarImage($id);
        foreach ($directoryFolder as $folder)
        $substr = strstr($folder->avatar, 'profiles');
        $splitStrArr = explode("/", $substr);
        $targetPartString = strstr($splitStrArr[1], '\\');
        $fileName = substr($targetPartString, 1, strlen($targetPartString));
        return $fileName;

    }

    public function getPermanentAccessGuestUserId($pathToProfile, $file, $modelUser, $input)
    {
        if (!is_object($modelUser)) {
            return false;
        }

        if (!file_exists($pathToProfile)) {
            mkdir($pathToProfile, 0777, true);
            fopen($pathToProfile.$file, 'w+');
        }

        isset($input) ? file_put_contents($pathToProfile.$file, $input) : null;
        $readFile = file_get_contents($pathToProfile.$file);
        $tabIdGuest = $modelUser->getIdByUserId($readFile);
        $containerIdGuest = null;
        foreach ($tabIdGuest as $t) {
            $containerIdGuest = $t->id;
        }
        return $containerIdGuest;
    }

    public function buildFullPathForImage($request, $users, $paths, $returnType, $newFile = null)
    {
        switch ($returnType) {
            case 'new_file':
                return rand() . $users['username_host'] . '.' . $request->file('profile_image')->getClientOriginalExtension();
            break;
            case 'full_path':
                return $paths['catalogue'] . DIRECTORY_SEPARATOR . $newFile;
            break;
        }
    }
}