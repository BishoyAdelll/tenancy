<?php

namespace App\Filament\Resources\CloseResource\Pages;

use App\Filament\Resources\CloseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCloses extends ListRecords
{
    protected static string $resource = CloseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
