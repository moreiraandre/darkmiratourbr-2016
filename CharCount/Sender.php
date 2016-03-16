<?php
/**
 * Author: Diana Ungaro Arnos <hmdiana@gmail.com>
 * Date: 3/16/16
 * Time: 8:18 AM
 */

namespace DianaArnos\DarkmiraTourBR2016\CharCount;

class Sender extends \Thread
{
    private $workerHost = '';
    private $text = '';

    public function __construct($workerHost, $text)
    {
        $this->workerHost = $workerHost;
        $this->text = $text;
    }

    public function run()
    {
        $client = stream_socket_client("tcp://$this->workerHost", $errorNum, $errorMsg, 10);

        if ($client == false) {
            throw new \UnexpectedValueException("Falha ao conectar: {$errorNum} - {$errorMsg}". PHP_EOL);
        }

        fwrite($client, base64_encode($this->text));

        return stream_get_contents($client);
    }
}