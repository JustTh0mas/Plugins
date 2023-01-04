<?php

namespace AceCore\Manager;
use AceCore\AcePlayer;
use AceCore\Core;

class KDMManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct()
    {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param AcePlayer $player
     * @param string $kdm
     * @return void
     */
    public function set(AcePlayer $player, string $kdm): void {
        $player->setKDM($kdm);
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function remove(AcePlayer $player): void {
        $player->kdm = false;
    }
}