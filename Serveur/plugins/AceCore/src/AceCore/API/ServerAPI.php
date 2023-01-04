<?php

namespace AceCore\API;

use AceCore\Core;
use pocketmine\utils\TextFormat as TF;

class ServerAPI {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param string $port
     * @return bool
     */
    public function exist(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM server WHERE port = ?");
        $stmt->bind_param("s", $port);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $MySQL->close();
        return $count > 0 ? true : false;
    }

    /**
     * @param int $port
     * @param int $count
     * @param array $players
     * @return bool
     */
    public function set(int $port, int $count, array $players): bool {
        $play = [];
        foreach ($players as $player) if ($player->isOnline()) $play[] = strtolower($player->getName());
        if (count($play) == 0) $list = "-"; else $list = implode(",", $play);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO server (port, count, players, state) VALUES  (?, ?, ?, 'online')");
            $stmt->bind_param("sss", $port, $count, $list);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE server SET count = ?, players = ? WHERE port = ?");
            $stmt->bind_param("sss", $count, $list, $port);
            $stmt->execute();
            $MySQL->commit();
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
        $stmt = $MySQL->prepare("SELECT * FROM server WHERE port = ?");
        $stmt->bind_param("s", $port);
        $stmt->execute();
        $server = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($server) ? [$port, 0, "-", 'online'] : $server;
        /*
         * 1 = count
         * 2 = players
         * 3 = state
         */
    }

    /**
     * @param int $port
     * @return int
     */
    public function getCount(int $port): int {
        $data = $this->get($port);
        return $data[1];
    }

    /**
     * @param int $port
     * @return array
     */
    public function getPlayers(int $port): array {
        $data = $this->get($port);
        return $data[2];
    }

    /**
     * @param int $port
     * @return void
     */
    public function stop(int $port): void {

    }

    /**
     * @param int $port
     * @return bool
     */
    public function start(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO server (port, count, players, state) VALUES  (?, 0, '-', 'online')");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE server SET count = 0, players = '-', state = 'online' WHERE port = ?");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param int $port
     * @return bool
     */
    public function restart(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO server (port, count, players, state) VALUES  (?, 0, '-', 'restart')");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE server SET count = 0, players = '-', state = 'restart' WHERE port = ?");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param int $port
     * @return bool
     */
    public function inGame(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO server (port, count, players, state) VALUES  (?, 0, '-', 'ingame')");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE server SET state = 'ingame' WHERE port = ?");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param int $port
     * @return bool
     */
    public function online(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO server (port, count, players, state) VALUES  (?, 0, '-', 'online')");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE server SET state = 'online' WHERE port = ?");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param int $port
     * @return bool
     */
    public function instart(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO server (port, count, players, state) VALUES  (?, 0, '-', 'start')");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE server SET state = 'start' WHERE port = ?");
            $stmt->bind_param("s", $port);
            $stmt->execute();
            $MySQL->commit();
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param int $port
     * @return bool
     */
    public function delete(int $port): bool {
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($port)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("DELETE FROM server WHERE port = ?");
            $stmt->bind_param("s", $port);
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
     * @return string
     */
    public function getServer(int $port): string {
        $data = $this->get($port);
        switch ($data[3]) {
            case "start": return "";
            case "stop": return "";
            case "restart": return "";
            case "ingame": return "";
            case "online": return "";
        }
        return "...";
    }

    /**
     * @return array
     */
    public function getAllNetwork(): array {
        $all = [];
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $result = $MySQL->query("SELECT DISTINCT players FROM server");
        $MySQL->commit();
        $MySQL->close();
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                foreach (explode(",", $row["players"]) as $name) {
                    if ($name != "-") {
                        if (!in_array($name, $all)) $all[] = $name;
                    }
                }
            }
        }
        return $all;
    }
}
