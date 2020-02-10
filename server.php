#!/usr/local/bin/php -q
<?php
require_once 'config.php';

Class Server
{
    private $socket;
    private $connectionTimeSeconds;
    private $limitMessages;

    public function __construct($socketDomain, $connectionTimeSeconds, $limitMessages)
    {
        $this->socket = stream_socket_server($socketDomain, $errNo, $errStr);
        $this->checkSocket($this->socket);
        $this->connectionTimeSeconds = $connectionTimeSeconds;
        $this->limitMessages = $limitMessages;
    }

    public function start()
    {
        while ($connection = stream_socket_accept($this->socket, $this->connectionTimeSeconds)) {
            echo 'Клиент подключился' . "\n";
            $this->message($connection);
            fclose($connection);
            echo 'Соединение закрыто' . "\n";
        }
    }

    private function message($connection)
    {
        for ($i = 0; $i <= $this->limitMessages; $i++) {
            $this->send($connection);
            $this->read($connection);
            sleep(1);
        }
    }

    private function send($connection)
    {
        $message = rand(0, 1000);
        $res = fputs($connection, $message);
        echo 'Отправлено: ' . $message . "\n";
    }

    private function read($connection)
    {
        $response = fread($connection, 1024);
        echo 'Ответ: ' . $response . "\n";
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

$server = new Server($socketDomain, $connectionTimeSeconds, $limitMessages);
$server->start();