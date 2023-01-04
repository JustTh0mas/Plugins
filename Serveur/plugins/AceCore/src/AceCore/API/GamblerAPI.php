<?php

namespace AceCore\API;

use AceCore\AcePlayer;
use AceCore\Core;

class GamblerAPI {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin= Core::getInstance();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function exist(string $name): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM gambler WHERE name = ?");
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
            $stmt = $MySQL->prepare("INSERT INTO gambler (name, rank, rank_label, perms, lang, playtime, xp, level_xp, connect) VALUES (?, ?, '', '', ?, ?, ?, ?, ?)");
            $rank = AcePlayer::RANK_PLAYER;
            $lang = $this->getCountry($player->getNetworkSession()->getIp());
            $connect = 'Lobby';
            $playtime = 0;
            $xp = 0;
            $level = 0;
            $stmt->bind_param("sssssss", $name, $rank, $lang, $playtime, $xp, $level, $connect);
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
        $stmt = $MySQL->prepare("SELECT * FROM gambler WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $gambler = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($gambler) ? [$name, 0, "", "", "fr", 0, 1, 0, "Lobby"] : $gambler;
        /*
         * 1 = rank
         * 2 = rank_label
         * 3 = perms
         * 4 = lang
         * 5 = playtime
         * 6 = xp
         * 7 = level_xp
         * 8 = server
         */
    }

    /**
     * @param string $name
     * @return int
     */
    public function getRank(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[1];
    }

    /**
     * @param string $name
     * @param int $rank
     * @return bool
     */
    public function setRank(string $name, int $rank): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE gambler SET rank = ? WHERE name = ?");
            $stmt->bind_param("ss", $rank, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getLabel(string $name): string {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[2];
    }

    /**
     * @param string $name
     * @param string $label
     * @return bool
     */
    public function setLabel(string $name, string $label): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE gambler SET rank_label = ? WHERE name = ?");
            $stmt->bind_param("ss", $label, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $name, string $permission): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $stmt = $MySQL->prepare("SELECT perms FROM gambler WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $permissions = explode(',', $row['perms']);
            if (in_array($permission, $permissions)) {
                $MySQL->commit();
                $MySQL->close();
                return true;
            }
        }
        $MySQL->commit();
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param array $permissions
     * @return bool
     */
    public function addPermissions(string $name, array $permissions): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $stmt = $MySQL->prepare("SELECT perms FROM gambler WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $currentPermissions = $row['perms'] !== "" ? explode(',', $row['perms']) : [];
            $newPermissions = array_merge($currentPermissions, $permissions);
            $newPermissionsString = implode(',', $newPermissions);
            $stmt = $MySQL->prepare("UPDATE gambler SET perms = ? WHERE name = ?");
            $stmt->bind_param("ss", $newPermissionsString, $name);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        }
        $MySQL->commit();
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param array $permissions
     * @return bool
     */
    public function removePermissions(string $name, array $permissions): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $stmt = $MySQL->prepare("SELECT perms FROM gambler WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $currentPermissions = explode(',', $row['perms']);
            $newPermissions = array_diff($currentPermissions, $permissions);
            $newPermissionsString = implode(',', $newPermissions);
            $stmt = $MySQL->prepare("UPDATE gambler SET perms = ? WHERE name = ?");
            $stmt->bind_param("ss", $newPermissionsString, $name);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        }
        $MySQL->commit();
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getAllPermissions(string $name): string {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $stmt = $MySQL->prepare("SELECT perms FROM gambler WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $permissions = $row['perms'];
            $permissions = explode(',', $permissions);
            $formattedPermissions = '';
            foreach ($permissions as $permission) {
                $formattedPermissions .= "§6" . $permission . "§f, ";
            }
            $formattedPermissions = rtrim($formattedPermissions, ', ');
        } else {
            $formattedPermissions = 'Aucune permission';
        }
        $MySQL->close();
        return $formattedPermissions;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getLang(string $name): string {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[4];
    }

    /**
     * @param string $name
     * @param string $lang
     * @return bool
     */
    public function setLang(string $name, string $lang): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE gambler SET lang = ? WHERE name = ?");
            $stmt->bind_param("ss", $lang, $name);
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
    public function getPlaytime(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[5];
    }

    /**
     * @param string $name
     * @param int $time
     * @return bool
     */
    public function addPlaytime(string $name, int $time): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE gambler SET playtime = ? WHERE name = ?");
            $playtime = (int) $this->getPlaytime($name) + $time;
            $stmt->bind_param("ss", $playtime, $name);
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
    public function getXps(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[6];
    }

    /**
     * @param string $name
     * @param int $time
     * @return bool
     */
    public function addXps(string $name, int $xp): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE gambler SET xp = ? WHERE name = ?");
            $xps = (int) $this->getXps($name) + $xp;
            $stmt->bind_param("ss", $xps, $name);
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
    public function getLevelXp(string $name): int {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[7];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function addLevelXp(string $name): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE gambler SET level_xp = ? WHERE name = ?");
            $level = (int) $this->getLevelXp($name) + 1;
            $stmt->bind_param("ss", $level, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getConnect(string $name): string {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[8];
    }

    /**
     * @param string $name
     * @param string $data
     * @return bool
     */
    public function setConnect(string $name, string $data): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE gambler SET connect = ? WHERE name = ?");
            $stmt->bind_param("ss", $data, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @return array
     */
    public function getAllPlayers(): array {
        $all = [];
        $MySQL = $this->plugin->getMySQLApi()->getData();
        $MySQL->begin_transaction();
        $result = $MySQL->query("SELECT DISTINCT name FROM gambler");
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
     * @return array
     */
    public function getAllPlayTime(): array
    {
        $all = [];
        $my = $this->plugin->getMySQLApi()->getData();
        $res = $my->query("SELECT name FROM gambler ORDER BY playtime DESC LIMIT 10");
        $my->close();
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $all[] = $row["name"];
            }
        }
        return $all;
    }

    /**
     * @return array
     */
    public function getAllXp(): array
    {
        $all = [];
        $my = $this->plugin->getMySQLApi()->getData();
        $res = $my->query("SELECT name FROM gambler ORDER BY xp DESC LIMIT 10");
        $my->close();
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $all[] = $row["name"];
            }
        }
        return $all;
    }

    /**
     * @param string $ip
     * @return string
     */
    public function getCountry(string $ip): string {
        $query = @unserialize(file_get_contents("http://ip-api.com/php/" . $ip));
        if ($query["status"] !== "success") {
            return "en";
        }
        $cc = strtolower($query["countryCode"]);
        $languageMap = [
            "en" => ["en", "us"],
            "fr" => ["fr", "be", "lu", "ca"],
            "es" => ["es", "br", "me"],
            "de" => ["de"]
        ];
        foreach ($languageMap as $language => $countries) {
            if (in_array($cc, $countries)) {
                return $language;
            }
        }
        return "en";
    }
}