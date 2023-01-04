<?php

namespace AceCore;

use pocketmine\utils\TextFormat as TF;

interface Prefix {
    public const ERROR = TF::WHITE . "(" . TF::RED . "Erreur" . TF::WHITE . ") " . TF::RESET;
    public const SERVER = TF::WHITE. "(" . TF::AQUA . "Ace" . TF::WHITE . ") " . TF::RESET;
    public const CONSOLE = TF::WHITE. "(" . TF::AQUA . "Console" . TF::WHITE . ") " . TF::RESET;
    public const NOT_CONSOLE = TF::WHITE. "(" . TF::AQUA . "Ace" . TF::WHITE . ") " . TF::RESET;
    public const FFA = TF::WHITE. "(" . TF::AQUA . "AceFFA" . TF::WHITE . ") " . TF::RESET;
    public const FACTION = TF::WHITE. "(" . TF::AQUA . "AceFaction" . TF::WHITE . ") " . TF::RESET;
    public const gadget_tntLauncher = "gadget_tntlauncher";

}