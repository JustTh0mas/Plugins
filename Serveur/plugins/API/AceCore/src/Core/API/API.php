<?php

namespace AceCore\src\Core\API;

use AceCore\src\Core\Core;

class API {
    /** @var Core */
    private Core $plugin;

    public function __construct() {
        $this->plugin = Core::getInstance();
    }

    /**
     * @param int $sec
     * @return string
     */
    public function getTimeFormat(int $sec): string
    {
        $result = '';
        $day = floor($sec / 86400);
        if ($day > 0) {
            $result .= "{$day} Jour(s) ";
        }
        $hours = $sec % 86400;
        $hour = floor($hours / 3600);
        if ($hour > 0) {
            $result .= "{$hour} Heure(s) ";
        }
        $minutes = $hours % 3600;
        $minute = floor($minutes / 60);
        if ($minute > 0) {
            $result .= "{$minute} Minute(s) ";
        }
        $remainings = $minutes % 60;
        $second = ceil($remainings);
        if ($second > 0) {
            $result .= "{$second} Seconde(s)";
        }
        return $result;
    }
}