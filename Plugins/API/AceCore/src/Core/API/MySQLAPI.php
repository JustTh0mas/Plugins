<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\Core;
use AceCore\src\Core\Tasks\Async\DataBaseAsyncTask;

class MySQLAPI {
    const HOST = "127.0.0.1";
    const USER = "ace";
    const PASSWORD = '$1$B1F5ZSk4$WO7Njv7iPnjlqQC6xI6uf.';
    const BASE = "ace";

    /**
     * @return \MySQLi
     */
    public function getData(): \MySQLi {
        return new \MySQLi(self::HOST, self::USER, self::PASSWORD, self::BASE);
    }

    /**
     * @param string $text
     * @return void
     */
    public function sendDB(string $text): void {
        Core::getInstance()->getServer()->getAsyncPool()->submitTask(new DataBaseAsyncTask($text));
    }

    /**
     * @return void
     */
    public function addTables(): void {
        $MySQL = $this->getData();
        $MySQL->query("CREATE TABLE IF NOT EXISTS gambler (name TEXT, rank TEXT, rank_label TEXT, lang VARCHAR(2), playtime INT, xp INT, level_xp INT, connect TEXT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS verif (name TEXT, ip TEXT, uuid TEXT, vpn TEXT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS economy (name TEXT, money INT, token INT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS ban (id INT, name TEXT, modo TEXT, ip TEXT, uuid TEXT, time_sec TEXT, reason TEXT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS mute (name LONGTEXT, time LONGTEXT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS staff (name LONGTEXT, vanish TEXT, inventory LONGTEXT, armor LONGTEXT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS settings (name TEXT, private_message TEXT, friend_request TEXT, party_request TEXT, see_players TEXT, particle_mod INT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS cosmetics (name TEXT, nick TEXT, gadgets TEXT, skins TEXT, capes TEXT, pets TEXT, particles TEXT, tags TEXT, kdmessages TEXT, buy LONGTEXT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS server (port INT, count INT, players LONGTEXT, state TEXT)");
        $MySQL->query("CREATE TABLE IF NOT EXISTS `network`(port INT, name TEXT, type TEXT, private TEXT)");
        $MySQL->close();
    }
}