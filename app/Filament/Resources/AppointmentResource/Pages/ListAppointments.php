<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Enums\Status;
use App\Filament\Resources\AppointmentResource;
use App\Models\Appointment;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
//        dd(\Illuminate\Support\Carbon::now());
        $tabs = [];

        // Adding `all` as our first tab
        $tabs['all'] = Tab::make('All Appointment')
            // We will add a badge to show how many customers are in this tab
            ->badge(Appointment::count());
        $tabs['Booked'] = Tab::make(' Booked')
            ->badgeColor('success')
            ->badge(Appointment::where('status', Status::Booked->value)->count())
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', Status::Booked->value);
            });
        $tabs['Confirmed'] = Tab::make(' Confirmed')
            ->badgeColor('success')
            ->badge(Appointment::where('status', Status::Confirmed->value)->count())
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', Status::Confirmed->value);
            });
            $tabs['Cancelled'] = Tab::make(' Cancelled')
                ->badgeColor('danger')
                ->badge(Appointment::where('status', Status::Cancelled->value)->count())
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', Status::Cancelled->value);
                });






        return $tabs;
    }
}
