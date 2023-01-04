<?php

namespace Core\Events;

use Core\AcePlayer;
use Core\Core;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;

class PlayerQuit implements Listener {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    public function onQuit(PlayerQuitEvent $event): void {
        $player = $event->getPlayer();
        $name = $player->getName();
        $port = $this->plugin->getServer()->getPort();
        $players = $this->plugin->getServer()->getOnlinePlayers();
        if ($player instanceof AcePlayer) {
            $event->setQuitMessage("");
            if (!$player->isTransfer()) $this->plugin->getGamblerAPI()->setConnect($name, "Offline");
            $this->plugin->getServerAPI()->set($port, count($players) - 1, $players);
            if (isset($player->time[$name])) {
                $player->addPlaytime(time() - $player->time[$name]);
                unset($player->time[$name]);
            }
        }
    }
}