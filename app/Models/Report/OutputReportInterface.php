<?php


namespace App\Models\Report;


interface OutputReportInterface
{
    /**
     * OutputReportInterface constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName);

    /**
     * Save report row
     * @param array $row
     * @return bool
     */
    public function saveRow(array $row): bool;
}
