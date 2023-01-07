<?php

declare(strict_types=1);

namespace muqsit\invmenu\session\network\handler;

use muqsit\invmenu\session\network\NetworkStackLatencyEntry;
use Closure;

interface PlayerNetworkHandler{

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry;
}