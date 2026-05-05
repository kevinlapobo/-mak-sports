<?php

namespace App\Filament\Widgets;

use App\Models\Matches;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MatchesByStatusChart extends ApexChartWidget
{
    protected static ?int $sort = 2;
    protected function getType(): string
    {
        return 'pie';
    }

    protected function getHeading(): string
    {
        return 'Matches by Status';
    }

    protected function getOptions(): array
    {
        $scheduled = Matches::where('status', 'scheduled')->count();
        $live = Matches::where('status', 'live')->count();
        $finished = Matches::where('status', 'finished')->count();
        $cancelled = Matches::where('status', 'cancelled')->count();

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [$scheduled, $live, $finished, $cancelled],
            'labels' => ['Scheduled', 'Live', 'Finished', 'Cancelled'],
            'colors' => ['#006633', '#CC0000', '#111827', '#9CA3AF'],
            'legend' => [
                'position' => 'bottom',
            ],
            'dataLabels' => [
                'enabled' => true,
                'style' => [
                    'fontSize' => '12px',
                ],
            ],
        ];
    }
}
