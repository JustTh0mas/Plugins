<?php

namespace Core\Utils;

use pocketmine\utils\TextFormat as TF;

interface Cosmetics {
    public const NICK = [
        "SwordLuck",
        "GxMr",
        "HealPrincess",
        "BloodGodzilla",
        "FouMilo",
        "TwoCar",
        "DrakeEmeraude",
        "GamePosé",
        "EpicNaruto",
        "ZeroDog",
        "StormGame",
        "SaleGold",
        "HydroEagle",
        "BraveOxygène",
        "GalacticRed",
        "PredatorReality",
        "NovaRed",
        "SaphireDylan",
        "GxPhantom",
        "PrimusCar",
        "NightAim",
        "SolDylan",
        "DogDeath",
        "BurgerBlue",
        "SwordBrave",
        "FlyLegend",
        "BoeufFire",
        "MrCraft",
        "PokeFreestyle",
        "SkyCloud",
        "PrincessGoku",
        "PoséBlack",
        "MiloFrench",
        "SeaColossus",
        "PhantomV",
        "DocteurTek",
        "RexChocolatine",
        "NoobWait",
        "SaphireDrake",
        "GxDrake",
        "LavaSunshine",
        "BoisTruck",
        "PorteWhite",
        "LotusTek",
        "DrHadess",
        "VadorRider",
        "BoltJackpot",
        "SynnWar",
        "ShadowGt",
        "SushiFou",
        "HyperColossus",
        "JackdanielDr",
        "PythonPython",
        "RedCookie",
        "MrDemon",
        "WarEpic",
        "BlueSol",
        "GameSniper",
        "GokuBœuf",
        "GameCrazy",
        "GamerAura",
        "PrincessPain",
        "NightChocolatine",
        "VadorBurger",
        "HydroBoy",
        "VirusPepito",
        "RushGodzilla",
        "NightFlying",
        "LuckFlying",
        "GeekSmall",
        "FrostGiveup",
        "SwordPoke",
        "TyraCaptain",
        "MajPickle",
        "ShootGoku",
        "PorteDela",
        "NightSushi",
        "SnakeGood",
        "NightSnake",
        "BloodDylan",
        "GiveupNinja",
        "DarkV",
        "EagleStone",
    ];
    public const TAGS = [
        "tag_winner" => TF::YELLOW . "Winner" . TF::RESET,
        "tag_prof" => TF::GREEN . "Professeur" . TF::RESET,
        "tag_chef" => TF::GREEN . "Chef" . TF::RESET,
        "tag_assaillant" => TF::GREEN . "Assaillant" . TF::RESET,
        "tag_protecteur" => TF::GREEN . "Protecteur" . TF::RESET,
        "tag_dueliste" => TF::GREEN . "Dueliste" . TF::RESET,
        "tag_noble" => TF::GREEN . "Noble" . TF::RESET,
        "tag_ancien" => TF::GREEN . "Ancien" . TF::RESET,
        "tag_fanboy" => TF::GREEN . "Fanboy" . TF::RESET,
        "tag_fangirl" => TF::GREEN . "Fangirl" . TF::RESET,
        "tag_orc" => TF::GREEN . "Orc" . TF::RESET,
        "tag_humain" => TF::GREEN . "Humain" . TF::RESET,
        "tag_robot" => TF::GREEN . "Robot" . TF::RESET,
        "tag_aimbot" => TF::GREEN . "Aimbot" . TF::RESET,
        "tag_killaura" => TF::GREEN . "Killaura" . TF::RESET,
        "tag_nain" => TF::GREEN . "Nain" . TF::RESET,
        "tag_enfant" => TF::GREEN . "Enfant" . TF::RESET,
        "tag_gnome" => TF::GREEN . "Gnome" . TF::RESET,
        "tag_elfe" => TF::GREEN . "Elfe" . TF::RESET,
        "tag_clown" => TF::GREEN . "Clown" . TF::RESET,
        "tag_esclave" => TF::GREEN . "Esclave" . TF::RESET,
        "tag_biker" => TF::GREEN . "Biker" . TF::RESET,
        "tag_intello" => TF::GREEN . "Intello" . TF::RESET,
        "tag_dad" => TF::GREEN . "Père" . TF::RESET,
        "tag_mom" => TF::GREEN . "Mère" . TF::RESET,
        "tag_demon" => TF::GREEN . "Démon" . TF::RESET,
        "tag_miner" => TF::GREEN . "Mineur" . TF::RESET,
        "tag_farmer" => TF::GREEN . "Farmeur" . TF::RESET,
        "tag_ange" => TF::GREEN . "Ange" . TF::RESET,
        "tag_maudit" => TF::GREEN . "Maudit" . TF::RESET,
        "tag_recrue" => TF::GREEN . "Recrue" . TF::RESET,
        "tag_paysant" => TF::GREEN . "Paysant" . TF::RESET,
        "tag_dame" => TF::GREEN . "Dame" . TF::RESET,
        "tag_king" => TF::GREEN . "Roi" . TF::RESET,
        "tag_chevalier" => TF::BLUE . "Chevalier" . TF::RESET,
        "tag_vengeur" => TF::BLUE . "Vengeur" . TF::RESET,
        "tag_nolife" => TF::BLUE . "No-Life" . TF::RESET,
        "tag_baron" => TF::BLUE . "Baron" . TF::RESET,
        "tag_el" => TF::BLUE . "El" . TF::RESET,
        "tag_templier" => TF::BLUE . "Templier" . TF::RESET,
        "tag_assassin" => TF::BLUE . "Assassin" . TF::RESET,
        "tag_ninja" => TF::BLUE . "Ninja" . TF::RESET,
        "tag_mage" => TF::BLUE . "Mage" . TF::RESET,
        "tag_barbare" => TF::BLUE . "Barbare" . TF::RESET,
        "tag_archer" => TF::BLUE . "Archer" . TF::RESET,
        "tag_geant" => TF::BLUE . "Géant" . TF::RESET,
        "tag_gobelin" => TF::BLUE . "Gobelin" . TF::RESET,
        "tag_dragon" => TF::BLUE . "Dragon" . TF::RESET,
        "tag_pekka" => TF::BLUE . "Pekka" . TF::RESET,
        "tag_pretre" => TF::BLUE . "Prêtre" . TF::RESET,
        "tag_master" => TF::BLUE . "Maître" . TF::RESET,
        "tag_voleur" => TF::BLUE . "Voleur" . TF::RESET,
        "tag_paladin" => TF::BLUE . "paladin" . TF::RESET,
        "tag_druide" => TF::BLUE . "Druide" . TF::RESET,
        "tag_sorcier" => TF::BLUE . "Sorcier" . TF::RESET,
        "tag_zombie" => TF::BLUE . "Zombie" . TF::RESET,
        "tag_mouton" => TF::BLUE . "mouton" . TF::RESET,
        "tag_drogue" => TF::BLUE . "Drogué" . TF::RESET,
        "tag_champion" => TF::BLUE . "Champion" . TF::RESET,
        "tag_sith" => TF::BLUE . "Sith" . TF::RESET,
        "tag_clone" => TF::BLUE . "Clone" . TF::RESET,
        "tag_parrain" => TF::BLUE . "Parrain" . TF::RESET,
        "tag_traitre" => TF::BLUE . "Traître" . TF::RESET,
        "tag_bouffon" => TF::BLUE . "Bouffon" . TF::RESET,
        "tag_prince" => TF::BLUE . "Prince" . TF::RESET,
        "tag_princesse" => TF::BLUE . "Princesse" . TF::RESET,
        "tag_pirate" => TF::BLUE . "Pirate" . TF::RESET,
        "tag_cowboy" => TF::BLUE . "Cow-Boy" . TF::RESET,
        "tag_indien" => TF::BLUE . "Indien" . TF::RESET,
        "tag_increvable" => TF::DARK_PURPLE . "Increvable" . TF::RESET,
        "tag_trolleur" => TF::DARK_PURPLE . "Trolleur" . TF::RESET,
        "tag_akatsuki" => TF::DARK_PURPLE . "Akatsuki" . TF::RESET,
        "tag_toxic" => TF::DARK_PURPLE . "Toxic" . TF::RESET,
        "tag_relou" => TF::DARK_PURPLE . "Relou" . TF::RESET,
        "tag_genie" => TF::DARK_PURPLE . "Génie" . TF::RESET,
        "tag_elu" => TF::DARK_PURPLE . "Elu" . TF::RESET,
        "tag_jedi" => TF::DARK_PURPLE . "Jedi" . TF::RESET,
        "tag_chti" => TF::DARK_PURPLE . "Ch'ti" . TF::RESET,
        "tag_xmen" => TF::DARK_PURPLE . "X-men" . TF::RESET,
        "tag_avengers" => TF::DARK_PURPLE . "Avengers" . TF::RESET,
        "tag_sensei" => TF::DARK_PURPLE . "Sensei" . TF::RESET,
        "tag_hanshi" => TF::DARK_PURPLE . "Hanshi" . TF::RESET,
        "tag_joker" => TF::DARK_PURPLE . "Joker" . TF::RESET,
        "tag_batman" => TF::DARK_PURPLE . "Batman" . TF::RESET,
        "tag_poker" => TF::DARK_PURPLE . "Poker" . TF::RESET,
        "tag_yakuzas" => TF::DARK_PURPLE . "Yakuzas" . TF::RESET,
        "tag_ballas" => TF::DARK_PURPLE . "Ballas" . TF::RESET,
        "tag_vagos" => TF::DARK_PURPLE . "Vagos" . TF::RESET,
        "tag_bloods" => TF::DARK_PURPLE . "Bloods" . TF::RESET,
        "tag_maras" => TF::DARK_PURPLE . "Maras" . TF::RESET,
        "tag_cyborg" => TF::DARK_PURPLE . "Cyborg" . TF::RESET,
        "tag_et" => TF::DARK_PURPLE . "E.T" . TF::RESET,
        "tag_tk78" => TF::GOLD . "TK-78" . TF::RESET,
        "tag_first" => TF::GOLD . "#1" . TF::RESET,
        "tag_404" => TF::GOLD . "Error-404" . TF::RESET,
        "tag_boss" => TF::GOLD . "Boss" . TF::RESET,
        "tag_herobrine" => TF::GOLD . "Herobrine" . TF::RESET,
        "tag_zboub" => TF::GOLD . "Zboub" . TF::RESET,
        "tag_badass" => TF::GOLD . "Badass" . TF::RESET,
        "tag_jul" => TF::GOLD . "Jul" . TF::RESET,
        "tag_ziak" => TF::GOLD . "Ziak" . TF::RESET,
        "tag_bot" => TF::GOLD . "Bot" . TF::RESET,
        "tag_ms" => TF::GOLD . "0ms" . TF::RESET,
        "tag_ping" => TF::GOLD . "0 Ping" . TF::RESET,
        "tag_legende" => TF::GOLD . "Légende" . TF::RESET,
        "tag_ffa" => TF::RED . "#1 FFA" . TF::RESET,
        "tag_kill" => TF::RED . "#1 Kill" . TF::RESET,
        "tag_death" => TF::RED . "#1 Death" . TF::RESET,
        "tag_kd" => TF::RED . "#1 KD" . TF::RESET,
        "tag_just" => TF::RED . "Just" . TF::RESET,
        "tag_albator" => TF::RED . "Albator" . TF::RESET,
        "tag_2023" => TF::RED . "2023" . TF::RESET,
        "tag_pegi" => TF::RED . "Pegi 18" . TF::RESET,
        "tag_winstreak" => TF::RED . "#1 Win Streak" . TF::RESET,
        "tag_unique" => TF::RED . "Unique" . TF::RESET,
        "tag_belgique" => TF::BLACK . "Bel" . TF::YELLOW . "gi" . TF::DARK_RED . "que" . TF::RESET,
        "tag_france" => TF::BLUE . "Fr" . TF::WHITE . "an" . TF::DARK_RED . "ce" . TF::RESET,
        "tag_spain" => TF::DARK_RED . "Spa" . TF::YELLOW . "in" . TF::RESET,
        "tag_quebec" => "",
        "tag_malus" => TF::LIGHT_PURPLE . "Malus" . TF::RESET,
        "tag_ace" => TF::RED . "Ace" . TF::RESET,
        "tag_luffy" => TF::YELLOW . "Luffy" . TF::RESET,
        "tag_zoro" => TF::GREEN . "Z" . TF::DARK_PURPLE . "o" . TF::GREEN . "r" . TF::DARK_PURPLE . "o" . TF::RESET,
        "tag_nike" => TF::BLACK . "Nike". TF::RESET,
        "tag_addidas" => TF::BLACK . "Add" . TF::WHITE . "idas" . TF::RESET,
        "tag_gucci" => TF::GREEN . "Gu" . TF::RED . "cc" . TF::GREEN . "i" . TF::RESET,
    ];

