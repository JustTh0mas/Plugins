<?php

namespace Core\Utils;

use Core\Core;
use CreateServer\CreateServer;
use pocketmine\utils\TextFormat as TF;

class Network {
    const GAME = [
        "FREEFORALL" => "ffa",
        "BEDWARS" => "bw",
    ];
    const SOLO = 1, DUO = 2, TRIO = 3, SQUAD = 4;
    const IP = "185.157.247.59";
    const GAMES = [
        TF::RED . "FreeForAll" => self::GAME["FREEFORALL"],
        TF::YELLOW . "Bedwars" => self::GAME["BEDWARS"],
    ];
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @return array
     */
    public function getPort(): array {
        $network = $this->plugin->getNetworkAPI();
        return $network->getAll(true);
    }

    /**
     * @return array
     */
    public function getNames(): array {
        $network = $this->plugin->getNetworkAPI();
        return $network->getAll();
    }

    /**
     * @param string $name
     * @param string $type
     * @param bool $private
     * @return string|null
     */
    public function add(string $name, string $type, bool $private = false): ?string {
        $id = 0;
        for ($port = 16000; $port <= 16064; $port++) {
            $id++;
            if (!is_dir(CreateServer::$servers . "/" . $id)) {
                $this->plugin->getNetworkAPI()->add($port, "" . $id . "", $name . "_" . $type, $private);
                CreateServer::add("$id", $port, $name, $type);
                return $id;
            }
        }
        return null;
    }

    /**
     * @return string
     */
    public function getServer(): string {
        $port = $this->plugin->getServer()->getPort();
        if (isset($this->getPort()[$port])) return $this->getPort()[$port];
        return "...";
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getPlayer(string $name): ?string {
        $found = null;
        $name = strtolower($name);
        $delta = PHP_INT_MAX;
        foreach ($this->getPlayerList() as $names) {
            if (stripos($names, $name) === 0) {
                $curDelta = strlen($names) - strlen($name);
                if ($curDelta < $delta) {
                    $found = $names;
                    $delta = $curDelta;
                }
                if ($curDelta === 0) break;
            }
        }
        return $found;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getAllPlayer(string $name): ?string {
        $found = null;
        $name = strtolower($name);
        $delta = PHP_INT_MAX;
        foreach ($this->plugin->getGamblerAPI()->getAllPlayers() as $names) {
            if (stripos($names, $name) === 0) {
                $curDelta = strlen($names) - strlen($name);
                if ($curDelta < $delta) {
                    $found = $names;
                    $delta = $curDelta;
                }
                if ($curDelta === 0) break;
            }
        }
        return $found;
    }

    /**
     * @return array
     */
    public function getPlayerList(): array {
        return $this->plugin->getServerAPI()->getAllNetwork();
    }
}