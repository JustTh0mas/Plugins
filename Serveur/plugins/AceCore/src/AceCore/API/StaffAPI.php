<?php

namespace AceCore\API;

use AceCore\AcePlayer;
use AceCore\Core;
use AceCore\Manager\StaffManager;

class StaffAPI {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exist(string $name): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM staff WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $MySQL->close();
        return $count > 0 ? true : false;
    }

    /**
     * @param AcePlayer $player
     * @return bool
     */
    public function add(AcePlayer $player): bool {
        $name = strtolower($player->getName());
        $inventory = base64_encode(serialize($player->getInventory()->getContents(true)));
        $armorInventory = base64_encode(serialize($player->getArmorInventory()->getContents(true)));
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO staff (name, vanish, inventory, armor) VALUES (?, ?, ?, ?)");
            $vanish = true;
            $stmt->bind_param("ssss", $name, $vanish, $inventory, $armorInventory);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @return array
     */
    public function get(string $name): array {
        $name = strtolower($name);
        $my = $this->plugin->getMySQLApi()->getData();
        $stmt = $my->prepare("SELECT * FROM staff WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $my->close();
        $array = $result->fetch_array();
        return $array;
    }

    /**
     * @param AcePlayer $player
     * @return bool
     */
    public function update(AcePlayer $player): bool {
        $name = strtolower($player->getName());
        $inventory = base64_encode(serialize($player->getInventory()->getContents(true)));
        $armorInventory = base64_encode(serialize($player->getArmorInventory()->getContents(true)));
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE staff SET inventory = ?, armor = ? WHERE name = ?");
            $stmt->bind_param("sss", $inventory, $armorInventory, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @return array|array[]
     */
    public function getInventories(string $name): array {
        $name = strtolower($name);
        if ($this->exist($name)) {
            $array = $this->get($name);
            $inventory = unserialize(base64_decode($array["inventory"]));
            $armorInventory = unserialize(base64_decode($array["armor"]));
            return [$inventory, $armorInventory];
        }
        return [[], []];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function del(string $name): bool {
        $name = strtolower($name);
        $my = $this->plugin->getMySQLApi()->getData();
        $stmt = $my->prepare("DELETE FROM staff WHERE name = ?");
        $stmt->bind_param("s", $name);
        $result = $stmt->execute();
        $my->close();
        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function getVanish(string $name): bool {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data["vanish"];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setVanish(string $name): bool {
        $name = strtolower($name);
        $vanish = $this->getVanish($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($vanish === "true") {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE staff SET vanish = 'false' WHERE name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE staff SET vanish = 'true' WHERE name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $MySQL->commit();
        }
        $MySQL->close();
        return false;
    }

    /**
     * @return array
     */
    public function getAllStaff(): array {
        $all = [];
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $result = $MySQL->query("SELECT DISTINCT name FROM staff");
        $MySQL->commit();
        $MySQL->close();
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row["name"];
                $all[] = $name;
            }
        }
        return $all;
    }

    /**
     * @return StaffManager
     */
    public function getManager(): StaffManager {
        return new StaffManager();
    }
}