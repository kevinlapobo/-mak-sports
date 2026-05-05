<?php

namespace App\Filament\Widgets;

use App\Models\VenueBooking;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class VenueBookingsChart extends ApexChartWidget
{
    protected static ?int $sort = 4;
    protected int|array|string $columnSpan = 'full';

    protected function getType(): string
    {
        return 'donut';
    }

    protected function getHeading(): string
    {
        return 'Venue Bookings by Status';
    }

    protected function getOptions(): array
    {
        $pending = VenueBooking::where('status', 'pending')->count();
        $approved = VenueBooking::where('status', 'approved')->count();
        $rejected = VenueBooking::where('status', 'rejected')->count();
        $completed = VenueBooking::where('status', 'completed')->count();

        return [
            'chart' => [
                'type' => 'donut',
                'height' => 300,
            ],
            'series' => [$pending, $approved, $rejected, $completed],
            'labels' => ['Pending', 'Approved', 'Rejected', 'Completed'],
            'colors' => ['#F59E0B', '#006633', '#CC0000', '#3B82F6'],
            'legend' => [
                'position' => 'bottom',
            ],
            'dataLabels' => [
                'enabled' => true,
                'style' => [
                    'fontSize' => '12px',
                ],
            ],
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size' => '65%',
                    ],
                ],
            ],
        ];
    }
}
