<?php


namespace App\Excel;


use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;

class SimpleAppender extends RowsAppender
{
    /**
     * @param LaravelExcelWorksheet $sheet
     * @param int $startRow
     * @throws \PHPExcel_Exception
     */
    public function handle(LaravelExcelWorksheet $sheet, int $startRow): void
    {
        $this->appendRow($sheet, $startRow, $this->data);
    }

    /**
     * @return int
     */
    protected function getRowsAddedFromData(): int
    {
        return 1;
    }
}
