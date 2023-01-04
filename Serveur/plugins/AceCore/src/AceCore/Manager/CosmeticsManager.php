<?php

namespace AceCore\Manager;

use AceCore\AcePlayer;
use AceCore\Core;
use AceCore\Utils\Cosmetics;

class CosmeticsManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param AcePlayer $player
     * @param array $types
     * @return void
     */
    public function add(AcePlayer $player, array $types): void {
        $this->plugin->getCosmeticsAPI()->setCosmetics($player->getName());
        foreach ($types as $type) {
            if ($this->plugin->isCosmetics()) {
                $cosmetics = $this->plugin->getCosmeticsAPI()->get($player->getName());
                if (!is_null($cosmetics)) {
                   $gadgets = $cosmetics[$type];
                   if ($gadgets !== false) {
                       if ($type === "nick") {
                           $this->plugin->getCosmeticsAPI()->getNickManager()->set($player, $gadgets);
                       } elseif (in_array($gadgets, $this->plugin->getCosmeticsAPI()->cosmetics["tags"])) {
                           $this->plugin->getCosmeticsAPI()->getTagsManager()->set($player, $gadgets);
                       } elseif (in_array($gadgets, $this->plugin->getCosmeticsAPI()->cosmetics["kdmessages"])) {
                           $this->plugin->getCosmeticsAPI()->getKDMManager()->set($player, $gadgets);
                       }
                       switch ($gadgets) {
                           case "gadget_fly":
                               $player->setAllowFlight(true);
                               $player->setFlying(true);
                               break;
                       }
                   }
                }
            }
        }
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function addAll(AcePlayer $player): void {
        $this->plugin->getCosmeticsAPI()->setCosmetics($player->getName());
        $types = array_keys($this->plugin->getCosmeticsAPI()->cosmetics);
        foreach ($types as $type) {
            if ($this->plugin->isCosmetics()) {
                $cosmetics = $this->plugin->getCosmeticsAPI()->get($player->getName());
                if (!is_null($cosmetics)) {
                    $gadgets = $cosmetics[$type];
                    if ($gadgets !== false) {
                        if ($type === "nick") {
                            $this->plugin->getCosmeticsAPI()->getNickManager()->set($player, $gadgets);
                        } elseif (in_array($gadgets, $this->plugin->getCosmeticsAPI()->cosmetics["tags"])) {
                            $this->plugin->getCosmeticsAPI()->getTagsManager()->set($player, $gadgets);
                        } elseif (in_array($gadgets, $this->plugin->getCosmeticsAPI()->cosmetics["kdmessages"])) {
                            $this->plugin->getCosmeticsAPI()->getKDMManager()->set($player, $gadgets);
                        }
                        switch ($gadgets) {
                            case "gadget_fly":
                                $player->setAllowFlight(true);
                                $player->setFlying(true);
                                break;
                        }
                    }
                }
            }
        }
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function removeAll(AcePlayer $player): void {
        $player->setAllowFlight(false);
        $player->setFlying(false);
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function removeGadget(AcePlayer $player): void {
        $this->plugin->getCosmeticsAPI()->set($player->getName(), "gadgets", "false");
        $player->setAllowFlight(false);
        $player->setFlying(false);
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function removeNick(AcePlayer $player): void {
        $this->plugin->getCosmeticsAPI()->set($player->getName(), "nick", "false");
        $this->plugin->getCosmeticsAPI()->getNickManager()->remove($player);
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function removeTag(AcePlayer $player): void {
        $this->plugin->getCosmeticsAPI()->set($player->getName(), "tags", "false");
        $this->plugin->getCosmeticsAPI()->getTagsManager()->remove($player);
    }

    /**
     * @param AcePlayer $player
     * @return void
     */
    public function removeKDM(AcePlayer $player): void {
        $this->plugin->getCosmeticsAPI()->set($player->getName(), "kdmessages", "false");
        $this->plugin->getCosmeticsAPI()->getKDMManager()->remove($player);
    }
}