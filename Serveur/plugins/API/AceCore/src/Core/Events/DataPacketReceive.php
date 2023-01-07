<?php

namespace AceCore\src\Core\Events;

use AceCore\src\Core\Core;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\NetworkStackLatencyPacket;

class DataPacketReceive implements Listener {
    /**
     * @var Core
     */
    private Core $plugin;
    /** @var array  */
    public static array $callbacks = [];

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    /**
     * @param DataPacketReceiveEvent $event
     * @priority MONITOR
     * @ignoreCancelled true
     * @return void
     */
    public function onDataPacketReceive(DataPacketReceiveEvent $event): void {
        $packet = $event->getPacket();
        if ($packet instanceof NetworkStackLatencyPacket && isset(self::$callbacks[$id = $event->getPlayer()->getId()][$ts  = $packet->timestamp])) {
            $cb = self::$callbacks[$id][$ts];
            unset(self::$callbacks[$id][$ts]);
            if (count(self::$callbacks[$id]) === 0) unset(self::$callbacks[$id]);
            $cb();
        }
    }
}