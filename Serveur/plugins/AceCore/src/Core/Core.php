<?php

namespace Core;

use Core\API\API;
use Core\API\BanAPI;
use Core\API\CosmeticsAPI;
use Core\API\EconomyAPI;
use Core\API\MuteAPI;
use Core\API\MySQLAPI;
use Core\API\GamblerAPI;
use Core\API\NetworkAPI;
use Core\API\RequestAPI;
use Core\API\ServerAPI;
use Core\API\SettingsAPI;
use Core\API\StaffAPI;
use Core\API\VerifAPI;
use Core\Commands\Commands\Staff\StaffCommand;
use Core\Events\PlayerCreation;
use Core\Events\PlayerJoin;
use Core\Events\PlayerLogin;
use Core\Events\PlayerQuit;
use Core\Utils\Socket;
use pocketmine\plugin\PluginBase;

class Core extends PluginBase {
    /**
     * @var string
     */
    public string $path = "plugins/Core/src/Core/Resources/";
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
        $this->getLogger()->info(Prefix::SERVER . "Core as been enabled !");
        $this->getMySQLApi()->addTables();
        $this->onLoadEvents();
        $this->onLoadCommands();
        $this->getServerAPI()->start($this->getServer()->getPort());
    }

    /**
     * @return void
     */
    public function onDisable(): void {
        foreach ($this->getServer()->getOnlinePlayers() as $players) $players->transfer("185.157.247.59", 19132);
    }

    /**
     * @return void
     */
    private function onLoadEvents(): void {
        new PlayerCreation();
        new PlayerJoin();
        new PlayerQuit();
    }

    private function onLoadCommands(): void {
        $this->getServer()->getCommandMap()->registerAll("ace", [
            new StaffCommand(),
        ]);
    }

    /**
     * @return Socket
     */
    public function getSocket(): Socket {
        return new Socket();
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

    /**
     * @return RequestAPI
     */
    public function getRequestAPI(): RequestAPI {
        return new RequestAPI();
    }

}