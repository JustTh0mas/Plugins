<?php

namespace Core\Manager;

use Core\AcePlayer;
use Core\Core;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemFactory;
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
        "TELEPORT" => TF::YELLOW . "Téléportation aléatoire" . TF::GRAY .  "(Clique droit)",
        "INFORMATIONS" => TF::AQUA . "Informations" . TF::GRAY .  "(Clique droit)",
        "LOGS_SANCTIONS" => TF::YELLOW . "Historique sanctions" . TF::GRAY .  "(Clique droit)",
        "ANTI_KB" => TF::YELLOW . "Anti-KB",
        "FREEZE" => TF::YELLOW . "Geler le joueur" . TF::GRAY .  "(Clique droit)",
        "GAME" => TF::GREEN . "Changer de serveur",
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
        $teleport = VanillaItems::COMPASS()->setCustomName($this->itemsName["TELEPORT"]);
        $info = VanillaItems::PAPER()->setCustomName($this->itemsName["GAME"]);
        $history = VanillaItems::BOOK();
        $history->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING()));
        $history->setCustomName($this->itemsName["VANISH"]);
        $anti_kb = VanillaItems::STICK()->setCustomName($this->itemsName["ANTI_KB"]);
        $server = VanillaItems::CLOCK()->setCustomName($this->itemsName["GAME"]);
        $freeze = ItemFactory::getInstance()->get(79)->setCustomName($this->itemsName["FREEZE"]);
        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();
        $player->getInventory()->setItem(0, $teleport);
        $player->getInventory()->setItem(1, $info);
        $player->getInventory()->setItem(2, $history);
        $player->getInventory()->setItem(3, $anti_kb);
        $player->getInventory()->setItem(4, $server);
        $player->getInventory()->setItem(8, $freeze);
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