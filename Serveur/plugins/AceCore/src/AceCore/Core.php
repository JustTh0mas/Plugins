<?php

namespace AceCore;

use AceCore\API\API;
use AceCore\API\BanAPI;
use AceCore\API\CosmeticsAPI;
use AceCore\API\EconomyAPI;
use AceCore\API\MuteAPI;
use AceCore\API\MySQLAPI;
use AceCore\API\GamblerAPI;
use AceCore\API\NetworkAPI;
use AceCore\API\ServerAPI;
use AceCore\API\SettingsAPI;
use AceCore\API\StaffAPI;
use AceCore\API\VerifAPI;
use AceCore\Events\PlayerCreation;
use AceCore\Events\PlayerJoin;
use AceCore\Events\PlayerLogin;
use AceCore\Events\PlayerQuit;
use AceCore\Form\SimpleForm;
use pocketmine\plugin\PluginBase;

class Core extends PluginBase {
    /**
     * @var string
     */
    public string $path = "plugins/AceCore/src/AceCore/Resources/";
    /**
     * @var bool
     */
    public bool $cosmetics = true;
    /**
     * @var Core
     */
    public static Core $instance;

    /**
     * @return static
     */
    public static function getInstance(): self {
        return self::$instance;
    }

    /**
     * @return void
     */
    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getLogger()->info(Prefix::SERVER . "AceCore as been enabled !");
        $this->getMySQLApi()->addTables();
        $this->onLoadEvents();
        $this->getServerAPI()->start($this->getServer()->getPort());
    }

    /**
     * @return void
     */
    public function onDisable(): void {
        foreach ($this->getServer()->getOnlinePlayers() as $players) $players->transfer("127.0.0.1", 19132);
    }

    /**
     * @return void
     */
    private function onLoadEvents(): void {
        new PlayerCreation();
        new PlayerJoin();
        new PlayerQuit();
    }

    /**
     * @return string
     */
    public function getResourcesPath(): string {
        return $this->path;
    }

    /**
     * @return MySQLAPI
     */
    public function getMySQLApi(): MySQLAPI {
        return new MySQLAPI();
    }

    /**
     * @return GamblerAPI
     */
    public function getGamblerAPI(): GamblerAPI {
        return new GamblerAPI();
    }

    /**
     * @return VerifAPI
     */
    public function getVerifAPI(): VerifAPI {
        return new VerifAPI();
    }

    /**
     * @return EconomyAPI
     */
    public function getEconomyAPI(): EconomyAPI {
        return new EconomyAPI();
    }

    /**
     * @return BanAPI
     */
    public function getBanAPI(): BanAPI {
        return new BanAPI();
    }

    /**
     * @return MuteAPI
     */
    public function getMuteAPI(): MuteAPI {
        return new MuteAPI();
    }

    /**
     * @return API
     */
    public function getAPI(): API {
        return new API();
    }

    /**
     * @return StaffAPI
     */
    public function getStaffAPI(): StaffAPI {
        return new StaffAPI();
    }

    /**
     * @return SettingsAPI
     */
    public function getSettingsAPI(): SettingsAPI {
        return new SettingsAPI();
    }

    /**
     * @return CosmeticsAPI
     */
    public function getCosmeticsAPI(): CosmeticsAPI {
        return new CosmeticsAPI();
    }

    /**
     * @return bool
     */
    public function isCosmetics(): bool {
        return $this->cosmetics;
    }

    /**
     * @return ServerAPI
     */
    public function getServerAPI(): ServerAPI {
        return new ServerAPI();
    }

    /**
     * @return NetworkAPI
     */
    public function getNetworkAPI(): NetworkAPI {
        return new NetworkAPI();
    }

}