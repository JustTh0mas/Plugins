<?php

namespace AceCore\Manager;

use AceCore\AcePlayer;
use AceCore\Core;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\convert\SkinAdapterSingleton;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;

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
        $player->setGamemode(1);
        $player->setCosmetics();
        $this->plugin->getCosmeticsAPI()->getManager()->removeAll($player);
        $this->plugin->getServer()->removePlayerListData($player->getUniqueId());
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
            $players->hidePlayer($player);
        }
        $teleport = VanillaItems::BLAZE_ROD()->setCustomName($this->itemsName["TELEPORT"]);
        $game = VanillaItems::COMPASS()->setCustomName($this->itemsName["GAME"]);
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
        $inventory = $this->plugin->getStaffAPI()->getInventories($player->getName());
        $player->setGamemode(2);
        $player->setCosmetics(true);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->getInventory()->setContents($inventory[0]);
        $player->getArmorInventory()->setContents($inventory[1]);
        $this->plugin->getCosmeticsAPI()->getManager()->addAll($player);
        $entry = PlayerListEntry::createAdditionEntry($player->getUniqueId(), $player->getId(), $player->getDisplayName(), SkinAdapterSingleton::get()->toSkinData($player->getSkin()), $player->getXuid());
        $pk = new PlayerListPacket();
        $pk->entries[] = $entry;
        $pk->type = PlayerListPacket::TYPE_ADD;
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $players) {
            $players->showPlayer($player);
            $players->sendDataPacket($pk);
        }
        $this->plugin->getServer()->sendFullPlayerListData($player);
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
                            $players->sendDataPacket($pk);
                        }
                    }
                }
            }
        }
    }
}