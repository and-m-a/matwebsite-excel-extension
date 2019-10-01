<?php


namespace App\Excel;


use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;

interface Appender
{
    public function handle(LaravelExcelWorksheet $sheet, int $startRow): void;

    public function getRowsAdded(): int;
}
