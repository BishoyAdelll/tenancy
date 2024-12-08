<?php

namespace App\Filament\App\Resources\AdditionResource\Pages;

use App\Filament\App\Resources\AdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdditions extends ListRecords
{
    protected static string $resource = AdditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
