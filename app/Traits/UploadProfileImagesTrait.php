<?php

namespace App\Traits;

trait UploadProfileImagesTrait {

   public function moveFileToDirectory($image, $documentRoot, $newFile, $modelUserProfile, $id)
   {

       if (preg_match_all('/\.(jpg|png|jpeg|gif)$/', $newFile)) {
           $directoryFolder = $modelUserProfile->getAvatarImage($id);
           $outputDir = null;
           foreach ($directoryFolder as $dir) {
               $outputDir[] = $dir->avatar;
           }
           $path = implode('/', $outputDir);
           $lastPart = strrchr($path, '\\');
           $destinyPath = $documentRoot . substr($path, 0, (strlen($path) - strlen($lastPart))) . '\\';
           $save = $image->move($destinyPath, $newFile);
           $saveFilename = $save;
           if (isset($saveFilename)) {
               $upload['upload'] = $saveFilename;
           }
       }
      return $upload['upload'];
   }
}