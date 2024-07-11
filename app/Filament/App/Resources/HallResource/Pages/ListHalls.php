<?php

namespace App\Filament\App\Resources\HallResource\Pages;

use App\Filament\App\Resources\HallResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHalls extends ListRecords
{
    protected static string $resource = HallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
