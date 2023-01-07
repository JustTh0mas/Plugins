<?php

namespace AceCore\src\Core\Lang;

use AceCore\src\Core\Prefix;
use pocketmine\utils\TextFormat as TF;

class French {
    /**
     * @var array|string[]
     */
    public array $translates = [
        "ERROR" => Prefix::ERROR . TF::RED . "Il y a eu un problème avec la traduction du message",
        "PERM" => Prefix::SERVER . TF::RED . "Vous n'avez pas la permission d'utiliser cette commande !",
        "USAGE" => Prefix::SERVER . TF::WHITE . "Usage : %",
        "CONSOLE" => Prefix::SERVER . TF::RED . "Seul les joueurs peuvent exécuter cette commande !",
        "YES" => "Oui",
        "NO" => "Non",
        "EXIST" => Prefix::SERVER . TF::RED . "Le joueur n'existe pas !",
        "CONNECT" => Prefix::SERVER . TF::RED . "Le joueur n'est pas connecté",
    ];
}