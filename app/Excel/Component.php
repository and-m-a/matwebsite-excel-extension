<?php


namespace App\Excel;


use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;

abstract class Component implements Appender
{
    protected $rows;
    protected $data;
    protected $rowsAdded;

    /**
     * @return Appender[]
     */
    abstract public function rows(): array;

    public function __construct(array $data, array $rows = [])
    {
        $this->rows = $rows;
        $this->data = $data;
    }

    public function handle(LaravelExcelWorksheet $sheet, int $startRow): void
    {
        foreach ($this->rows() as $row) {
            $row->handle($sheet, $startRow);

            $this->rowsAdded += $row->getRowsAdded();
        }
    }

    public function getRowsAdded(): int
    {
        return $this->rowsAdded;
    }

    public static function newInstance(...$args)
    {
        return new static(...$args);
    }
}