    public const KDM = [
        "kdm_western" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " s'est fait plomber par " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a perdu son duel face à " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_monorable" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " est mort lors d'un combat serré contre " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " s'incline vaillament face à " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_ferailleur" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " s'est fait déboulonner par " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a envoyé " . TF::AQUA . "%" . TF::YELLOW . " à la casse !",
        ],
        "kdm_pilote" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " à dérapé sur " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a mit un tour d'avance à " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_art" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a taillé en pièce " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a peint son nouveau tableau avec le sang de " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_gore" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a fait sauter la cervelle de " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " vide les entrailles de " . TF::AQUA . "%" . TF::YELLOW . " sur le sol !",
        ],
        "kdm_cuisine" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a fait frire " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a émincé au petits oignons " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_mythologie" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a chassé " . TF::AQUA . "%" . TF::YELLOW . " de l'olympe !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a décimé " . TF::AQUA . "%" . TF::YELLOW . " avec son trident !",
        ],
        "kdm_medieval" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a tranché la tête de " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a gagné sa joute face à " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_politique" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " fait baisser dans les sondages " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " vient de mettre fin au mandat de " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_pirate" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a envoyé " . TF::AQUA . "%" . TF::YELLOW . " nourrir les poissons !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a balancé " . TF::AQUA . "%" . TF::YELLOW . " par-dessus bord !",
        ],
        "kdm_makeup" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a refait une bauté à " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a tiré les cheuveux de " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_spatial" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " a propulsé " . TF::AQUA . "%" . TF::YELLOW . " dans l'espace !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " a balancé " . TF::AQUA . "%" . TF::YELLOW . " dans un trou noir !",
        ],
        "kdm_potter" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " vient de renvoyer " . TF::AQUA . "%" . TF::YELLOW . " étudier à Poudlard afin de devenir meilleur !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " lance Avada Kedavra sur " . TF::AQUA . "%" . TF::YELLOW . " !",
        ],
        "kdm_competitif" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " vient de donner une leçon à " . TF::AQUA . "%" . TF::YELLOW . " !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " vient de montrer à " . TF::AQUA . "%" . TF::YELLOW . " la différence de niveau qui les séparent !",
        ],
        "kdm_catch" => [
            "kill" => TF::GOLD . "% a assomé " . TF::AQUA . "%" . TF::GOLD . " avec une chaise !",
            "duel" => TF::GOLD . "% a fait passer " . TF::AQUA . "%" . TF::GOLD . " PAR DESSUS LA TROISIEME CORDE !!!",
        ],
        "kdm_mma" => [
            "kill" => TF::GOLD . "% a mit un uppercut à " . TF::AQUA . "%" . TF::GOLD . " !",
            "duel" => TF::GOLD . "% a mit K.O " . TF::AQUA . "%" . TF::GOLD . " !",
        ],
        "kdm_bagarreur" => [
            "kill" => TF::GOLD . "% à mit un coup d'tête, balayette à " . TF::AQUA . "%" . TF::GOLD . " !",
            "duel" => TF::GOLD . "% bombe le torse et gifle " . TF::AQUA . "%" . TF::GOLD . " !",
        ],
        "kdm_princess" => [
            "kill" => TF::GOLD . "%" . TF::YELLOW . " vient d'abattre " . TF::AQUA . "%" . TF::YELLOW . ". Elle était sa " . TF::AQUA . "%" . TF::YELLOW . " cible !",
            "duel" => TF::GOLD . "%" . TF::YELLOW . " vient d'éxécuter " . TF::AQUA . "%" . TF::YELLOW . ". Ele était sa " . TF::AQUA . "%" . " prétandante !",
        ],
        "kdm_pokemon" => [
            "kill" => TF::GOLD . "%" . TF::RED . " a capturé " . TF::AQUA . "%" . TF::RED . " !",
            "duel" => TF::GOLD . "%" . TF::RED . " fait s'envoler vers d'autre cieux " . TF::AQUA . "%" . TF::RED . " !",
        ],
        "kdm_kill" => [
            "kill" => TF::GOLD . "%" . TF::RED . " a tué " . TF::AQUA . "%" . TF::RED . " et a effectué sa " . TF::AQUA . "%" . TF::RED ." victime !",
            "duel" => TF::GOLD . "%" . TF::RED . " a tué " . TF::AQUA . "%" . TF::RED . " et a gagné son ". TF::AQUA . "%" . TF::RED. " duel !",
        ],
        "kdm_streamhack" => [
            "kill" => TF::GOLD . "%" . TF::RED . " a streamhack " . TF::AQUA . "%" . TF::RED . " !",
            "duel" => TF::GOLD . "%" . TF::RED . " a fait un drama sur " . TF::AQUA . "%" . TF::RED . ". Depuis plus aucune nouvelle de lui !",
        ],
    ];
}