<?php

namespace App\Filament\Widgets;

use App\Models\Team;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class PlayersPerTeamChart extends ApexChartWidget
{
    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getHeading(): string
    {
        return 'Players per Team';
    }

    protected function getOptions(): array
    {
        $teams = Team::where('is_active', true)
            ->withCount('players')
            ->orderBy('players_count', 'desc')
            ->take(10)
            ->get();

        $labels = [];
        $series = [];

        foreach ($teams as $team) {
            $labels[] = $team->name;
            $series[] = $team->players_count;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Players',
                    'data' => $series,
                ],
            ],
            'labels' => $labels,
            'colors' => ['#006633'],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontSize' => '11px',
                    ],
                    'rotate' => -45,
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
