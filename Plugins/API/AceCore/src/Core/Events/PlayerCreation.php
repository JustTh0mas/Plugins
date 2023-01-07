<?php

namespace Core\Events;

use Core\AcePlayer;
use Core\Core;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;

class PlayerCreation implements Listener {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    /**
     * @param PlayerCreationEvent $event
     * @return void
     */
    public function onPlayerPreLogin(PlayerCreationEvent $event): void {
        $event->setPlayerClass(AcePlayer::class);
    }
}