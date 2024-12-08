<?php

namespace App\Filament\App\Resources\HallResource\Pages;

use App\Filament\App\Resources\HallResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHall extends ViewRecord
{
    protected static string $resource = HallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
