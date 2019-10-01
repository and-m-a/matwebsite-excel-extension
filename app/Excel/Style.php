<?php


namespace App\Excel;


use Maatwebsite\Excel\Writers\CellWriter;

interface Style
{
    public function applyStyles(CellWriter $cell): void;
}
