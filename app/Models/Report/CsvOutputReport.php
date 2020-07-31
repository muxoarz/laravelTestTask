<?php


namespace App\Models\Report;

use Exception;

/**
 * Generate CSV file report
 * Class CsvOutputReport
 * @package App\Models\Report
 */
class CsvOutputReport extends FileOutputReport implements OutputReportInterface
{
    /**
     * @param array $row
     * @return bool
     */
    public function saveRow(array $row): bool
    {
        return fputcsv($this->fileHandler, $row) !== false;
    }
}
