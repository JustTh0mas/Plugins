<?php

namespace Core\Utils;

use Core\Core;
use pocketmine\utils\TextFormat as TF;

class Network {
    const FREEFORALL = "ffa";
    const SOLO = 1, DUO = 2, SQUAD = 4;
    const IP = "185.157.247.59";
    const GAMES = [
        TF::RED . "FreeForAll" => self::FREEFORALL,
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
            if (!is_dir())
        }
    }
}