<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\Core;

class MuteAPI {
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
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM mute WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $MySQL->close();
        return $count > 0 ? true : false;
    }

    /**
     * @param string $name
     * @param string $time
     * @return bool
     */
    public function addMute(string $name, string $time): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (!$this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("INSERT INTO mute (name, time) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $time);
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
     * @return bool
     */
    public function get(string $name): array {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $stmt = $MySQL->prepare("SELECT * FROM mute WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $mute = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($mute) ? [$name, 0] : $mute;
    }

    /**
     * @param string $name
     * @return int
     */
    public function getTime(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[1];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function removeMute(string $name): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("DELETE FROM mute WHERE name = ?");
        $stmt->bind_param("s", $name);
        $result = $stmt->execute();
        $MySQL->close();
        return $result;
    }
}