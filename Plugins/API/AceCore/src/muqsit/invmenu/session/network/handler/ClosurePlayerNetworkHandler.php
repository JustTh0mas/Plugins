<?php

declare(strict_types=1);

namespace muqsit\invmenu\session\network\handler;

use muqsit\invmenu\session\network\NetworkStackLatencyEntry;
use Closure;

final class ClosurePlayerNetworkHandler implements PlayerNetworkHandler{

	/**
	 * @param Closure(Closure) : NetworkStackLatencyEntry $creator
	 */
	public function __construct(
		private Closure $creator
	){}

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry{
		return ($this->creator)($then);
	}
}