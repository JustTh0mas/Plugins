<?php

declare(strict_types=1);

namespace AceCore\src\muqsit\invmenu\type;

use AceCore\src\muqsit\invmenu\InvMenu;
use AceCore\src\muqsit\invmenu\type\graphic\InvMenuGraphic;
use pocketmine\inventory\Inventory;
use pocketmine\player\Player;

interface InvMenuType{

	public function createGraphic(InvMenu $menu, Player $player) : ?InvMenuGraphic;

	public function createInventory() : Inventory;
}