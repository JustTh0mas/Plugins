<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\AcePlayer;
use AceCore\src\Core\Core;
use Core\Manager\SettingsManager;

class SettingsAPI {
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
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM settings WHERE name = ?");
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
            $stmt = $MySQL->prepare("INSERT INTO settings (name, private_message, friend_request, party_request, see_players, particle_mod) VALUES (?, 'true', 'true', 'true', 'true', 0)");
            $stmt->bind_param("s", $name);
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
        $stmt = $MySQL->prepare("SELECT * FROM settings WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $settings = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($settings) ? [$name, 'true', 'true', 'true', 'true', 0] : $settings ;
        /*
         * 1 = Private message
         * 2 = Friend request
         * 3 = Party request
         * 4 = See players
         * 5 = Scoreboard
         * 6 = Particle mod
         */
    }

    /**
     * @param string $name
     * @return int
     */
    public function getParticleMod(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        if ($this->exist($name)) return (int) $data[6];
        return 0;
    }

    /**
     * @param string $name
     * @param string $column
     * @param mixed $value
     * @return bool
     */
    public function set(string $name, string $column, mixed $value): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE settings SET ? = ? WHERE name = ?");
            $stmt->bind_param("sss", $column, $value, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }
}