<?php


namespace App\Excel\Exporters;

use App\Excel\BulkAppender;
use App\Excel\ConditionalAppender;
use App\Excel\SimpleAppender;
use App\Excel\SimpleExporter;
use App\Excel\SingleResponseComponent;
use App\User;
use Illuminate\Support\Facades\Auth;

class SampleExporter extends SimpleExporter
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function canvas(): array
    {
        return [
            SimpleAppender::newInstance(["Survey:" . $this->data['survey_name']])
                ->setBackgroundColour('555555')
                ->startColumn('B'),

            BulkAppender::newInstance([
                ['Country ', 'Brasilia'],
                ['Arrival Date ', '2018-01-01'],
                ['Departure Date ', '2018-01-10'],
                ['Age Range ', '1'],
                ['Family Status ', 'couple'],
                ['Purpose of Visit ', 'holiday'],
                ['Number Of Visits ', 3],
            ])->setFontWeight('bold'),

            SimpleAppender::newInstance(['Name', $this->data['guest_name']]),

            ConditionalAppender::newInstance(
                BulkAppender::newInstance([
                    ['Location ', $this->data['location']],
                ]),
                Auth::user()->can('seeGuestLocation', User::class)
            ),

//            RecursieveAppender::newInstance($this->options, function ($options) {
//                return [
//                    SimpleAppender::newInstance($option->first()->a),
//                    SimpleAppender::newInstance([$i - 7]),
//                    SimpleAppender::newInstance([$i * 7]),
//                ];
//            }),

            BulkAppender::newInstance($this->data['answers'])
                ->toRow(function ($answer) {
                    return [$answer['question']['text'], $answer['value']];
                }),

            SingleResponseComponent::newInstance(
                ['name' => 'Single Response Component Sample']
            )
        ];
    }

    public function handle(): void
    {
        $this->download('asd');
    }
}
