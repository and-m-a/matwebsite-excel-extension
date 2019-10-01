<?php


namespace App\Excel;


use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;

class AppenderBuilder
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function newInstance(...$args): self
    {
        return new self(...$args);
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @param int $count
     * @return RowsAppender
     */
    public function prependEmptyRow(int $count = 1): self
    {
        $this->prependRows = $count;

        return $this;
    }

    /**
     * @param int $count
     * @return RowsAppender
     */
    public function appendEmptyRow(int $count = 1): self
    {
        $this->appendRows = $count;

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

    public function getAppender()
    {
        $appender = 'asd';

        $appender = (new $appender($this->data))->setStyle()->prependEmptyRows();

        foreach ($this->proxies as $proxy => $argumens) {
            $appender = new $proxy(...$argumens);
        }

        return $appender;
    }
}
