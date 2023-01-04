<?php

namespace AceCore\Manager;

use AceCore\AcePlayer;
use AceCore\Core;
use pocketmine\utils\TextFormat as TF;

class TagsManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param AcePlayer $player
     * @param string $tag
     * @return void
     */
    public function set(AcePlayer $player, string $tag): void {
        $player->setTag($tag);
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function remove(AcePlayer $player): void {
        $player->tag = false;
    }
}