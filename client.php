#!/usr/local/bin/php -q
<?php
require_once 'config.php';

Class Client
{
    private $socket;

    public function __construct($socketDomain)
    {
        $this->socket = stream_socket_client($socketDomain, $errNo, $errStr, 30);
        $this->checkSocket($this->socket);
    }

    public function start()
    {
        while (true) {
            while (!feof($this->socket)) {
                $message = $this->read();
                $this->send($message);
            }
        }
    }

    private function read()
    {
        $message = fread($this->socket, 1024);
        echo "Принято сообщение: " . $message . "\n";
        return $message;
    }

    private function send($message)
    {
        $sendMessage = 'Получено: ' . $message;
        fputs($this->socket, $sendMessage);
    }

    public function checkSocket($socket)
    {
        if (!$socket) {
            echo 'Ошибка создания сокета' . "\n";
            die();
        } else {
            echo 'Ожидаем соединения' . "\n";
        }

    }
}

$client = new Client($socketDomain);
$client->start();