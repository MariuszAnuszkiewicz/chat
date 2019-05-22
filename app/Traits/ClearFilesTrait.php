<?php

namespace App\Traits;

trait ClearFilesTrait {

    public function removeRedundantFiles($directory_files)
    {
        if (file_exists($directory_files)) {
            $listFiles = glob($directory_files . "*");
            $storeFile = null;
            foreach ($listFiles as $file) {
                $storeFile[] = $file;
                for ($i = 0; $i < count($storeFile); $i++) {
                    unlink($storeFile[$i]);
                }
            }
        }
    }
}