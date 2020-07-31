<?php


namespace App\Models\Report;

/**
 * Generate TSV file report
 * Class TsvOutputReport
 * @package App\Models\Report
 */
class TsvOutputReport extends FileOutputReport implements OutputReportInterface
{
    public function saveRow(array $row): bool
    {
        return fputcsv($this->fileHandler, $row, "\t") !== false;
    }
}
