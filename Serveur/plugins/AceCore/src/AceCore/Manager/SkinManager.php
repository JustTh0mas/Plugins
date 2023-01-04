<?php

namespace AceCore\Manager;

use AceCore\Core;

class SkinManager {
    /**
     * @var Core
     */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }
}