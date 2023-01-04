<?php

namespace Core\Utils;

class Socket {
    const PORT = 19132;
    /** @var mixed|false|resource|\Socket  */
    private mixed $mainStock;
    /** @var bool  */
    private bool $closed = false;
    /** @var array  */
    public array $data = [];

    public function __construct() {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $res = socket_connect($socket, "127.0.0.1", self::PORT);
        if (!$res) {
            new \Exception("Server doesn't listening !");
            return;
        }
        socket_set_nonblock($socket);
        $this->mainStock = $socket;
    }

    /**
     * @param string $id
     * @param array $data
     * @param bool $save
     * @return void
     */
    public function send(string $id, array $data, bool $save = false): void {
        if ($save) $data = json_encode(["save" => [$id => $data]]); else $data = json_encode([$id => $save]);
        @socket_write($this->mainStock, $data, strlen($data));
    }

    /**
     * @param string $id
     */
    public function remove(string $id): void {
        $data = json_encode(["remove" => $id]);
        @socket_write($this->mainStock, $data, strlen($data));
    }

    /**
     * @return array|string
     */
    public function read(): mixed {
        socket_set_nonblock($this->mainStock);
        $res = @socket_read($this->mainStock, 0xFFFFFF);
        if (socket_last_error($this->mainStock) == 104) {
            $this->closed = true;
            return "";
        }
        return $res;
    }

    /**
     * @return void
     */
    public function close(): void {
        socket_close($this->mainStock);
    }
}