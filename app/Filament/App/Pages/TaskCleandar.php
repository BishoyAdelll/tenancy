<?php

namespace App\Filament\App\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Pages\Page;
use Saade\FilamentFullCalendar\Data\EventData;

class TaskCleandar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static string $view = 'filament.pages.task-calendar';

}
