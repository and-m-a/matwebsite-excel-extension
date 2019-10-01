<?php


namespace App\Excel\Styles;


use App\Excel\Style;
use Maatwebsite\Excel\Writers\CellWriter;

class BackgroundColour implements Style
{
    private $colour;

    public function __construct(string $colour)
    {
        $this->colour = $colour;
    }

    public function applyStyles(CellWriter $cell): void
    {
        $cell->setBackground($this->colour);
    }
}
