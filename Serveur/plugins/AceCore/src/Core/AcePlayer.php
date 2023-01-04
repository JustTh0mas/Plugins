<?php

namespace Core;

use Core\Lang\Deutch;
use Core\Lang\English;
use Core\Lang\French;
use Core\Lang\Spain;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\player\Player;
use pocketmine\player\PlayerInfo;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class AcePlayer extends Player {
    const RANK = [
        "PLAYER" => 0,
        "YOUTUBER" => 1,
        "VIP" => 2,
        "VIP+" => 3,
        "HERO" => 4,
        "CUSTOM" => 5,
        "HELPER" => 6,
        "BUILDER" => 7,
        "MODO" => 8,
        "SUP_MODO" => 9,
        "OWNER" => 10,
    ];
    const RANK_LABEL = [
        self::RANK["PLAYER"] => "",
        self::RANK["YOUTUBER"] => TF::RED . "Youtu" . TF::WHITE. "beur" . TF::RESET,
        self::RANK["VIP"] => TF::YELLOW . "VIP" . TF::RESET,
        self::RANK["VIP+"] => TF::GOLD . "VIP+" . TF::RESET,
        self::RANK["HERO"] => TF::GREEN . "Héro" . TF::RESET,
        self::RANK["CUSTOM"] => TF::BLACK . "Cu" . TF::YELLOW . "st" . TF::DARK_RED . "om" . TF::RESET,
        self::RANK["HELPER"] => TF::GREEN . "Guide" . TF::RESET,
        self::RANK["MODO"] => TF::RED . "Modo" . TF::RESET,
        self::RANK["SUP_MODO"] => TF::DARK_AQUA . "Super-Modo". TF::RESET,
        self::RANK["OWNER"] => TF::AQUA . "Admin" . TF::RESET,
    ];
    const PERMISSIONS = [
        self::RANK["PLAYER"] => [],
        self::RANK["YOUTUBER"] => ["youtuber"],
        self::RANK["VIP"] => ["youtuber", "vip"],
        self::RANK["VIP+"] => ["youtuber", "vip", "vip+"],
        self::RANK["HERO"] => ["youtuber", "vip", "vip+", "hero"],
        self::RANK["CUSTOM"] => ["youtuber", "vip", "vip+", "hero", "custom"],
        self::RANK["HELPER"] => ["youtuber", "vip", "vip+", "hero", "custom", "helper"],
        self::RANK["MODO"] => ["youtuber", "vip", "vip+", "hero", "custom", "helper", "modo"],
        self::RANK["SUP_MODO"] => ["youtuber", "vip", "vip+", "hero", "custom", "helper", "modo", "sup_modo"],
        self::RANK["OWNER"] => ["youtuber", "vip", "vip+", "hero", "custom", "helper", "modo", "sup_modo", "owner"],
    ];
    /**
     * @var bool
     */
    public bool $join = false;
    /**
     * @var bool
     */
    public bool $cosmetics = true;
    /**
     * @var string|bool
     */
    public mixed $nick = false;
    /**
     * @var string|bool
     */
    public mixed $kdm = false;
    /**
     * @var string|bool
     */
    public mixed $tag = false;
    /**
     * @var bool
     */
    public bool $transfer = false;
    /**
     * @var array
     */
    public array $time = [];
    /**
     * @var Core
     */
    private Core $plugin;

    /**
     * @param Server $server
     * @param NetworkSession $session
     * @param PlayerInfo $playerInfo
     * @param bool $authenticated
     * @param Location $spawnLocation
     * @param CompoundTag|null $namedtag
     */
    public function __construct(Server $server, NetworkSession $session, PlayerInfo $playerInfo, bool $authenticated, Location $spawnLocation, ?CompoundTag $namedtag)
    {
        parent::__construct($server, $session, $playerInfo, $authenticated, $spawnLocation, $namedtag);
        $this->plugin = Core::getInstance();
    }

    /**
     * @param string $lang
     * @return Deutch|English|French|Spain
     */
    public function translates(string $lang) {
        if ("en" === $lang) {
            return new English();
        } else if ("fr" === $lang) {
            return new French();
        } else if ("es" === $lang) {
            return new Spain();
        } else if ("de" === $lang) {
            return new Deutch();
        }
        return new French();
    }

    /**
     * @param string $message
     * @param array $args
     * @return string
     */
    public function translateMessage(string $message, array $args): string {
        if (is_array($args)) {
            foreach ($args as $arg) {
                $arg = $arg ?? 0;
                if (is_string($arg) or is_numeric($arg)) {
                    $message = preg_replace("/[%]/", $arg, $message,1);
                }
            }
        }
        return $message;
    }

    /**
     * @param string $message
     * @param array $args
     * @return string
     */
    public function messageToTranslate(string $message, array $args = array()): string {
        $lang = $this->getLang();
        $translates = $this->translates($lang)->translates;
        if (isset($translates[$message])) {
            $msg = $translates[$message];
        } else {
            if ($lang !== "en") {
                $translates = $this->translates("en")->translates;
                if (isset($translates[$message])) {
                    $msg = $translates[$message];
                } else {
                    return $this->translates($lang)->translates["ERROR"] . $message;
                }
            } else {
                return $this->translates($lang)->translates["ERROR"] . $message;
            }
        }
        return $this->translateMessage($msg, $args);
    }

    /**
     * @return bool
     */
    public function isTransfer(): bool {
        return $this->transfer;
    }

    /**
     * @return bool
     */
    public function isCosmetics(): bool {
        return $this->cosmetics;
    }

    /**
     * @param bool $bool
     * @return void
     */
    public function setCosmetics(bool $bool = false): void {
        $this->cosmetics = $bool;
        if (!$this->isCosmetics()) $this->plugin->getSettingsAPI()->getManager()->removeAll($this);
    }

    /**
     * @return bool
     */
    public function isStaff(): bool {
        if ($this->getRank() >= self::RANK["HELPER"] and $this->getRank() <= self::RANK["OWNER"]) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function isVip(): bool {
        if ($this->getRank() >= self::RANK["YOUTUBER"] and $this->getRank() <= self::RANK["OWNER"]) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function isJoin(): bool {
        return $this->join;
    }

    /**
     * @return void
     */
    public function setJoin(): void {
        $this->join = true;
    }

    /**
     * @return int
     */
    public function getRank(): int {
        return $this->plugin->getGamblerAPI()->getRank($this->getName());
    }

    /**
     * @param int $rank
     * @return bool
     */
    public function setRank(int $rank): bool {
        return $this->plugin->getGamblerAPI()->setRank($this->getName(), $rank);
    }

    /**
     * @return string
     */
    public function getRankPrefix(): string {
        return self::RANK_LABEL[$this->getRank()];
    }

    /**
     * @return string
     */
    public function getLang(): string {
        return $this->plugin->getGamblerAPI()->getLang($this->getName());
    }

    /**
     * @param string $lang
     * @return bool
     */
    public function setLang(string $lang): bool {
        return $this->plugin->getGamblerAPI()->setLang($this->getName(), $lang);
    }

    /**
     * @return int
     */
    public function getPlaytime(): int {
        return $this->plugin->getGamblerAPI()->getPlaytime($this->getName());
    }

    /**
     * @param int $time
     * @return bool
     */
    public function addPlaytime(int $time): bool {
        return $this->plugin->getGamblerAPI()->addPlaytime($this->getName(), $time);
    }

    /**
     * @return int
     */
    public function getXps(): int {
        return $this->plugin->getGamblerAPI()->getXps($this->getName());
    }

    /**
     * @param int $xp
     * @return bool
     */
    public function addXps(int $xp): bool {
        return $this->plugin->getGamblerAPI()->addXps($this->getName(), $xp);
    }

    /**
     * @return string
     */
    public function getIp(): string {
        return $this->plugin->getVerifAPI()->getIp($this->getName());
    }

    /**
     * @return string
     */
    public function getUuid(): string {
        return $this->plugin->getVerifAPI()->getUuid($this->getName());
    }

    /**
     * @return string
     */
    public function getVpn(): string {
        return $this->plugin->getVerifAPI()->getVpn($this->getName());
    }

    /**
     * @return int
     */
    public function getMoney(): int {
        return $this->plugin->getEconomyAPI()->getMoney($this->getName());
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function setMoney(int $amount): bool {
        return $this->plugin->getEconomyAPI()->setMoney($this->getName(), $amount);
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function addMoney(int $amount): bool {
        return $this->plugin->getEconomyAPI()->addMoney($this->getName(), $amount);
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function reduceMoney(int $amount): bool {
        return $this->plugin->getEconomyAPI()->reduceMoney($this->getName(), $amount);
    }

    /**
     * @return int
     */
    public function getToken(): int {
        return $this->plugin->getEconomyAPI()->getToken($this->getName());
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function setToken(int $amount): bool {
        return $this->plugin->getEconomyAPI()->setToken($this->getName(), $amount);
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function addToken(int $amount): bool {
        return $this->plugin->getEconomyAPI()->addToken($this->getName(), $amount);
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function reduceToken(int $amount): bool {
        return $this->plugin->getEconomyAPI()->reduceToken($this->getName(), $amount);
    }

    /**
     * @return string
     */
    public function getPseudo(): string {
        if ($this->nick === false) return $this->getName(); else return $this->nick;
    }

    /**
     * @param string $nick
     * @return void
     */
    public function setNick(string $nick): void {
        $this->nick = $nick;
    }

    /**
     * @return bool
     */
    public function isNick(): bool {
        if ($this->nick === false) return false;
        return true;
    }

    /**
     * @return void
     */
    public function setNewTag(): void {
        if ($this->isNick()) {
            $tag = str_replace($this->getName(), $this->nick, $this->getNameTag());
            $this->setNameTag($tag);
        }
    }

    /**
     * @param string $kdm
     * @return void
     */
    public function setKDM(string $kdm): void {
        $this->kdm = $kdm;
    }

    /**
     * @return bool
     */
    public function hasKDM(): bool {
        if ($this->kdm === false) return false;
        return true;
    }

    /**
     * @return string
     */
    public function getKDM(): string {
        if ($this->kdm === false) return ""; else return $this->kdm;
    }

    /**
     * @param string $tag
     * @return void
     */
    public function setTag(string $tag): void {
        $this->tag = $tag;
    }

    /**
     * @return bool
     */
    public function isTag(): bool {
        if ($this->tag === false) return false;
        return true;
    }

    /**
     * @return string
     */
    public function getTag(): string {
        if ($this->tag === false) return ""; else return $this->tag;
    }
}