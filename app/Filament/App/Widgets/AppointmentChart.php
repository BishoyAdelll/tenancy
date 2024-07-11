<?php

namespace App\Filament\App\Widgets;

use App\Models\Appointment;
use App\Models\Hall;
use App\Models\Record;
use App\Models\User;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AppointmentChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Appointments';


    protected static ?int $sort=3;

    protected function getData(): array
    {
        for ($i = 1; $i < 13; $i++) {
            $test= Appointment::query()->whereBelongsTo(Filament::getTenant())->whereMonth('created_at',$i)->count();
            $bishoy[]=$test;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Appointments For every Month',
                    'data' => $bishoy,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];

    }

    protected function getType(): string
    {
        return 'line';
    }
}
