<?php

namespace Core\Utils;

class Copy {
    /**
     * @param string $dirCopy
     * @param string $dirPaste
     * @return bool
     */
    public static function copyFile(string $dirCopy, string $dirPaste): bool {
        return copy($dirCopy, $dirPaste);
    }

    /**
     * @param string $dirTarget
     * @param string $dirLink
     * @return bool
     */
    public static function symLink(string $dirTarget, string $dirLink): bool {
        return symlink($dirTarget, $dirLink);
    }

    /**
     * @param string $source
     * @param string $dest
     * @return bool
     */
    public static function copyDir(string $source, string $dest): bool {
        $cDir = scandir($source);
        @mkdir($dest);
        foreach ($cDir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($source . DIRECTORY_SEPARATOR . $value)) {
                    @mkdir($dest . DIRECTORY_SEPARATOR . $value);
                    Copy::copyDir($source . DIRECTORY_SEPARATOR . $value, $dest . DIRECTORY_SEPARATOR . $value);
                    return true;
                } else {
                    Copy::copyFile($source . DIRECTORY_SEPARATOR . $value, $dest . DIRECTORY_SEPARATOR . $value);
                }
            }
        }
        return false;
    }
}