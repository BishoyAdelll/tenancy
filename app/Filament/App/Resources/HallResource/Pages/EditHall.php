<?php

namespace App\Filament\App\Resources\HallResource\Pages;

use App\Filament\App\Resources\HallResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHall extends EditRecord
{
    protected static string $resource = HallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
