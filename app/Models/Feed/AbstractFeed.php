<?php

namespace App\Models\Feed;

use Exception;

abstract class AbstractFeed
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var array
     */
    protected $columnNames = [];

    /**
     * Feed constructor.
     */
    public function __construct(string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new Exception("File '$filePath' doesn't exitst!");
        }
        $this->filePath = $filePath;
        $this->init();
    }

    /**
     * Init func
     */
    abstract function init(): void;

    /**
     * Return an array of columns
     * @return array|false
     */
    function getColumnNames()
    {
        return $this->columnNames;
    }

    /**
     * Return next row from the feed
     * @return array|false
     */
    abstract function getNextRow();
}
