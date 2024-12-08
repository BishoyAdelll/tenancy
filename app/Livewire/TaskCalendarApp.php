<?php

namespace App\Livewire;

use App\Enums\Status;

use App\Filament\Resources\TaskResource;
use App\Models\Appointment;

use App\Models\Task;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class TaskCalendarApp extends FullCalendarWidget
{
    public function duration(Task $task)
    {
        $duration =Appointment::query()->where('number',$task->number)->first();
        return $duration->the_numbers_of_hours;
    }
    public function fetchEvents(array $fetchInfo): array
    {

        return
            Task::query()
            ->where('due_date', '>=', $fetchInfo['start'])
            ->where('due_date', '<=', $fetchInfo['end'])
//            ->when(!auth()->user()->is_admin, function ($query) {
//                return $query->where('user_id', auth()->id());
//            })
                    ->whereBelongsTo(Filament::getTenant())
            ->get()
            ->map(
                fn (Task $task) => EventData::make()
                    ->id($task->id)
                    ->title(Carbon::parse($task->time)->format('h:i A') . '('.$this->duration($task).')' . $task->hall) // Call custom function
                    ->allDay()
                    ->start($task->due_date)
                    ->end($task->due_date)
                    ->backgroundColor($task->status === Status::Booked->value ? '#38bdf8' : ($task->status === Status::Cancelled->value ? '#FE0000' : '#15F5BA'))
                    ->borderColor($task->status === Status::Booked->value ? '#38bdf8' : ($task->status === Status::Cancelled->value ? '#FE0000' : '#15F5BA'))
                    ->textColor('primary')
                    ->url(TaskResource::getUrl('view', [$task->id]))
                    ->toArray()
            )
            ->toArray();
        }

}
