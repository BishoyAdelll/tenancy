<?php

namespace App\Filament\App\Resources\AdditionResource\Pages;

use App\Filament\App\Resources\AdditionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddition extends EditRecord
{
    protected static string $resource = AdditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
