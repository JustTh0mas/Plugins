<?php

namespace AceCore\src\Core\Events;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;
use pocketmine\entity\Attribute;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\network\mcpe\protocol\NetworkStackLatencyPacket;
use pocketmine\network\mcpe\protocol\UpdateAttributesPacket;
use pocketmine\scheduler\ClosureTask;

class DataPacketSend implements Listener {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    /**
     * @param DataPacketSendEvent $event
     * @return void
     */
    public function fromDataPacketSend(DataPacketSendEvent $event): void {
        if ($event->getPacket() instanceof ModalFormRequestPacket) {
            $player = $event->getPlayer();
            if ($player instanceof AcePlayer) {
                $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function(int $currentTick) use ($player) : void {
                    if ($player->isOnline()) {
                        $this->onPacketSend($player, function() use ($player): void {
                            if ($player->isOnline()) {
                                $this->requestUpdate($player);
                                if (10 > 1) {
                                    $times = 10 - 1;
                                    $handler = null;
                                    $handler = $this->plugin->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(int $currentTick) use ($player, $times, &$handler): void {
                                        if (--$times >= 0 && $player->isOnline()) {
                                            $this->requestUpdate($player);
                                        } else {
                                            $handler->cancel();
                                            $handler = null;
                                        }
                                    }), 10);
                                }
                            }
                        });
                    }
                }), 1);
            }
        }
    }

    /**
     * @param AcePlayer $player
     * @param \Closure $callback
     * @return void
     */
    public function onPacketSend(AcePlayer $player, \Closure $callback): void {
        $ts = mt_rand() * 1000;
        $pk = new NetworkStackLatencyPacket();
        $pk->timestamp = $ts;
        $pk->needResponse = true;
        $player->getNetworkSession()->sendDataPacket($pk);
        DataPacketReceive::$callbacks[$player->getId()][$ts] = $callback;
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function requestUpdate(AcePlayer $player): void {
        $pk = new UpdateAttributesPacket();
        $pk->entityRuntimeId = $player->getId();
        $pk->entries[] = $player->getAttributeMap()->getAttribute(Attribute::EXPERIENCE_LEVEL);
        $player->getNetworkSession()->sendDataPacket($pk);
    }
}