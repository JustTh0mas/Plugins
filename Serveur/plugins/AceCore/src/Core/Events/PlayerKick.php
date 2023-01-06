<?php

namespace Core\Events;

use Core\AcePlayer;
use Core\Core;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerKickEvent;

class PlayerKick implements Listener {
    /** @var Core  */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    /**
     * @param PlayerKickEvent $event
     * @return void
     */
    public function onKick(PlayerKickEvent $event): void {
        $player = $event->getPlayer();
        if ($player instanceof AcePlayer) {
            switch ($event->getReason()) {
                case "Server is white-listed":
                    if (!$player->isStaff()) {
                        $event->setCancelled();
                        $player->close("Whitelist", $player->messageToTranslate("KICK_WHITELIST"));
                    }
                    break;
            }
        }
    }
}