<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\Core;
use AceCore\src\Core\Utils\Network;

class NetworkAPI {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin= Core::getInstance();
    }

    /**
     * @param int $port
     * @return bool
     */
    public function exist(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM `network` WHERE port = ?");
        $stmt->bind_param("s", $port);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $MySQL->close();
        return $count > 0 ? true : false;
    }

    /**
     * @param int $port
     * @param string $name
     * @param string $type
     * @param bool $private
     * @return bool
     */
    public function add(int $port, string $name, string $type, bool $private = false): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($private) $private = "true"; else $private = "false";
        if (!$this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO `network` (port, name, type, private) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $port, $name, $type, $private);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param int $port
     * @return bool
     */
    public function del(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("DELETE FROM `network` WHERE port = ?");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            //CreateServer::onRemoveDir($this->plugin->getServer()->getDataPath());
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param int $port
     * @return array
     */
    public function get(int $port): array {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $stmt = $MySQL->prepare("SELECT * FROM `network` WHERE port = ?");
        $stmt->bind_param("s", $port);
        $stmt->execute();
        $network = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($network) ? [$port, "-", "-", "false"] : $network;
        /*
         * 1 = name
         * 2 = type
         * 3 = private
         */
    }

    /**
     * @param bool $port
     * @return array
     */
    public function getAll(bool $port = false): array {
        $all = [];
        if (!$port) {
            $all["Lobby"] = 19132;
            $all["ffa"] = 17001;
        } else {
            $all[17001] = "FreeForAll";
            $all[19132] = "Lobby";
        }
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $result = $MySQL->query("SELECT * FROM `network`");
        $MySQL->commit();
        $MySQL->close();
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row["name"];
                $portData = $row["port"];
                if (!$port) $all["" . $name . ""] = $portData; else $all[$portData] = "" . $name . "";
            }
        }
        return $all;
    }

    /**
     * @param string $game
     * @param int $team
     * @return array
     */
    public function getServer(string $game, int $team = 0): array {
        $server = [];
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $result = $MySQL->query("SELECT * FROM `network`");
        $MySQL->commit();
        $MySQL->close();
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row["name"];
                $port = $row["port"];
                $type = $row["type"];
                $private = $row["private"];
                if ($private === "false") {
                    $types = explode("_", $type);
                    $name = $types[0];
                    $type = (int) $types[1];
                    if ($name == $game) {
                        if ($type == $team or $team == 0) $server[$port] = "" . $id . "";
                    }
                }
            }
        }
        return $server;
    }

    /**
     * @return Network
     */
    public function getNetworkUtils(): Network {
        return new Network();
    }
}