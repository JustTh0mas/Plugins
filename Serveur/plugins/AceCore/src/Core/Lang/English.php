<?php

namespace Core\Lang;

use Core\Prefix;
use pocketmine\utils\TextFormat as TF;

class English
{
    /**
     * @var array|string[]
     */
    public array $translates = [
        "ERROR" => Prefix::ERROR . TF::RED . "There was a problem with the translation of the message",
        "PERM" => Prefix::SERVER . TF::RED . "Vous n'avez pas la permission d'utiliser cette commande !",
        "USAGE" => Prefix::SERVER . TF::WHITE . "%",
        "CONSOLE" => Prefix::SERVER . TF::RED . "Seul les joueurs peuvent exécuter cette commande !",
        "YES" => "Yes",
        "NO" => "No",
        "EXIST" => Prefix::SERVER . TF::RED . "Le joueur n'existe pas !",
        "CONNECT" => Prefix::SERVER . TF::RED . "Le joueur n'est pas connecté",
        "KDM_MESSAGE" => [
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
        ],
    ];
}
