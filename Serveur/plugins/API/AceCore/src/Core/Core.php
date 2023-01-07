<?php

namespace AceCore\src\Core;

use AceCore\src\Core\API\API;
use AceCore\src\Core\API\BanAPI;
use AceCore\src\Core\API\CosmeticsAPI;
use AceCore\src\Core\API\EconomyAPI;
use AceCore\src\Core\API\GamblerAPI;
use AceCore\src\Core\API\MuteAPI;
use AceCore\src\Core\API\MySQLAPI;
use AceCore\src\Core\API\NetworkAPI;
use AceCore\src\Core\API\RequestAPI;
use AceCore\src\Core\API\ServerAPI;
use AceCore\src\Core\API\SettingsAPI;
use AceCore\src\Core\API\StaffAPI;
use AceCore\src\Core\API\VerifAPI;
use AceCore\src\Core\Commands\Staff\StaffCommand;
use AceCore\src\Core\Events\DataPacketReceive;
use AceCore\src\Core\Events\DataPacketSend;
use AceCore\src\Core\Events\PlayerCheat;
use AceCore\src\Core\Events\PlayerCreation;
use AceCore\src\Core\Events\PlayerJoin;
use AceCore\src\Core\Events\PlayerKick;
use AceCore\src\Core\Events\PlayerQuit;
use AceCore\src\Core\Utils\Socket;
use Core\Events\PlayerLogin;
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
        new PlayerKick();
        new PlayerCheat();
        new DataPacketReceive();
        new DataPacketSend();
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