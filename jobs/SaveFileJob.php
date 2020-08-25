<?php

namespace app\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

/**
 * Class SaveFileJob
 * Сохранение данных в текстовый файл
 * @package app\jobs
 */
class SaveFileJob extends BaseObject implements JobInterface
{
    public $filename;
    public $data;
    /**
     * @param Queue $queue
     * @return mixed|void
     */
    public function execute($queue)
    {
        $current = file_get_contents($this->filename);
        $current .= $this->data . "\n";
        file_put_contents($this->filename, $current);
    }
}