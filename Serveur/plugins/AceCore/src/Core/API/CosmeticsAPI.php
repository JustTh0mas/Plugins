<?php

namespace Core\API;

use Core\AcePlayer;
use Core\Core;
use Core\Manager\CosmeticsManager;
use Core\Manager\KDMManager;
use Core\Manager\NickManager;
use Core\Manager\PetsManager;
use Core\Manager\SkinManager;
use Core\Manager\TagsManager;
use Core\Utils\Cosmetics;

class CosmeticsAPI {
    /**
     * @var array
     */
    public array $cosmetics = [
        "particles" => [
            "particle_wings",
            "particle_",
        ],
        "gadgets" => [
            "gadget_fly",
            "gadget_",
        ],
        "pets" => [
            "pets_ocelot",
            "pets_",
        ],
        "nick" => [
            "nick_custom",
            "nick_random",
            "nick_list",
        ],
        "capes" => [
            "cape_belgium",
            "cape_",
        ],
        "tags" => [
            "tag_belgique",
            "tag_france",
            "tag_spain",
            "tag_quebec",
            "tag_malus",
            "tag_ace",
            "tag_luffy",
            "tag_zoro",
            "tag_nike",
            "tag_addidas",
            "tag_gucci",
            "tag_winner",
            "tag_prof",
            "tag_chef",
            "tag_assaillant",
            "tag_protecteur",
            "tag_dueliste",
            "tag_noble",
            "tag_ancien",
            "tag_fanboy",
            "tag_fangirl",
            "tag_orc",
            "tag_humain",
            "tag_robot",
            "tag_aimbot",
            "tag_killaura",
            "tag_nain",
            "tag_enfant",
            "tag_gnome",
            "tag_elfe",
            "tag_clown",
            "tag_esclave",
            "tag_biker",
            "tag_intello",
            "tag_dad",
            "tag_mom",
            "tag_demon",
            "tag_miner",
            "tag_farmer",
            "tag_ange",
            "tag_maudit",
            "tag_recrue",
            "tag_paysant",
            "tag_dame",
            "tag_king",
            "tag_chevalier",
            "tag_vengeur",
            "tag_nolife",
            "tag_baron",
            "tag_el",
            "tag_templier",
            "tag_assassin",
            "tag_ninja",
            "tag_mage",
            "tag_barbare",
            "tag_archer",
            "tag_geant",
            "tag_gobelin",
            "tag_dragon",
            "tag_pekka",
            "tag_pretre",
            "tag_master",
            "tag_voleur",
            "tag_paladin",
            "tag_druide",
            "tag_sorcier",
            "tag_zombie",
            "tag_mouton",
            "tag_drogue",
            "tag_champion",
            "tag_sith",
            "tag_clone",
            "tag_parrain",
            "tag_traitre",
            "tag_bouffon",
            "tag_prince",
            "tag_princesse",
            "tag_pirate",
            "tag_cowboy",
            "tag_indien",
            "tag_increvable",
            "tag_trolleur",
            "tag_akatsuki",
            "tag_toxic",
            "tag_relou",
            "tag_genie",
            "tag_elu",
            "tag_jedi",
            "tag_chti",
            "tag_xmen",
            "tag_avengers",
            "tag_sensei",
            "tag_hanshi",
            "tag_joker",
            "tag_batman",
            "tag_poker",
            "tag_yakuzas",
            "tag_ballas",
            "tag_vagos",
            "tag_bloods",
            "tag_maras",
            "tag_cyborg",
            "tag_et",
            "tag_tk78",
            "tag_first",
            "tag_404",
            "tag_boss",
            "tag_herobrine",
            "tag_zboub",
            "tag_badass",
            "tag_jul",
            "tag_ziak",
            "tag_bot",
            "tag_ms",
            "tag_ping",
            "tag_legende",
            "tag_ffa",
            "tag_kill",
            "tag_death",
            "tag_kd",
            "tag_just",
            "tag_albator",
            "tag_2023",
            "tag_pegi",
            "tag_winstreak",
            "tag_unique",
        ],
        "kdmessages" => [
            "kdm_western",
            "kdm_monorable",
            "kdm_ferailleur",
            "kdm_pilote",
            "kdm_art",
            "kdm_gore",
            "kdm_cuisine",
            "kdm_mythologie",
            "kdm_medieval",
            "kdm_politique",
            "kdm_pirate",
            "kdm_makeup",
            "kdm_spatial",
            "kdm_potter",
            "kdm_competitif",
            "kdm_catch",
            "kdm_mma",
            "kdm_bagarreur",
            "kdm_princess",
            "kdm_pokemon",
            "kdm_kill",
            "kdm_streamhack",
        ],
        "skins" => [
        ],
    ];
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
        $stmt = $MySQL->prepare("SELECT COUNT(*) FROM cosmetics WHERE name = ?");
        $stmt->bind_param('s', $name);
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
            $stmt = $MySQL->prepare("INSERT INTO cosmetics (name, nick, gadgets, skins, capes, pets, particles, tags, kdmessages, buy) VALUES (?, 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', '-')");
            $stmt->bind_param('s', $name);
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
        $stmt = $MySQL->prepare("SELECT * FROM cosmetics WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $MySQL->commit();
        $MySQL->close();
        return $result;
    }

