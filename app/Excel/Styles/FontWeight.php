<?php


namespace App\Excel\Styles;


use App\Excel\Style;
use Maatwebsite\Excel\Writers\CellWriter;

class FontWeight implements Style
{
    private $weight;

    public function __construct(string $weight)
    {
        $this->weight = $weight;
    }

    public function applyStyle(CellWriter $cell): void
    {
        $cell->setFontWeight($this->weight);
    }
}
