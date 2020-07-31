<?php


namespace App\Models\Feed;

/**
 * Use for standard csv files
 * Class CsvFeed
 * @package App\Models\Feed
 */
class CsvFeed extends AbstractFeed
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
    function getNextRow(): array
    {
        return fgetcsv($this->fileHandler);
    }
}
