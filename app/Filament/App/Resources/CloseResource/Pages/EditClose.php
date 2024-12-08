<?php

namespace App\Filament\App\Resources\CloseResource\Pages;

use App\Filament\App\Resources\CloseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClose extends EditRecord
{
    protected static string $resource = CloseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
