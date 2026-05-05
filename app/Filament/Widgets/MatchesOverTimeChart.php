<?php

namespace App\Filament\Widgets;

use App\Models\Matches;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Carbon\Carbon;

class MatchesOverTimeChart extends ApexChartWidget
{
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getHeading(): string
    {
        return 'Matches Over Time';
    }

    protected function getOptions(): array
    {
        $months = [];
        $series = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $count = Matches::whereYear('match_date', $date->year)
                ->whereMonth('match_date', $date->month)
                ->count();
            $series[] = $count;
        }

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
                'toolbar' => [
                    'show' => false,
                ],
            ],
            'series' => [
                [
                    'name' => 'Matches',
                    'data' => $series,
                ],
            ],
            'xaxis' => [
                'categories' => $months,
                'labels' => [
                    'style' => [
                        'fontSize' => '10px',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontSize' => '12px',
                    ],
                ],
            ],
            'stroke' => [
                'curve' => 'smooth',
                'width' => 3,
            ],
            'colors' => ['#006633'],
            'markers' => [
                'size' => 5,
            ],
            'fill' => [
                'type' => 'gradient',
                'gradient' => [
                    'shadeIntensity' => 1,
                    'opacityFrom' => 0.4,
                    'opacityTo' => 0.1,
                ],
            ],
            'grid' => [
                'borderColor' => '#f0f0f0',
            ],
        ];
    }
}
