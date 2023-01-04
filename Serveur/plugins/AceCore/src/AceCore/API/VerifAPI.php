<?php

namespace AceCore\API;

use AceCore\AcePlayer;
use AceCore\Core;

class VerifAPI {
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
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM verif WHERE name = ?");
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
            $stmt = $MySQL->prepare("INSERT INTO verif (name, ip, uuid, vpn) VALUES (?, ?, ?, ?)");
            $ip = $player->getNetworkSession()->getIp();
            $uuid = $player->getUniqueId();
            $vpn = $this->getProxy($ip);
            $stmt->bind_param("ssss", $name, $ip, $uuid, $vpn);
            $stmt->execute();
            $MySQL->commit();
            $MySQL->close();
            return true;
        } else {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE verif SET ip = ?, uuid = ?, vpn = ? WHERE name = ?");
            $ip = $player->getNetworkSession()->getIp();
            $uuid = $player->getUniqueId();
            $vpn = $this->getProxy($ip);
            $stmt->bind_param("ssss", $ip, $uuid, $vpn, $name);
            $stmt->execute();
            $MySQL->commit();
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
        $stmt = $MySQL->prepare("SELECT * FROM verif WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $verif = $stmt->get_result()->fetch_row();
        $MySQL->commit();
        $MySQL->close();
        return is_null($verif) ? [$name, "0.0.0.0", "0-0-0-0", "false"] : $verif;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getIp(string $name): string {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[1];
    }

    /**
     * @param string $name
     * @return string
     */
    public function getUuid(string $name): string {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[2];
    }

    /**
     * @param string $name
     * @return string
     */
    public function getVpn(string $name): string {
        $name = strtolower($name);
        $data = $this->get($name);
        return $data[3];
    }

    /**
     * @param string $ip
     * @return string
     */
    public function getProxy(string $ip): string {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $resp = file_get_contents('http://proxycheck.io/v2/'. $ip . '?key=111111-222222-333333-444444&vpn=1', FILE_TEXT);
            $details = json_decode($resp);
            if (!isset($details->$ip->proxy)) return "false";
            if ($details->$ip->proxy === "no") {
                return "false";
            } else {
                return "true";
            }
        } else {
            return "invalid IP";
        }
    }
}