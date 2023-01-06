<?php

namespace Core\Events;

use Core\Core;
use pocketmine\event\Listener;
use pocketmine\event\player\cheat\PlayerCheatEvent;

class PlayerCheat implements Listener {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    /**
     * @param PlayerCheatEvent $event
     * @return void
     */
    public function onCheat(PlayerCheatEvent $event): void {
        $event->setCancelled(true);
    }
}