<?php

declare(strict_types=1);

namespace AceCore\src\muqsit\invmenu\type\graphic\network;

use AceCore\src\muqsit\invmenu\session\InvMenuInfo;
use AceCore\src\muqsit\invmenu\session\PlayerSession;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;

final class WindowTypeInvMenuGraphicNetworkTranslator implements InvMenuGraphicNetworkTranslator{

	public function __construct(
		private int $window_type
	){}

	public function translate(PlayerSession $session, InvMenuInfo $current, ContainerOpenPacket $packet) : void{
		$packet->windowType = $this->window_type;
	}
}