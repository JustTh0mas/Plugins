<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;

class GameAPI {
    /** @var Core */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param string $name
     * @param string $table
     * @return bool
     */
    public function exist(string $name, string $table): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM ? WHERE name = ?");
        $stmt->bind_param("ss", $table, $name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $MySQL->close();
        return $count > 0 ? true : false;
    }

    /**
     * @param AcePlayer $player
     * @param string $table
     * @return bool
     */
    public function setDefaultData(AcePlayer $player, string $table): bool {
        $name = strtolower($player->getName());
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($name, $table)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO ? (name, wins, losts) VALUES (?, ?, ?)");
            $wins = 0;
            $losts = 0;
            $stmt->bind_param("ssss", $table, $name, $wins, $losts);
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
     * @param string $table
     * @return array
     */
    public function get(string $name, string $table): array {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $stmt = $MySQL->prepare("SELECT * FROM ? WHERE name = ?");
        $stmt->bind_param("ss", $table, $name);
        $stmt->execute();
        $game = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($game) ? [$name, 0, 0] : $game;
    }

    /**
     * @param string $name
     * @param string $table
     * @return int
     */
    public function getWin(string $name, string $table): int {
        $name = strtolower($name);
        $data = $this->get($name, $table);
        return $data[1];
    }

    /**
     * @param string $name
     * @param string $table
     * @return bool
     */
    public function addWin(string $name, string $table): bool {
        $name = strtolower($name);
        $win = $this->getWin($name, $table) + 1;
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name, $table)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE ? SET wins = ? WHERE name = ?");
            $stmt->bind_param("sss", $table, $win, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param string $table
     * @return int
     */
    public function getLost(string $name, string $table): int {
        $name = strtolower($name);
        $data = $this->get($name, $table);
        return $data[2];
    }

    /**
     * @param string $name
     * @param string $table
     * @return bool
     */
    public function addLost(string $name, string $table): bool {
        $name = strtolower($name);
        $lost = $this->getLost($name, $table) + 1;
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name, $table)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE ? SET losts = ? WHERE name = ?");
            $stmt->bind_param("sss", $table, $lost, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param string $table
     * @return float
     */
    public function getWinLost(string $name, string $table): float {
        $name = strtolower($name);
        if ($this->exist($name, $table)) {
            $win = $this->getWin($name, $table);
            $lost = $this->getLost($name, $table);
            $wl = 1;
            if ($lost == 0 or $lost == 0) {
                if ($win == 0 and $lost > 0) $wl = round(1 / $lost, 1); elseif ($win > 0 and $lost == 0) $wl = round ($win / 1, 1);
            } else {
                $wl = round($win / $lost, 1);
            }
            return $wl;
        }
        return 0;
    }

    /**
     * @param string $table
     * @return array
     */
    public function getAll(string $table): array {
        $all = [];
        $my = $this->plugin->getMySQLApi()->getData();
        $res = $my->query("SELECT * FROM $table");
        $my->close();
        if ($res) {
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $name = $row["name"];
                    $win = $row["wins"];
                    $lost = $row["lost"];
                    $wl = 1;
                    if ($lost == 0 or $lost == 0) {
                        if ($win == 0 and $lost > 0) $wl = round(1 / $lost, 1); elseif ($win > 0 and $lost == 0) $wl = round ($win / 1, 1);
                    } else {
                        $wl = round($win / $lost, 1);
                    }
                    $all[$name] = $wl;
                }
            }
        }
        arsort($all);
        $all = array_keys($all);
        return $all;
    }
}