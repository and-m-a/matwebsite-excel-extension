<?php


namespace App\Excel;


use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

abstract class Exporter
{
    const HEADERS = [
        'Access-Control-Allow-Origin'  => '*',
        'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Origin, Content-Type, Authorization',
    ];

    const EXPORT_FORMAT = 'xlsx';

    private $defaultPrecision;
    private $rowIndex = 1;

    /**
     * @return Appender[][]
     */
    abstract public function sheets(): array;

    /**
     * Exporter constructor.
     */
    public function __construct()
    {
        $this->defaultPrecision = ini_get('precision');
    }

    public function generate(string $fileName): LaravelExcelWriter
    {
        return Excel::create($fileName, function ($excel) {
            ini_set('precision', $this->defaultPrecision);

            foreach ($this->sheets() as $sheetName => $sheetData) {

                $excel->sheet($sheetName, function (LaravelExcelWorksheet $sheet) use ($sheetData) {

                    foreach ($sheetData as $appender) {
                        $appender->handle($sheet, $this->rowIndex);

                        $this->rowIndex += $appender->getRowsAdded();

                    }
                });
            }
        });
    }

    public function download(string $fileName): void
    {
        $this->generate($fileName)->download(self::EXPORT_FORMAT, self::HEADERS);
    }
}
