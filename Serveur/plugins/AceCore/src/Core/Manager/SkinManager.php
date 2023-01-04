<?php

namespace Core\Manager;

use Core\Core;

class SkinManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }
}