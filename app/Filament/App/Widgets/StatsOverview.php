<?php

namespace App\Filament\App\Widgets;

use App\Enums\Type;
use App\Models\Appointment;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Hall;
use App\Models\Team;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make('Users', Team::find(Filament::getTenant())->first()->members()->count())
                ->description('User counter ')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success')
            ,
            Stat::make('Appointments', Appointment::query()->whereBelongsTo(Filament::getTenant())->count())
                ->description('Total Appointments')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger'),
            Stat::make('Halls', Hall::query()->whereBelongsTo(Filament::getTenant())->where('type',Type::Hall->value)->count())
                ->label('Halls')
                ->description('Halls counter ')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('warning'),
            Stat::make('Church', Hall::query()->whereBelongsTo(Filament::getTenant())->where('type',Type::Church->value)->count())
                ->label('Church')
                ->description('Church counter ')
                ->descriptionIcon('heroicon-o-home-modern')
                ->color('primary'),
        ];
    }
}
