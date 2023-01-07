<?php

namespace Core\Events;

use Core\Core;
use pocketmine\event\Listener;
use pocketmine\event\server\QueryRegenerateEvent;

class QueryRegenerate implements Listener {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
    }

    public function onQueryRegenerate(QueryRegenerateEvent $event): void {

    }
}