<?php
/**
 * Author: Diana Ungaro Arnos <hmdiana@gmail.com>
 * Date: 3/10/16
 * Time: 5:12 PM
 */

namespace DianaArnos\DarkmiraTourBR2016\CharCount;

class Client
{
    private $filePath;
    private $workerHosts = [];
    private $tmpFolder = 'tmp';
    private $filePieces;
    private $buffer = 1024;

    public function __construct($args)
    {
        for ($i = 2; $i < count($args); $i++) {
            array_push($this->workerHosts, $args[$i]);
        }

        $this->filePath = $args[1];
        $this->filePieces = count($this->workerHosts);
    }

    public function run()
    {
        $this->showWorkers();
        $this->splitFile();
//        $this->sendFilePiecesToWorkers();
    }

    protected function showWorkers()
    {
        echo "File: " . $this->filePath . "\n";
        echo "Workers: \n";
        foreach ($this->workerHosts as $host) {
            echo $host . "\n";
        }
    }

    private function splitFile()
    {
        echo "O arquivo será dividido em " . count($this->workerHosts) . " parte(s), uma para cada Worker\n";

        $fileSize = filesize($this->filePath);
        $pieceSize = $fileSize / count($this->workerHosts);
        $handle = fopen($this->filePath, 'rb');

        $i = 1;
        while (!feof($handle)) {
            $buffer = fread($handle, round($pieceSize));
            $pieceName = $this->tmpFolder.'/piece_'.$i.'.txt';
            $fw = fopen($pieceName, 'wb');
            fwrite($fw, $buffer);
            fclose($fw);
            $i++;
        }

        fclose($handle);

    }

}

$client = new Client($argv);
$client->run();
