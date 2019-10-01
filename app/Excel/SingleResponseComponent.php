<?php


namespace App\Excel;



class SingleResponseComponent extends Component
{
    public function rows(): array
    {
        return [
            SimpleAppender::newInstance(["Appended from ", $this->data['name']])
                ->startColumn('B'),
        ];
    }
}
