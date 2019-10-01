<?php


namespace App\Excel;


abstract class SimpleExporter extends Exporter
{
    abstract public function canvas(): array;

    public function sheets(): array
    {
        return [
            'sheet' => $this->canvas()
        ];
    }
}
