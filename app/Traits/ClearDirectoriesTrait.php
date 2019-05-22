<?php

namespace App\Traits;

trait ClearDirectoriesTrait {

    public function removeRedundantDirectoriesImg($directory_files, $id, $username)
    {
        if (is_dir($directory_files)) {
            $listFolders = glob($directory_files . "*");
            $storeFolders = null;
            $storeFoldersSorting = null;
            foreach ($listFolders as $file) {
                $storeFolders[filemtime($file)] = $file;
            }
            ksort($storeFolders);
            $storeFolders = array_reverse($storeFolders, true);
            foreach ($storeFolders as $key => $list) {
                $storeFoldersSorting[] = $list;
            }

            $subStr = strstr(implode("profiles", $storeFoldersSorting), '_');
            $split = explode("profiles", $subStr);
            $pattern = null;
            foreach ($split as $key => $value) {
                if ($key % 2 == 0) {
                    $pattern[] = $value;
                }
            }
            $toRemove = null;
            array_pop($pattern);
            foreach ($pattern as $key => $value) {
                if (preg_match("/_{$id}_/", $value)) {
                    if ($key == 0) {
                        $toRemove[] = $directory_files . "/" . $username . $value;
                    } else {
                        $toRemove[] = $directory_files . $value;
                    }
                }
            }
            for ($i = 0; $i < count($toRemove); $i++) {
                rmdir($toRemove[$i]);
            }
        }
    }
}