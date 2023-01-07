<?php

declare(strict_types=1);

namespace AceCore\src\muqsit\invmenu\session;

use AceCore\src\muqsit\invmenu\InvMenu;
use AceCore\src\muqsit\invmenu\type\graphic\InvMenuGraphic;

final class InvMenuInfo{

	public function __construct(
		public InvMenu $menu,
		public InvMenuGraphic $graphic,
		public ?string $graphic_name
	){}
}