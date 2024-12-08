<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Enums\Status;
use App\Filament\Resources\AppointmentResource;
use App\Models\Addition;
use App\Models\Appointment;
use App\Models\AppointmentAddition;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewAppointment extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\Action::make('view pdf')
                ->label('عرض الفاتورة')
                ->icon('heroicon-o-eye')
                ->url(fn(Appointment $record) =>route('student.pdf.view',$record))
                ->color('warning')
                ->openUrlInNewTab(),
            Actions\Action::make('view Information')
                ->label('عرض تفاصيل الخطوبة')
                ->color('success')
                ->icon('heroicon-o-eye')
                ->url(fn(Appointment $appointment) =>route('student.pdf.viewInformation',$appointment))
                ->openUrlInNewTab(),
            Actions\Action::make('Send Email ')
//                ->label('عرض تفاصيل الخطوبة')
                ->color('info')
                ->icon('heroicon-o-paper-airplane')
                ->url(fn(Appointment $record) =>route('send.gmail',$record))
                ->hidden(fn(Appointment $record) => ($record->email == null ? true :false))
                ->openUrlInNewTab(),
            Actions\EditAction::make()->hidden(fn(Appointment $record) => ($record->status == Status::Cancelled->value ?true : false )),

        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Split::make([
                    \Filament\Infolists\Components\Section::make('Booking Details')
                        ->description('The Details of Booking ')
                        ->schema([
                            TextEntry::make('man_name')->inlineLabel()
                                ->listWithLineBreaks()
                                ->bulleted(),
                            TextEntry::make('women_name')->inlineLabel()
                                ->listWithLineBreaks()
                                ->bulleted(),
                            TextEntry::make('man_phone')->inlineLabel()
                                ->listWithLineBreaks()
                                ->bulleted(),
                            TextEntry::make('women_phone')->inlineLabel()
                                ->listWithLineBreaks()
                                ->bulleted(),
                            TextEntry::make('address')->inlineLabel()
                                ->listWithLineBreaks()
                                ->bulleted(),
                            TextEntry::make('man_id')->inlineLabel()
                                ->listWithLineBreaks()
                                ->bulleted(),
                            TextEntry::make('women_id')->inlineLabel()
                                ->listWithLineBreaks()
                                ->bulleted(),
                            ImageEntry::make('image'),
                            TextEntry::make('Payment')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('status')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('hall.name')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('hall_price')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('the_numbers_of_hours')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('total_price')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('photography')->inlineLabel()->listWithLineBreaks()->bulleted(),

                            TextEntry::make('discount_halls')->inlineLabel()->listWithLineBreaks()->bulleted(),
//                            TextEntry::make('discount')->inlineLabel()->listWithLineBreaks()->bulleted(),
//                            TextEntry::make('tax')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('paid')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('grand_total')->inlineLabel()->listWithLineBreaks()->bulleted(),
                            TextEntry::make('insurance')->inlineLabel()->listWithLineBreaks()->bulleted(),


                            TextEntry::make('hall_rival')->inlineLabel()->listWithLineBreaks()->bulleted()->visible(fn(Appointment $record) => ( $record->status == Status::Cancelled->value ?  true : false )),
                            TextEntry::make('residual')->inlineLabel()->listWithLineBreaks()->bulleted()->visible(fn(Appointment $record) => ( $record->status == Status::Cancelled->value ?  true : false )),



                        ]),
                ]),
                \Filament\Infolists\Components\Split::make([
                Section::make('additions')

                    ->schema([
                        RepeatableEntry::make('additions')
                            ->label('additions')
                            ->schema([
                                Section::make()
                                ->schema([
                                    TextEntry::make('value')
                                        ->label(fn (AppointmentAddition $record)=>Addition::query()->where('id',$record->addition_id)->value('name'))
                                        ->state(function (AppointmentAddition $record): float {
                                            return $record->price;
                                        })

                                    ,
                                    TextEntry::make('quantity')
                                        ->state(function (AppointmentAddition $record): string {
                                            return $record->quantity;
                                        })
                                ])->columns(2)
                            ]),
                        Section::make('This date has been previously modified')
                        ->schema([
                            TextEntry::make('dates')
                                ->label('privuos edit')
                                ->state(function (Appointment $record) {
                                    $test=[];
                                    foreach ($record->dates as $date){
                                        $test []= Carbon::parse()->format('Y-m-d h:i A');
                                    }
                                    return $test;
                                })->inlineLabel()->color('danger'),
                        ])
                    ]),


                ]),

                \Filament\Infolists\Components\Split::make([
                    \Filament\Infolists\Components\Section::make('Date and Time  Details')
                        ->description('The Appointment chosen ')
                        ->schema([
                            TextEntry::make('start_time')->inlineLabel()->dateTime('Y-m-d l h:i A'),
                            TextEntry::make('end_time')->inlineLabel()->dateTime('Y-m-d l h:i A'),

                        ])
                ])
            ]);
    }
}
//TextEntry::make('dates')
//    ->label('privuos edit')
//    ->state(function (Appointment $record) {
//        $test=[];
//        foreach ($record->dates as $date){
//            $test []= Carbon::parse()->format('Y-m-d h:i A');
//        }
//        return $test;
//    })->inlineLabel() ->color('danger'),
