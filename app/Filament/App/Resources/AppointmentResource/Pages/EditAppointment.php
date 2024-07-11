<?php

namespace App\Filament\App\Resources\AppointmentResource\Pages;

use App\Enums\Status;
use App\Filament\App\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Hall;
use App\Models\Reservation;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['hall_rival']= 0;
        $appointment = Appointment::where('number', $data['number'])->first();

        if ($data['status'] == Status::Cancelled->value) {
            $currentDate = Carbon::now();
            $appointmentStartTime = Carbon::parse($appointment->start_time);
            $created_at = Carbon::parse($appointment->created_at);
            $twoWeeksBefore= $created_at->addWeeks(2);
            $timeDiffInDays = $currentDate->diffInDays($appointmentStartTime, true); // True for absolute value
            $discountPercentage = 0;
            if($currentDate <= $twoWeeksBefore)
            {
                $data['hall_rival'] -= 500;
                $data['residual'] = (  $data['hall_rival'] + $data['grand_total'] );
                return $data;
            }else{

                if ($timeDiffInDays >= 150 ) {
                    $discountPercentage = 10;
                } else if ($timeDiffInDays >= 120) {
                    $discountPercentage = 25;
                }else if ($timeDiffInDays >= 90) {
                    $discountPercentage = 50;
                } else if ($timeDiffInDays >= 60) {
                    $discountPercentage = 75;
                } else if ($timeDiffInDays >= 30) {
                    $discountPercentage = 100;
                }
                if ($discountPercentage > 0) {
                    $discountAmount = $appointment->hall_price * ($discountPercentage / 100);
                    $data['hall_rival'] -= $discountAmount; // Apply discount to hall_rival
                    $data['residual'] = ( $data['hall_rival']  + $data['grand_total'] );
                    return $data;
                }
            }
        }


        return $data;
    }
    protected function afterSave(): void
    {
        $record = $this->record;
        $existingDates = $record->dates ?? [];
        array_push($existingDates, $record->start_time);
        $record->update([
            'dates' => $existingDates,
            // Other fields to update if applicable
        ]);
        $changeStatus=Task::where('number',$record->number)->where('appointment_id',$record->id)->first();
        $reservation=Reservation::where('number',$record->number)->where('appointment_id',$record->id)->first();
        if($record->status == Status::Cancelled->value)
        {
            if($reservation)
            {
                $reservation->delete();
            }
            $changeStatus->update([
                'status' => Status::Cancelled->value
            ]);
        }elseif ($record->status == Status::Confirmed->value)
        {
            $changeStatus->update([
                'status' => Status::Confirmed->value
            ]);
            if(!$record->confirmedDate){
                $record->confirmedDate = \Illuminate\Support\Carbon::now();
                $record->save();
            }
        }
        if ($record->is_edited == 1)
        {
            $dateTime = Carbon::parse($record->start_time); // Replace with your date and time value
            // $dateTimeString = "2024-04-25 14:28:00"; // Replace with your actual date and time value
            // 1. Convert the combined date and time string to a Unix timestamp
            $timestamp = strtotime($dateTime);
            // 2. Extract the time portion using the "H:i:s" format specifier
            $timeOnly = date("H:i:s", $timestamp);
            // $date = $dateTime->toDate();
            $hall=Hall::where('id',$record->hall_id)->first();
            $reservation->update([
                'appointment_id' => $record->id,
                'hall_id' => $record->hall_id,
                'start_time' => $record->start_time,
                'end_time' => $record->end_time,
                'booked_at' => $dateTime->toDate(),
                'number' =>$record->number,
                'team_id'=>$record->team_id
            ]);
            $changeStatus->update([
                'user_id' => Auth::user()->id,
                'time' =>$timeOnly,
                'description' =>'order Number '.$record->number.','.' man_name '.$record->man_name.','.' women Name '. $record->women_name ,
                'due_date' => $record->start_time,
                'appointment_id' => $record->id,
                'hall' => $hall->name,
                'status' => $record->status,
                'number' => $record->number,
                'team_id'=>$record->team_id
            ]);
        }
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
