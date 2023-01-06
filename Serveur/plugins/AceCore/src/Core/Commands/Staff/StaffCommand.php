<?php

namespace Core\Commands\Staff;

use Core\AcePlayer;
use Core\Core;
use Core\Prefix;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class StaffCommand extends Command {
    /** @var Core */
    private Core $plugin;

    public function __construct()
    {
        $this->plugin = Core::getInstance();
        parent::__construct("staff", "", "/staff", ["staffmode"]);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        if ($this->plugin->isEnabled()) {
            if ($sender instanceof AcePlayer) {
                if ($sender->hasPermission("modo")) {
                    $name = $sender->getName();
                    $staff = $this->plugin->getStaffAPI();
                    if (!$staff->exist($name)) {
                        $staff->add($sender);
                        $staff->getManager()->set($sender);
                        $sender->sendMessage(Prefix::SERVER . "Vous avez activé le staff mode !");
                    } else {
                        $staff->getManager()->remove($sender);
                        $staff->del($name);
                        $sender->sendMessage(Prefix::SERVER . "Vous avez désactivé le staff mode !");
                    }
                    $staff->setVanish($name);
                } else {
                    $sender->sendMessage($sender->messageToTranslate("PERM"));
                }
            } else {
                $sender->sendMessage($sender->messageToTranslate("CONSOLE"));
            }
        }
        return true;
    }
}