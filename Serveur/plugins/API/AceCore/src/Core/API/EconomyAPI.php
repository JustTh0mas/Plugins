<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;

class EconomyAPI {
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
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM economy WHERE name = ?");
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
    public function setDefaultData(AcePlayer $player): bool {
        $name = strtolower($player->getName());
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO economy (name, money, token) VALUES (?, ?, ?)");
            $money = 100;
            $token = 0;
            $stmt->bind_param("sss", $name, $money, $token);
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
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $stmt = $MySQL->prepare("SELECT * FROM economy WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $economy = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($economy) ? [$name, 100, 0] : $economy;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getMoney(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[1];
    }

    /**
     * @param string $name
     * @param int $amount
     * @return bool
     */
    public function setMoney(string $name, int $amount): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE economy SET money = ? WHERE name = ?");
            $stmt->bind_param("ss", $amount, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param int $amount
     * @return bool
     */
    public function addMoney(string $name, int $amount): bool {
        $name = strtolower($name);
        $amount = $this->getMoney($name) + $amount;
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE economy SET money = ? WHERE name = ?");
            $stmt->bind_param("ss", $amount, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param int $amount
     * @return bool
     */
    public function reduceMoney(string $name, int $amount): bool {
        $name = strtolower($name);
        $amount = $this->getMoney($name) - $amount;
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE economy SET money = ? WHERE name = ?");
            $stmt->bind_param("ss", $amount, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getToken(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[2];
    }

    /**
     * @param string $name
     * @param int $amount
     * @return bool
     */
    public function setToken(string $name, int $amount): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE economy SET token = ? WHERE name = ?");
            $stmt->bind_param("ss", $amount, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param int $amount
     * @return bool
     */
    public function addToken(string $name, int $amount): bool {
        $name = strtolower($name);
        $amount = $this->getToken($name) + $amount;
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE economy SET token = ? WHERE name = ?");
            $stmt->bind_param("ss", $amount, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param int $amount
     * @return bool
     */
    public function reduceToken(string $name, int $amount): bool {
        $name = strtolower($name);
        $amount = $this->getToken($name) - $amount;
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE economy SET token = ? WHERE name = ?");
            $stmt->bind_param("ss", $amount, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }
}
