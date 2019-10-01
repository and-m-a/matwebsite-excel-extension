<?php


namespace App\Excel;


use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;

class BulkAppender extends RowsAppender
{
    protected $toRowCallback;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->toRowCallback = function ($index, $rowData) {
            return $rowData;
        };
    }

    /**
     * @param callable $callback
     * @return BulkAppender
     */
    public function toRow(callable $callback): self
    {
        $this->toRowCallback = $callback;

        return $this;
    }

    /**
     * @param LaravelExcelWorksheet $sheet
     * @param int $startRow
     * @throws \PHPExcel_Exception
     */
    public function handle(LaravelExcelWorksheet $sheet, int $startRow): void
    {
        foreach ($this->data as $index => $rowData) {
            $callback = $this->toRowCallback;

            $this->appendRow($sheet, $startRow, $callback($index, $rowData));
        }
    }

    /**
     * @return int
     */
    protected function getRowsAddedFromData(): int
    {
        return count($this->data);
    }
}
