<?php

namespace App\Filament\Resources\CloseResource\Pages;

use App\Filament\Resources\CloseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClose extends ViewRecord
{
    protected static string $resource = CloseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
