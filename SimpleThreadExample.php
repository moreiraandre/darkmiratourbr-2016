<?php
/**
 * Author: Diana Ungaro Arnos <hmdiana@gmail.com>
 * Date: 3/9/16
 * Time: 5:45 PM
 */

namespace DianaArnos\DarkmiraTourBR2016;

class SimpleThreadExample extends \Thread
{
    /** @var  int */
    private $workerId = 0;

    public function __construct($id)
    {
        $this->workerId = $id;
    }

    public function run()
    {
        echo "Thread " . $this->workerId . " começou a executar.\n";
        sleep(rand(0, 3));
        echo "Thread " . $this->workerId . " parou de executar.\n";
    }
}

/** @var  array */
$workerPool = [];

foreach (range(0, 10) as $id) {
    $workerPool[$id] = new SimpleThreadExample($id);
    $workerPool[$id]->start();
}

foreach (range(0, 10) as $id) {
    $workerPool[$id]->join();
}