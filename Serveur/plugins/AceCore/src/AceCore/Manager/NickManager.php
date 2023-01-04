<?php

namespace AceCore\Manager;

use AceCore\AcePlayer;
use AceCore\Core;
use AceCore\Utils\Cosmetics;

class NickManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param AcePlayer $player
     * @param string $nick
     * @return void
     */
    public function set(AcePlayer $player, string $nick): void {
        $player->setNick($nick);
        $player->setNewTag();
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function remove(AcePlayer $player): void {
        $player->nick= false;
    }

    /**
     * @return string
     */
    public function random(): string {
        return Cosmetics::NICK[array_rand(Cosmetics::NICK)];
    }
}