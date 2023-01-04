<?php

namespace AceCore;

use AceCore\Lang\Deutch;
use AceCore\Lang\English;
use AceCore\Lang\French;
use AceCore\Lang\Spain;
use pocketmine\entity\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\player\Player;
use pocketmine\player\PlayerInfo;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class AcePlayer extends Player {

    const RANK_PLAYER = 0;
    const RANK_YOUTUBER = 1;
    const RANK_VIP = 2;
    const RANK_VIP_PLUS = 3;
    const RANK_HERO = 4;
    const RANK_CUSTOM = 5;
    const RANK_HELPER = 6;
    const RANK_BUILDER = 7;
    const RANK_MOD = 8;
    const RANK_SUP_MOD = 9;
    const RANK_OWNER = 10;
    const RANK = [
        self::RANK_PLAYER => "",
        self::RANK_YOUTUBER => TF::RED . "Youtu" . TF::WHITE. "beur" . TF::RESET,
        self::RANK_VIP => TF::YELLOW . "VIP" . TF::RESET,
        self::RANK_VIP_PLUS => TF::GOLD . "VIP+" . TF::RESET,
        self::RANK_HERO => TF::GREEN . "Héro" . TF::RESET,
        self::RANK_CUSTOM => TF::BLACK . "Cu" . TF::YELLOW . "st" . TF::DARK_RED . "om" . TF::RESET,
        self::RANK_HELPER => TF::GREEN . "Guide" . TF::RESET,
        self::RANK_MOD => TF::RED . "Modo" . TF::RESET,
        self::RANK_SUP_MOD => TF::DARK_AQUA . "Super-Modo". TF::RESET,
        self::RANK_OWNER => TF::AQUA . "Admin" . TF::RESET,
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
        if ($this->getRank() >= self::RANK_HELPER and $this->getRank() <= self::RANK_OWNER) return true;
        return false;
    }

    /**
     * @return bool
     */
    public function isVip(): bool {
        if ($this->getRank() >= self::RANK_YOUTUBER and $this->getRank() <= self::RANK_OWNER) return true;
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
        return self::RANK[$this->getRank()];
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
     * @param $name
     * @return bool
     */
    public function hasPermission($name): bool {
        return $this->plugin->getGamblerAPI()->hasPermission($this->getName(), $name);
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function addPermissions(array $permissions): bool {
        return $this->plugin->getGamblerAPI()->addPermissions($this->getName(), $permissions);
    }

    /**
     * @param array $permission
     * @return bool
     */
    public function removePermissions(array $permission): bool {
        return $this->plugin->getGamblerAPI()->removePermissions($this->getName(), $permission);
    }

    /**
     * @return string
     */
    public function getAllPermissions(): string {
        return $this->plugin->getGamblerAPI()->getAllPermissions($this->getName());
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