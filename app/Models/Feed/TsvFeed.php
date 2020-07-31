<?php


namespace App\Models\Feed;

/**
 * Use for standard tab separated files
 * Class CsvFeed
 * @package App\Models\Feed
 */
class TsvFeed extends AbstractFeed
{
    /**
     * @var resource
     */
    protected $fileHandler;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $this->fileHandler = fopen($this->filePath);
        // request first row for column names
        $this->columnNames = $this->getNextRow();
    }

    /**
     * @inheritDoc
     */
    public function getNextRow()
    {
        return fgetcsv($this->fileHandler, 0, "\t");
    }
}
