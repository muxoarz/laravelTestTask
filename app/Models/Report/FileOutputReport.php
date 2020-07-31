<?php


namespace App\Models\Report;


/**
 * Simple text file report
 * Class FileOutputReport
 * @package App\Models\Report
 */
class FileOutputReport implements OutputReportInterface
{
    /**
     * @var string
     */
    protected $fileName;
    /**
     * @var resource
     */
    protected $fileHandler;

    /**
     * CsvOutputReport constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
        $this->fileHandler = fopen($this->fileName, "w");
        if ($this->fileHandler === false) {
            throw new Exception("Can't create file '{$this->fileName}'!");
        }
    }

    /**
     * @param array $row
     * @return bool
     */
    public function saveRow(array $row): bool
    {
        return fputs($this->fileHandler, json_encode($row)) !== false;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        fclose($this->fileHandler);
    }

}
