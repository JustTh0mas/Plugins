<?php

namespace AceCore\src\Core\Manager;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;

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