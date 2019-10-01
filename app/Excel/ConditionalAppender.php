<?php


namespace App\Excel;


use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;

class ConditionalAppender implements Appender
{
    /**
     * @var RowsAppender
     */
    private $appender;

    /**
     * @var bool
     */
    private $condition;

    /**
     * @var int
     */
    private $rowsAdded = 0;

    public function __construct(Appender $appender, bool $condition)
    {
        $this->appender = $appender;
        $this->condition = $condition;
    }

    public static function newInstance(RowsAppender $newInstance, int $rand)
    {
        return new static($newInstance, $rand);
    }

    public function handle(LaravelExcelWorksheet $sheet, int $startRow): void
    {
        if ($this->condition) {
            $this->appender->handle($sheet, $startRow);

            $this->rowsAdded = $this->appender->getRowsAdded();
        }
    }

    public function getRowsAdded(): int
    {
        return $this->rowsAdded;
    }
}

