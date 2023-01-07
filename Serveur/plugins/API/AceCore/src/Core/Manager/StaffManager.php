<?php

namespace AceCore\src\Core\Manager;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\convert\SkinAdapterSingleton;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;
use pocketmine\player\GameMode;
use pocketmine\utils\TextFormat as TF;

class StaffManager {
    /**
     * @var array|string[]
     */
    public array $itemsName = [
        "TELEPORT" => TF::YELLOW . "Téléportation Random" . "\n" . TF::WHITE .  "(" . TF::AQUA . "Click" . TF::WHITE . ")",
        "GAME" => TF::YELLOW . "Serveur" . "\n" . TF::WHITE .  "(" . TF::AQUA . "Click" . TF::WHITE . ")",
        "VANISH" => TF::YELLOW . "Vanish" . "\n" . TF::WHITE .  "(" . TF::AQUA . "Click" . TF::WHITE . ")",
        "LEAVE" => TF::YELLOW . "Quitter" . "\n" . TF::WHITE .  "(" . TF::AQUA . "Click" . TF::WHITE . ")",
        "FREEZE" => TF::YELLOW . "Freeze" . "\n" . TF::WHITE .  "(" . TF::AQUA . "Taper le joueur" . TF::WHITE . ")",
        "KICK" => TF::YELLOW . "Kick" . "\n" . TF::WHITE .  "(" . TF::AQUA . "Taper le joueur" . TF::WHITE . ")",
        "BAN" => TF::YELLOW . "Ban" . "\n" . TF::WHITE .  "(" . TF::AQUA . "Taper le joueur" . TF::WHITE . ")",
    ];

    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function set(AcePlayer $player): void {
        $player->setGamemode(GameMode::CREATIVE());
        $player->setCosmetics();
        $player->setSilent(true);
        $this->plugin->getCosmeticsAPI()->getManager()->removeAll($player);
        $player->getServer()->removeOnlinePlayer($player);
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
            $players->hidePlayer($player);
        }
        $teleport = VanillaItems::BLAZE_ROD()->setCustomName($this->itemsName["TELEPORT"]);
        $game = VanillaItems::CLOCK()->setCustomName($this->itemsName["GAME"]);
        $vanish = VanillaItems::LIME_DYE()->setCustomName($this->itemsName["VANISH"]);
        $freeze = VanillaItems::DIAMOND()->setCustomName($this->itemsName["FREEZE"]);
        $kick = VanillaItems::STICK()->setCustomName($this->itemsName["KICK"]);
        $ban = VanillaItems::BONE()->setCustomName($this->itemsName["BAN"]);
        $leave = VanillaItems::REDSTONE_DUST()->setCustomName($this->itemsName["LEAVE"]);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->getInventory()->setItem(0, $teleport);
        $player->getInventory()->setItem(2, $game);
        $player->getInventory()->setItem(3, $vanish);
        $player->getInventory()->setItem(4, $freeze);
        $player->getInventory()->setItem(5, $kick);
        $player->getInventory()->setItem(6, $ban);
        $player->getInventory()->setItem(8, $leave);
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function remove(AcePlayer $player): void {
        $player->setGamemode(GameMode::ADVENTURE());
        $player->setSilent(false);
        $player->setCosmetics(true);
        $player->getArmorInventory()->clearAll();
        $player->getInventory()->clearAll();
        $player->getServer()->addOnlinePlayer($player);
        $this->plugin->getStaffAPI()->restoreInventory($player);
        $this->plugin->getCosmeticsAPI()->getManager()->addAll($player);
        $entry = PlayerListEntry::createAdditionEntry($player->getUniqueId(), $player->getId(), $player->getDisplayName(), SkinAdapterSingleton::get()->toSkinData($player->getSkin()), $player->getXuid());
        $pk = new PlayerListPacket();
        $pk->entries[] = $entry;
        $pk->type = PlayerListPacket::TYPE_ADD;
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
            $players->showPlayer($player);
            $players->getNetworkSession()->sendDataPacket($pk);
        }
    }

    public function setAllVanish() {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            if ($player instanceof AcePlayer) {
                $staff = $this->plugin->getStaffAPI();
                if ($staff->exist($player->getName())) {
                    if ($staff->getVanish($player->getName()) === "true") {
                        $entry = new PlayerListEntry();
                        $entry->uuid = $player->getUniqueId();
                        $pk = new PlayerListPacket();
                        $pk->entries[] = $entry;
                        $pk->type = PlayerListPacket::TYPE_REMOVE;
                        foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
                            $players->hidePlayer($player);
                            $players->getNetworkSession()->sendDataPacket($pk);
                        }
                    }
                }
            }
        }
    }
}