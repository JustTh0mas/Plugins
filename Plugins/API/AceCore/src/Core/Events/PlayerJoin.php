<?php

namespace AceCore\src\Core\Events;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;
use AceCore\src\Core\Prefix;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat as TF;

class PlayerJoin implements Listener {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    /**
     * @param PlayerJoinEvent $event
     * @return void
     */
    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $name = $player->getName();
        $port = $this->plugin->getServer()->getPort();
        $players = $this->plugin->getServer()->getOnlinePlayers();
        $staff = $this->plugin->getStaffAPI();
        if ($player instanceof AcePlayer) {
            if ($player->isConnected()) {
                $event->setJoinMessage("");
                if ($this->plugin->getBanAPI()->getBan($player)) return;
                $player->time[$name] = time();
                $player->setJoin();
                $this->plugin->getGamblerAPI()->setDefaultData($player);
                $this->plugin->getGamblerAPI()->setConnect($name, $this->plugin->getNetworkAPI()->getNetworkUtils()->getServer());
                $this->plugin->getGamblerAPI()->addPermission($player);
                $this->plugin->getVerifAPI()->setDefaultData($player);
                $this->plugin->getEconomyAPI()->setDefaultData($player);
                $this->plugin->getSettingsAPI()->setDefaultData($player);
                $this->plugin->getCosmeticsAPI()->setDefaultData($player);
                $this->plugin->getServerAPI()->set($port, count($players), $players);
                if ($staff->exist($player->getName())) {
                    $staff->update($player);
                    $staff->getManager()->set($player);
                    $staff->getManager()->setAllVanish();
                }
                if ($this->plugin->isCosmetics()) {
                    if ($player->isCosmetics()) {
                        $this->plugin->getCosmeticsAPI()->getManager()->addAll($player);
                    }
                }
                $players = $this->plugin->getServer()->getOnlinePlayers();
                foreach ($players as $player) {
                    if ($player instanceof AcePlayer) {
                        if ($staff->exist($player->getName())) {
                            unset($players[array_search($player->getName(), $players)]);
                        }
                    }
                }
                $player->sendMessage($player->messageToTranslate("ERROR"));
                $this->plugin->getLogger()->info(Prefix::SERVER . TF::AQUA . $player->getName() . TF::WHITE . " vient de rejoindre le lobby !");
            }
        }
    }
}