<?php

namespace AceCore\src\CreateServer;

use AceCore\src\Core\Core;
use AceCore\src\CreateServer\Async\CopyAsyncTask;

class CreateServer {
    const USER = "/home/ace/";
    /** @var string  */
    public static string $plugins = self::USER . "Plugins";
    /** @var string  */
    public static string $maps = self::USER . "Maps";
    /** @var string */
    public static string $servers = self::USER . "Servers";

    /**
     * @param string $name
     * @param int $port
     * @param string $type
     * @param int $team
     * @return void
     */
    public static function add(string $name, int $port, string $type, int $team): void {
        Core::getInstance()->getServer()->getAsyncPool()->submitTask(new CopyAsyncTask($name, $port, $type, $team));
    }

    /**
     * @param string $dir
     * @return void
     */
    public static function remove(string $dir): void {
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullPath = $dir . "/" . $file;
                if (!is_dir($fullPath)) @unlink($fullPath); else CreateServer::remove($fullPath);
            }
        }
        closedir($dh);
        if (@rmdir($dir)) return true; else return false;
    }
}