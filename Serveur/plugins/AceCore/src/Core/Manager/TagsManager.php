<?php

namespace Core\Manager;

use Core\AcePlayer;
use Core\Core;

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