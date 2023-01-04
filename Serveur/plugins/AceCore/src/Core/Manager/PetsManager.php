<?php

namespace Core\Manager;

use Core\Core;

class PetsManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }
}