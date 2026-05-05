<?php

namespace App\Filament\Widgets;

use App\Models\Matches;
use App\Models\Sport;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class MatchesPerSportChart extends ApexChartWidget
{
    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getHeading(): string
    {
        return 'Matches per Sport';
    }

    protected function getOptions(): array
    {
        $sports = Sport::where('is_active', true)->orderBy('display_order')->get();

        $labels = [];
        $series = [];
        $colors = ['#006633', '#CC0000', '#F59E0B', '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6'];

        foreach ($sports as $index => $sport) {
            $labels[] = $sport->name;
            $count = Matches::whereHas('competition.sport', fn($q) => $q->where('slug', $sport->slug))->count();
            $series[] = $count;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Matches',
                    'data' => $series,
                ],
            ],
            'labels' => $labels,
            'colors' => $colors,
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontSize' => '12px',
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
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 4,
                    'horizontal' => false,
                ],
            ],
            'legend' => [
                'show' => false,
            ],
        ];
    }
}
