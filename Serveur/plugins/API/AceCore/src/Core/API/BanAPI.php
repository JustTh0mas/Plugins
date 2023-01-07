<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;
use AceCore\src\Core\Prefix;

class BanAPI {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param string $column
     * @param mixed $value
     * @return bool
     */
    public function exist(string $column, $value): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM ban WHERE '" . $column . "' = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $MySQL->close();
        return $count > 0 ? true : false;
    }

    /**
     * @return int
     */
    public function getId(): int {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $i = 1;
        while ($MySQL->query("SELECT * FROM ban WHERE id = '" . $i . "'")->num_rows > 0) {
            $i++;
        }
        $MySQL->close();
        return $i;
    }

    /**
     * @param string $name
     * @param string $modo
     * @param string $ip
     * @param string $uuid
     * @param string $time
     * @param string $reason
     * @return bool
     */
    public function add(string $name, string $modo, string $ip, string $uuid, string $time, string $reason): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist("name", $name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO ban (id, name, modo, ip, uuid, time_sec, reason) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $id = $this->getId();
            $stmt->bind_param("sssssss", $id, $name, $modo, $ip, $uuid, $time, $reason);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $column
     * @param string $value
     * @return array
     */
    public function get(string $column, string $value): array {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT * FROM ban WHERE ? = ?");
        $stmt->bind_param("ss", $column, $value);
        $stmt->execute();
        $result = $stmt->get_result();
        $MySQL->close();
        return $result->fetch_row();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delByID(string $id): bool
    {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("DELETE FROM ban WHERE id = ?");
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $MySQL->close();
        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function delByName(string $name): bool
    {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("DELETE FROM ban WHERE name = ?");
        $stmt->bind_param("s", $name);
        $result = $stmt->execute();
        $MySQL->close();
        return $result;
    }

    /**
     * @param int $min
     * @param int $max
     * @return array
     */
    public function getBetween(int $min, int $max): array
    {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT name, ip, uuid, time_sec, reason FROM ban WHERE id BETWEEN ? AND ?");
        $stmt->bind_param("ii", $min, $max);
        $stmt->execute();
        $result = $stmt->get_result();
        $all = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $all[$row["name"]] = array($row["ip"], $row["uuid"], $row["time_sec"], $row["reason"]);
            }
        }
        $MySQL->close();
        return $all;
    }

    /**
     * @param AcePlayer $player
     * @return bool
     */
    public function getBan(AcePlayer $player): bool {
        $ban = array(false);
        if ($this->exist("name", $player->getName())) {
            $ban = array(true, strtolower($player->getName()), "name");
        } else if ($this->exist("ip", $player->getNetworkSession()->getIp())) {
            $ban = array(true, $player->getNetworkSession()->getIp(), "ip");
        } else if ($this->exist("uuid", $player->getUniqueId())) {
            $ban = array(true, $player->getUniqueId(), "uuid");
        }
        if ($ban[0]) {
            $data = $this->get($ban[1], $ban[2]);
            if ($data[6] !== "indefinite") {
                if (strtotime("now") >= (int)$data[6]) {
                    $this->delByID($data[0]);
                    return false;
                } else {
                    $time = $this->plugin->getAPI()->getTimeFormat((int)$data[6] - strtotime("now"));
                }
            } else {
                $time = "indefinite";
            }
            $player->close("",Prefix::SERVER . "Vous avez été ban pour une durée de " . $time);
            return true;
        }
        return false;
    }
}