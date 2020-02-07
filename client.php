#!/usr/local/bin/php -q
<?php
include('config.php');

$socket = stream_socket_client($socketDomain, $errNo, $errStr, 30);
if (!$socket) {
    echo sprintf("%s (%d)<br />\n", $errStr, $errNo);
} else {

    while (true) {
        while (!feof($socket)) {
            $message = fread($socket, 1024);
            echo "Принято сообщение: " . $message . "\n";

            $sendMessage = 'Получено: ' . $message;
            fputs($socket, $sendMessage);
        }
    }

    fclose($socket);
}