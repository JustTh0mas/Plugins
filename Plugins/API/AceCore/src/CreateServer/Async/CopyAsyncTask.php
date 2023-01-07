<?php

namespace AceCore\src\CreateServer\Async;

use AceCore\src\Core\Utils\Copy;
use AceCore\src\Core\Utils\Network;
use AceCore\src\CreateServer\CreateServer;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\Config;

class CopyAsyncTask extends AsyncTask {
    /** @var string  */
    public string $name;
    /** @var int  */
    public int $port;
    /** @var string  */
    public string $type;
    /** @var int  */
    public int $team;

    /**
     * @param string $name
     * @param int $port
     * @param string $type
     * @param int $team
     */
    public function __construct(string $name, int $port, string $type, int $team) {
        $this->name = $name;
        $this->port = $port;
        $this->type = $type;
        $this->team = $team;
    }

    public function onRun() {
        $name = $this->name;
        $port = $this->port;
        $type = $this->type;
        $team = $this->team;
        $dir = CreateServer::$servers . "/" . $name;
        if (is_dir($dir)) return;
        $config = $dir . "/plugin_data/GAME";
        @mkdir($dir);
        @mkdir($dir . "/worlds");
        @mkdir($dir . "/plugins");
        @mkdir($dir . "/plugin_data");
        @mkdir($dir . "/plugin_data/GAME");
        Copy::copyDir("bin/", $dir . "/bin");
        Copy::copyFile("plugins/DevTools.phar", $dir . "/plugin/DevTools.phar");
        Copy::copyFile( "PocketMine-MP.phar", $dir . "/PocketMine-MP.phar");
        Copy::copyFile( "pocketmine.yml", $dir . "/pocketmine.yml");
        Copy::copyFile( "server.properties", $dir . "/server.properties");
        Copy::copyFile( "ops.txt", $dir . "/ops.txt");
        Copy::copyFile( "start.sh", $dir . "/start.sh");
        $properties = new Config($dir . "/server.properties", Config::PROPERTIES);
        $properties->set("server-port", $port);
        $properties->save();
        $plugins = ["API/AceCore"];
        $maps = [];
        $maps["/Lobby/WaitLobby/"] = ["lobby"];
        switch ($type) {
            case Network::GAME["BEDWARS"]:
                $plugins[] = "API/gameapi";
                $plugins[] = "Mini-Games/Bedwars";
                switch ($team) {
                    case Network::SOLO:
                        Copy::copyFile( CreateServer::$maps . "/Bedwars/Solo/" . "arena.yml", $config . "/" . "arena.yml");
                        $maps["/Bedwars/Solo"] = ["game"];
                        break;
                    case Network::DUO:
                        Copy::copyFile( CreateServer::$maps . "/Bedwars/Duo/" . "arena.yml", $config . "/" . "arena.yml");
                        $maps["/Bedwars/Duo"] = ["game"];
                        break;
                    case Network::TRIO:
                        Copy::copyFile( CreateServer::$maps . "/Bedwars/Trio/" . "arena.yml", $config . "/" . "arena.yml");
                        $maps["/Bedwars/Trio"] = ["game"];
                        break;
                    case Network::SQUAD:
                        Copy::copyFile( CreateServer::$maps . "/Bedwars/Squad/" . "arena.yml", $config . "/" . "arena.yml");
                        $maps["/Bedwars/Squad"] = ["game"];
                        break;
                }
                break;
        }
        foreach ($plugins as $plugin) {
            $ch = explode("/", $plugin);
            $namePlugin = $ch[count($ch) - 1];
            $plugin = "/" . $plugin;
            $dirPlugin = $dir . "/plugins/" . $namePlugin;
            @mkdir($dirPlugin);
            Copy::copyDir( CreateServer::$plugins . $plugin, $dirPlugin);
        }
        foreach ($maps as $d => $map) {
            foreach ($map as $m) {
                $m = "/" . $m;
                $dirWorlds = $dir . "/worlds" . $m;
                @mkdir($dirWorlds);
                Copy::copyDir( CreateServer::$maps . $d . $m, $dirWorlds);
            }
        }

        chmod($dir . "/start.sh", 0777);
        chmod($dir . "/bin/php7/bin/php", 0777);
        shell_exec("screen -d -m -S {$type}_{$name} bash -c 'cd $dir && ./start.sh'");
    }

    /**
     * @param Server $server
     * @return void
     */
    public function onCompletion(Server $server) {
    }
}