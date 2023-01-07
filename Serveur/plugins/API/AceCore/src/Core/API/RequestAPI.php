<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\Core;

class  RequestAPI {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param string $type
     * @param array $info
     * @return bool
     */
    public function add(string $type, array $info): bool {
        $this->plugin->getSocket()->send($type, $info);
        return true;
    }
}