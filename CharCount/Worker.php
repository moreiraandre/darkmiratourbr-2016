<?php
/**
 * Author: Diana Ungaro Arnos <hmdiana@gmail.com>
 * Date: 3/10/16
 * Time: 5:13 PM
 */

namespace DianaArnos\DarkmiraTourBR2016\CharCount;

class Worker
{
    private $socket;

    public function __construct($argv)
    {
        $this->socket = $argv[1];
    }

    public function run()
    {
        $server = stream_socket_server("tcp://$this->socket", $errorNum, $errorMsg);

        if ($server === false) {
            throw new \UnexpectedValueException(
                "Não foi possível a conexão com o socket: {$errorNum} - {$errorMsg}" . PHP_EOL
            );
        }

        while ($conn = stream_socket_accept($server)) {
            $result = strlen(base64_decode(fread($conn, 13421772)));
            fwrite($conn, $result . PHP_EOL);
            fclose($conn);
        }

        fclose($server);
    }
}

$worker = new Worker($argv);
$worker->run();
