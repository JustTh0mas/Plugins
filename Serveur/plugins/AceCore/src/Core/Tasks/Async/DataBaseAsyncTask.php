<?php

namespace Core\Tasks\Async;

use Core\Core;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class DataBaseAsyncTask extends AsyncTask {
    /**
     * @var string
     */
    private string $text;

    /**
     * @param string $text
     */
    public function __construct(string $text) {
        $this->text = $text;
    }

    /**
     * @return void
     */
    public function onRun(): void
    {
        // TODO: Implement onRun() method.
    }

    /**
     * @param Server $server
     * @return void
     */
    public function onCompletion(Server $server): void {
        $MySQL = Core::getInstance()->getMySQLApi()->getData();
        $MySQL->query($this->text);
        if ($MySQL->error) new \Exception($MySQL->error);
    }
}
