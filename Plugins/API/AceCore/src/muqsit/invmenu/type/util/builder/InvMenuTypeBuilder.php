<?php

declare(strict_types=1);

namespace AceCore\src\muqsit\invmenu\type\util\builder;

use AceCore\src\muqsit\invmenu\type\InvMenuType;

interface InvMenuTypeBuilder{

	public function build() : InvMenuType;
}