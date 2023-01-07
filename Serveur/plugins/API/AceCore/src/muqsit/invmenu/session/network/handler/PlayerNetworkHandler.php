<?php

declare(strict_types=1);

namespace AceCore\src\muqsit\invmenu\session\network\handler;

use AceCore\src\muqsit\invmenu\session\network\NetworkStackLatencyEntry;
use Closure;

interface PlayerNetworkHandler{

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry;
}