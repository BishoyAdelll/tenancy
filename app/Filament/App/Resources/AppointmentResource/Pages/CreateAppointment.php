<?php

namespace App\Filament\App\Resources\AppointmentResource\Pages;

use App\Filament\App\Resources\AppointmentResource;
use App\Models\Hall;
use App\Models\Reservation;
use App\Models\Task;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
//        dd($data);
        $checkInDate = Carbon::parse($data['start_time']);
        $checkOutDate = Carbon::parse($data['end_time']);
        try {
            // Validate check-out date
            if ($checkOutDate->isBefore($checkInDate)) {
                throw new InvalidDateException(__('The End date or time  cannot be before the start Date or time .'),null);
            }
        } catch (InvalidDateException $e) {
            throw $e; // Re-throw the exception for handling at a higher level
        }


        $data['hall'] = $data['hall_id'];



        return $data;


    }
    protected function afterCreate(): void
    {
        $record=$this->record;
//        dd($record);
        $dateTime = Carbon::parse($record->start_time); // Replace with your date and time value

        $toDateString = Carbon::parse($record->start_time)->format('Y-m-d'); // Replace with your date and time value
        // $dateTimeString = "2024-04-25 14:28:00"; // Replace with your actual date and time value
        $timestamp = strtotime($dateTime);
        $timeOnly = date("H:i:s", $timestamp);
        // $date = $dateTime->toDate();
        $hall=Hall::where('id',$record->hall_id)->first();
        $task=Task::create([
            'user_id' => Auth::user()->id,
            'time' =>$timeOnly,
            'description' =>'order Number '.$record->number.','.' man_name '.$record->man_name.','.' women Name '. $record->women_name ,
            'due_date' => $toDateString,
            'appointment_id' => $record->id,
            'hall' => $hall->name,
            'status' => $record->status,
            'number' => $record->number,
            'team_id'=>$record->team_id
        ]);


        Reservation::create([
            'appointment_id' => $record->id,
            'hall_id' => $record->hall_id,
            'start_time' => $record->start_time,
            'end_time' => $record->end_time,
            'booked_at' => $dateTime->toDate(),
            'number' =>$record->number,
            'team_id'=>$record->team_id
        ]);
        $existingDates = $record->dates ?? [];
        array_push($existingDates, $record->start_time);
        $record->update([
            'dates' => $existingDates,

        ]);



    }
}