    /**
     * @return array
     */
    public function getCosmetics(): array {
        return $this->cosmetics;
    }

    /**
     * @return array
     */
    public function getSkins(): array {
        $skins = [];
        $cDir = scandir($this->plugin->getResourcesPath() . "Images/Skins");
        foreach ($cDir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                $value = str_replace(".png", "", $value, $count);
                if ($count === 1) $skins[] = "skin_" . $value;
            }
        }
        return $skins;
    }

    /**
     * @return void
     */
    public function init(): void {
        $skins = $this->getSkins();
        $this->cosmetics["skins"] = $skins;
    }

    /**
     * @param string $name
     * @param string $column
     * @param string $value
     * @return bool
     */
    public function set(string $name, string $column, string $value): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE cosmetics SET ? = ? WHERE name = ?");
            $stmt->bind_param("sss", $column, $value, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @return array
     */
    public function getBuy(string $name): array {
        $list = $this->get($name)["buy"];
        if ($list == "-") $list = []; else $list = explode(",", $list);
        return $list;
    }

    /**
     * @param string $name
     * @param string $cosmetic
     * @return bool
     */
    public function hasBuy(string $name, string $cosmetic): bool {
        $cosmetics = $this->getBuy($name);
        if (in_array($cosmetic, $cosmetics)) return true;
        return false;
    }

    /**
     * @param string $name
     * @param array $value
     * @return bool
     */
    public function setBuy(string $name, array $value): bool {
        $name = strtolower($name);
        $MySQL = $this->plugin->getMySQLApi()->getData();
        if (count($value) == 0) $values = "-"; else $values = implode(",", $value);
        if ($this->exist($name)) {
            $MySQL->begin_transaction();
            $stmt = $MySQL->prepare("UPDATE cosmetics SET buy = ? WHERE name = ?");
            $stmt->bind_param("ss", $values, $name);
            $stmt->execute();
            $MySQL->commit();
            return true;
        }
        $MySQL->close();
        return false;
    }

    /**
     * @param string $name
     * @param string $cosmetic
     * @return bool
     */
    public function addBuy(string $name, string $cosmetic): bool {
        $name = strtolower($name);
        $cosmetics = $this->getBuy($name);
        $cosmetics[] = $cosmetic;
        return $this->setBuy($name, $cosmetics);
    }

    /**
     * @param int $rank
     * @return array
     */
    public function getCosmeticsByRank(int $rank): array {
        switch ($rank) {
            case AcePlayer::RANK_YOUTUBER:
                $cosmetics = [];
                foreach ($this->getSkins() as $cosmetic) $cosmetics[] = $cosmetic;
                foreach ($this->getCosmetics()["nick"] as $cosmetic) $cosmetics[] = $cosmetic;
                return $cosmetics;
            case AcePlayer::RANK_VIP:
            case AcePlayer::RANK_HELPER:
                $cosmetics = [];
                foreach ($this->getSkins() as $cosmetic) $cosmetics[] = $cosmetic;
                foreach ($this->getCosmetics()["nick"] as $cosmetic) $cosmetics[] = $cosmetic;
                foreach ($this->getCosmetics()["particles"] as $cosmetic) $cosmetics[] = $cosmetic["particles_wings"];
                foreach ($this->getCosmetics()["pets"] as $cosmetic) $cosmetics[] = $cosmetic["pets_pig"];
                return $cosmetics;
        }
        return [];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setCosmetics(string $name): bool {
        $name = strtolower($name);
        $rank = $this->plugin->getGamblerAPI()->getRank($name);
        $cosmetics = $this->getCosmeticsByRank($rank);
        if ($rank >= AcePlayer::RANK_YOUTUBER) {
            if (count($cosmetics) > 0) {
                foreach ($cosmetics as $cosmetic) {
                    if (!$this->hasBuy($name, $cosmetic)) $this->addBuy($name, $cosmetic); return true;
                }
            }
        }
        return false;
    }

    /**
     * @return CosmeticsManager
     */
    public function getManager(): CosmeticsManager {
        return new CosmeticsManager();
    }

    /**
     * @return NickManager
     */
    public function getNickManager(): NickManager {
        return new NickManager();
    }

    /**
     * @return TagsManager
     */
    public function getTagsManager(): TagsManager {
        return new TagsManager();
    }

    /**
     * @return KDMManager
     */
    public function getKDMManager(): KDMManager {
        return new KDMManager();
    }

    /**
     * @return PetsManager
     */
    public function getPetsManager(): PetsManager {
        return new PetsManager();
    }

    /**
     * @return SkinManager
     */
    public function getSkinManager(): SkinManager {
        return new SkinManager();
    }
}