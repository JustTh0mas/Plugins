<?php

namespace Core\Tasks;

use Core\AcePlayer;
use Core\Core;
use pocketmine\scheduler\Task;

class SocketReadTask extends Task {
    /** @var Core  */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
        $this->plugin->getScheduler()->scheduleRepeatingTask($this, 5);
    }

    public function onRun(int $currentTick)
    {
        while ($data = $this->plugin->getSocket()->read()) {
            if ($data) {
                $data = str_replace(["}{", "{","}"], [",","",""], $data);
                $data = "{" . $data . "}";
                $data = json_decode($data, true);
                if (is_array($data)) {
                    foreach ($data as $type => $info) {
                        switch ($type) {
                            case "SET_RANK":
                                $player = $this->plugin->getServer()->getPlayer($info[0]);
                                if ($player instanceof AcePlayer) {
                                    $this->plugin->getGamblerAPI()->addPermission($player);
                                    $this->plugin->getCosmeticsAPI()->setCosmetics($info[0]);
                                }
                                break;
                        }
                    }
                }
            }
        }
    }
}