<?php

namespace Core\Commands\Commands\Staff;

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
                if ($sender->isOp() or $sender->hasPermission("modo")) {
                    $name = $sender->getName();
                    $staff = $this->plugin->getStaffAPI();
                    if ($staff->exist($name)) {
                        $staff->add($sender);
                        $staff->getManager()->set($sender);
                        $sender->sendMessage(Prefix::SERVER . "Vous avez activé le staff mode !");
                    } else {
                        $staff->del($name);
                        $staff->getManager()->remove($sender);
                        $sender->sendMessage(Prefix::SERVER . "Vous avez désactivé le staff mode !");
                    }
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