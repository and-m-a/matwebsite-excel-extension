<?php


namespace App\Excel;


use App\Excel\Styles\BackgroundColour;
use App\Excel\Styles\FontWeight;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\CellWriter;
use PHPExcel_Cell;

abstract class RowsAppender implements Appender
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var Style[]
     */
    protected $styles = [];

    /**
     * @var int
     */
    protected $addRows = 0;

    /**
     * @var int
     */
    protected $startColumn = 'A';

    /**
     * @param LaravelExcelWorksheet $sheet
     * @param int $startRow
     */
    abstract public function handle(LaravelExcelWorksheet $sheet, int $startRow): void;

    /**
     * @return int
     */
    abstract protected function getRowsAddedFromData(): int;

    /**
     * Appender constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param Style $style
     * @return RowsAppender
     */
    public function addStyle(Style $style): self
    {
        $this->styles[] = $style;

        return $this;
    }

    /**
     * @param int $count
     * @return RowsAppender
     */
    public function prependEmptyRow(int $count = 1): self
    {
        $this->addRows += $count;

        return $this;
    }

    /**
     * @param string $column
     * @return RowsAppender
     */
    public function startColumn(string $column): self
    {
        $this->startColumn = $column;

        return $this;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function newInstance(array $data): self
    {
        return new static($data);
    }

    /**
     * @param LaravelExcelWorksheet $worksheet
     * @param int $startRow
     * @param array $data
     * @return void
     * @throws \PHPExcel_Exception
     */
    public function appendRow(LaravelExcelWorksheet $worksheet, int $startRow, array $data): void
    {
        $worksheet->appendRow($this->prepareRowData($data))
            ->row($worksheet->getHighestRow(), function (CellWriter $cell) {
                foreach ($this->styles as $style) {
                    $style->applyStyles($cell);
                }
            });
    }

    /**
     * @param array $data
     * @return array
     * @throws \PHPExcel_Exception
     */
    private function prepareRowData(array $data): array
    {
        $prependCells = PHPExcel_Cell::columnIndexFromString($this->startColumn) - 1;

        $emptyCells = array_fill(0, $prependCells, null);

        return array_merge($emptyCells, $data);
    }

    public function getRowsAdded(): int
    {
        return $this->getRowsAddedFromData() + $this->addRows;
    }

    // STYLES
    public function setBackgroundColour(string $colour): self
    {
        $this->addStyle(new BackgroundColour($colour));

        return $this;
    }

    public function setFontWeight(string $weight): self
    {
        $this->addStyle(new FontWeight($weight));

        return $this;
    }
}


//    public function getRange(LaravelExcelWorksheet $worksheet, array $data): string
//    {
//        $r = $worksheet->getHighestRow();
//        $defaultEndCellIndex = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn($r));
//        $endCellIndex = count($data) + $defaultEndCellIndex;
//        $endCellColumn = PHPExcel_Cell::stringFromColumnIndex($endCellIndex);
//
//        return $this->startColumn . $r . ':' . $endCellColumn . $r;
//    }
