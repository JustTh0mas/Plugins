<?php

namespace AceCore\src\Core\Manager;

use AceCore\src\Core\Core;

class PetsManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }
}