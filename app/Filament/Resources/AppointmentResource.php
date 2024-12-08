<?php

namespace App\Filament\Resources;

use App\Enums\Payment;
use App\Enums\Status;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Addition;
use App\Models\Appointment;
use App\Models\Close;
use App\Models\Hall;
use App\Models\Record;
use App\Models\RecordTime;
use App\Models\Reservation;
use App\Models\Task;
use App\Models\Time;
use App\Enums\Type;
use Carbon\Carbon;
use DateTime;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
// use Filament\Forms\Components\Group as ComponentsGroup;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Hamcrest\Core\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Lang;
use NunoMaduro\Collision\Adapters\Phpunit\State;
// use PHPUnit\Metadata\Group;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use function Laravel\Prompts\error;
use function Livewire\on;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';


    public static function getGloballySearchableAttributes(): array
    {
        return ['number', 'email', 'man_name','man_phone','man_name','women_name'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $test= Hall::findOrFail($record->hall)->first();
        return [
            'number' => $record->number,
            'email' => $record->email,
            'man_name' => $record->man_name,
            'women_name' =>$record->women_name,
            'Church  Name' =>$test->name,
            'Party Start' => $record->start_time,
            'Party End' => $record->end_time,
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Group::make()

                    ->schema([
                        Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('number')
                                ->label(__('Appointment Order Number'))
                                ->default('OR-' . random_int(100000, 9999999))
                                ->disabled()
                                ->dehydrated(),
                                Forms\Components\Select::make('team_id')
                                ->label('Team')
                                ->relationship('team','name')
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('man_name')
                                ->label(__('man_name'))
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email')
                                ->label(__('email'))
                                ,
                            Forms\Components\TextInput::make('women_name')
                                ->label(__('women_name'))
                                ->maxLength(255),
                            Forms\Components\TextInput::make('man_phone')
                                ->label(__('man_phone'))
                                ->tel(),
                            Forms\Components\TextInput::make('women_phone')
                                ->label(__('women_phone'))
                                ->tel(),
                            Forms\Components\TextInput::make('man_id')
                                ->label(__('man_id'))
                                ->integer()
                                ->maxLength(14)
                               ,
                            Forms\Components\TextInput::make('women_id')
                                ->label(__('women_id'))
                                ->integer()
                                ->maxLength(14)
                               ,
                               Forms\Components\TextInput::make('address')
                                ->label(__('address'))
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ])->columns(2),
                   ])->columns(2),
                   Group::make()
                   ->schema([
                    Section::make('Status && Payment')
                    ->schema([
                     Forms\Components\Select::make('Payment')
                         ->label(__('payment'))
                     ->required()
                     ->options(Payment::class)
                     ->native(false)
                        ,
                     Forms\Components\Select::make('status')
                         ->label(__('status'))
                     ->required()
                     ->options(Status::class)
                     ->native(false),
                     Forms\Components\FileUpload::make('image')
                                 ->label(__('images'))
                                 ->multiple()
                                 ->downloadable()
                                 ->imageEditor()
                                 ->openable()
                                 ->image()
                             ->columnSpanFull(),
                    ])->columns(2)

                   ]),
                   Section::make('Reservation Information')

                    ->schema([
                        Checkbox::make('is_edited')
                        ->inline()
                        ->live()
                        ->default(1),
                    ])->hiddenOn('create'),

                Forms\Components\Section::make()

                ->schema([
                    Forms\Components\DateTimePicker::make('start_time')
                    ->label(__('start_time'))
                    ->required()
                     ->seconds(false)
                    ->minDate(now()->addYear(1)->startOfYear())
                    ->maxDate(now()->addYear(1)->endOfYear())
                    ->live(onBlur: true)
                    ,
                    Forms\Components\DateTimePicker::make('end_time')
                    ->label(__('end_time'))
                    ->required()
                    ->seconds(false)
                    ->minDate(now()->addYear(1)->startOfYear())
                    ->maxDate(now()->addYear(1)->endOfYear())
                        ->afterStateUpdated(function (Get $get,$state,Forms\Set $set){
                            $checkStartTime = Carbon::parse($get('start_time')) ;
                             $checkEndTime = Carbon::parse($state) ;
                             $difrance = $checkStartTime->diffInHours($checkEndTime);
                            $set('the_numbers_of_hours',$difrance);
                        })
                    ->live(onBlur: true)
                    ->time(),


                    Forms\Components\TextInput::make('the_numbers_of_hours')
                    ->label(__('the_numbers_of_hours'))
                    ->required()
                    ->minValue(1)
                    ->readOnly()
                    ->numeric(),

                    Forms\Components\Select::make('hall_id')
                        ->label(__('hall_id'))
                        ->relationship('hall')
                        ->required()
                        ->live(onBlur: true)
                        ->options(function (Get $get): Collection {
                            $checkDate = new DateTime(Carbon::parse($get('start_time'))->toDateString()); // Convert to DateTime object
                            $checkStartTime = Carbon::parse($get('start_time'));
                            $checkEndTime = Carbon::parse($get('end_time'));

                            $nextDay = clone $checkDate; // Create a copy for comparison
                            $nextDay->modify('+1 day'); // Add 1 day to the copy
                            if(
                                $exists = Close::query()
                                    ->where(function ($query) use ($checkStartTime, $checkEndTime) {
                                        $query->where('start_time', '<=', $checkStartTime) // Start time of closing period before or equal to chosen start time
                                        ->where('end_time', '>=', $checkStartTime); // End time of closing period after or equal to chosen start time
                                    })
                                    ->orWhere(function ($query) use ($checkStartTime) {
                                        $query->where('start_time', '<=', $checkStartTime) // Start time of closing period before or equal to chosen start time
                                        ->where('end_time', '>', $checkStartTime); // End time of closing period after the chosen start time
                                    })
                                    ->exists()

                            ){
                                return
                                    Hall::query()
                                        ->whereDoesntHave('reservations', function ($query) use ($checkStartTime, $checkEndTime, $checkDate, $nextDay) {
                                            $query->where(function ($query) use ($checkStartTime, $checkEndTime) {
                                                $query->where('start_time', '<', $checkStartTime) // Bookings must end before chosen start time
                                                ->where('end_time', '>', $checkEndTime); // Bookings must start after chosen end time
                                            })
                                                ->orWhere(function ($query) use ($checkDate, $checkStartTime, $checkEndTime, $nextDay) {
                                                    $query->where('start_time', '<=', $checkStartTime) // Bookings can start before or at chosen start time
                                                    ->where('end_time', '>=', $checkEndTime); // Bookings can end after or at chosen end time
                                                    $query->where(function ($query) use ($checkDate, $nextDay) {
                                                        $query->where('booked_at', '>=', $checkDate->format('Y-m-d 00:00:00')) // Bookings must be on or after the chosen date's start
                                                        ->where('booked_at', '<', $nextDay->format('Y-m-d 00:00:00')); // Bookings must be before the next day's start
                                                    });
                                                });
                                        })->where('type', Type::Hall->value)
                                        ->pluck('name', 'id');
                            }
                                return
                                    Hall::query()
                                        ->whereDoesntHave('reservations', function ($query) use ($checkStartTime, $checkEndTime, $checkDate, $nextDay) {
                                            $query->where(function ($query) use ($checkStartTime, $checkEndTime) {
                                                $query->where('start_time', '<', $checkStartTime) // Bookings must end before chosen start time
                                                ->where('end_time', '>', $checkEndTime); // Bookings must start after chosen end time
                                            })
                                                ->orWhere(function ($query) use ($checkDate, $checkStartTime, $checkEndTime, $nextDay) {
                                                    $query->where('start_time', '<=', $checkStartTime) // Bookings can start before or at chosen start time
                                                    ->where('end_time', '>=', $checkEndTime); // Bookings can end after or at chosen end time
                                                    $query->where(function ($query) use ($checkDate, $nextDay) {
                                                        $query->where('booked_at', '>=', $checkDate->format('Y-m-d 00:00:00')) // Bookings must be on or after the chosen date's start
                                                        ->where('booked_at', '<', $nextDay->format('Y-m-d 00:00:00')); // Bookings must be before the next day's start
                                                    });
                                                });
                                        })->pluck('name', 'id');
                        })
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $hallPrice=Hall::find($state);
                            $totalPrice = $hallPrice->hall_price ?? 0;
                            $checkStartTime = Carbon::parse($get('start_time'));
                            $checkEndTime = Carbon::parse($get('end_time'));
                            $diffInTimes = $checkStartTime->diffInHours($checkEndTime);
                            $set('hall_price', $totalPrice );
                            $set('total_price', $totalPrice * $diffInTimes);
                        }),




                    Forms\Components\TextInput::make('hall_price')
                        ->label(__('hall_price'))
                        ->required()
                        ->live()
                        ->readOnly()
                        ,
                        Forms\Components\TextInput::make('discount_halls')
                        ->required()
                        ->live(onBlur: true)
                        ->default(0)
                        ->numeric(),
                    Forms\Components\TextInput::make('total_price')
                        ->label(__('total_price'))
                        ->required()
                        ->live()
                        ->readOnly()
                        ,
                        Forms\Components\TextInput::make('photography')
                            ->label(__('photography'))
                            ->required()
                            ->live(onBlur: true)
                            ->default(0)
                            ->numeric(),

                        Placeholder::make('.')
//
                        ->content(function (callable $get,Forms\Set $set) {

                             $discount_Price=$get('discount_halls');
                             $difrance = $get('the_numbers_of_hours');
                             $hallPrice=$get('hall_price');
                             $price_hall = $difrance * $hallPrice - $discount_Price ;
                             $set('the_numbers_of_hours',$difrance);
                             $set('total_price',$price_hall);


                        }),
                        Placeholder::make('.')
                        ->inlineLabel()
                    ->content(function(Get $get){
                        $chosenStartTime = Carbon::parse($get('start_time'));
                        $chosenEndTime = Carbon::parse($get('end_time'));
                        $exists = Close::query()
                            ->where(function ($query) use ($chosenStartTime, $chosenEndTime) {
                                $query->where('start_time', '<=', $chosenStartTime) // Start time of closing period before or equal to chosen start time
                                ->where('end_time', '>=', $chosenStartTime); // End time of closing period after or equal to chosen start time
                            })
                            ->orWhere(function ($query) use ($chosenStartTime) {
                                $query->where('start_time', '<=', $chosenStartTime) // Start time of closing period before or equal to chosen start time
                                ->where('end_time', '>', $chosenStartTime); // End time of closing period after the chosen start time
                            })
                            ->exists();
                        if ($exists) {
                            $records = Close::where(function ($query) use ($chosenStartTime, $chosenEndTime) {
                                $query->where('start_time', '<=', $chosenStartTime) // Start time of closing period before or equal to chosen start time
                                ->where('end_time', '>=', $chosenStartTime); // End time of closing period after or equal to chosen start timesen end time
                            })->orWhere(function ($query) use ( $chosenStartTime, $chosenEndTime ) {
                                    $query->where('start_time', '<=', $chosenStartTime) // Start time of closing period before or equal to chosen start time
                                    ->where('end_time', '>', $chosenStartTime); // End time of closingBookings can end after or at chosen end time

                                })->first();
                            return $records->description ?? '';
                        }

                    }),
            ])  ->columns(3)->hidden(fn (Get $get): bool => ! $get('is_edited'))
            ,
            Forms\Components\Section::make()
            ->schema([

                Forms\Components\Repeater::make('additions')
                    ->label(__('additions'))
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('addition_id')
                            ->label(__('additions'))
                            ->required()
                            ->options(Addition::query()->pluck('name','id'))->native(false)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                // $addition = Addition::find($state);
                                $set('price', intval(Addition::find($state)?->price) ?? 0);
                            })
                            ,
                        Forms\Components\TextInput::make('price')
                            ->label(__('addition-price'))
                            ->required()
                            ->live()
                            ->default(0)
                            ->readOnly()
                            ->numeric(),
                            Forms\Components\TextInput::make('quantity')
                            ->label(__('addition-quantity'))
                            ->default(1)
                            ->live()
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('total_addtions')
                            ->label(__('total-addition'))
                            ->readOnly()
                            ->required()
                            ->numeric(),
                            Placeholder::make('.')

                            ->content(function (callable $get, $set) {
                                 $AddtionPrice =$get('price');
                                 $AddtionsQuantity = $get('quantity');
                                 $final=intval($AddtionPrice) * intval($AddtionsQuantity);
                                 $set('total_addtions',$final);
                            }),

                    ])->columns(4),
            ]),Forms\Components\Section::make()
            ->schema([

            Forms\Components\Placeholder::make('grand_total')
                ->label(__('grand_total'))
                ->content(function (callable $get, $set) {
                    $scope=$get('total_price');
                    $photography=$get('photography') !=null ?$get('photography') : 0;
                    $subtotal =  collect($get('additions'))->pluck('total_addtions')->sum();
                    $paid= $get('paid');
                    $subtotal = intval($subtotal+$scope+$photography);
                    $paid= floatval($paid);
                    $grandTotal = ($subtotal) - ($subtotal * (0 / 100)) + ($subtotal - ($subtotal * (0 / 100))) * (0 / 100);
                    $finalTotal=($grandTotal)-$paid;
                    $set('grand_total',$finalTotal);
                    $set('after_discount',$grandTotal);
                    return $grandTotal;
                }),
            Forms\Components\TextInput::make('paid')
                ->label(__('paid'))
                ->required()
                ->numeric()
                ->default(0.00)
                ->reactive()
                ->columns(2),
            Forms\Components\TextInput::make('grand_total')
                ->label(__('grand_total'))
                ->required()
                ->readOnly()
                ->reactive(),
                Forms\Components\TextInput::make('insurance')
                    ->label(__('insurance'))
                    ->required()
                    ->default(2000)
                    ->numeric(),
                    ])->columns(4)

            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label(__('Appointment Order Number'))

                    ->searchable(),
                Tables\Columns\TextColumn::make('man_name')
                ->label(__('man_name'))
                    ->searchable(),
                    Tables\Columns\TextColumn::make('women_name')
                ->label(__('women_name'))
                    ->searchable(),
                    Tables\Columns\TextColumn::make('man_phone')
                ->label(__('man_phone'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('women_phone')
                ->label(__('women_phone'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                ->label(__('email'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                ->label(__('address'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('dates')
                    ->label(__('dates'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('hall')
                    ->label(__('hall'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('residual')
                    ->label(__('residual'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('insurance')
                    ->label(__('insurance'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('photography')
                    ->label(__('photography'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('man_id')
                ->label(__('man_id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('women_id')
                ->label(__('women_id'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_halls')
                ->label(__('discount_halls'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                ->circular()
                ->toggleable(isToggledHiddenByDefault: true)
                ,

                Tables\Columns\TextColumn::make('start_time')
                ->label(__('start_time'))
                    ->dateTime('Y-m-d l h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                ->label(__('end_time'))
                    ->dateTime('Y-m-d l h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('hall.name')
                ->label(__('hall_id'))
                    ->badge()
                    ->color('primary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('confirmedDate')
//                    ->label(__('end_time'))
                    ->dateTime('Y-m-d l h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('status'))
                    ->badge()
                    ->color(fn(Appointment $record)=>( $record->status == Status::Cancelled->value ? 'danger' : ($record->status == Status::Booked->value ?'warning': 'success') ))
                    ->sortable(),
                Tables\Columns\CheckboxColumn::make('is_edited')
                    ->label(__('is_edited'))

                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('Payment')
                    ->label(__('payment'))
                    ->badge()
                    ->color(fn(Appointment $record)=>( $record->Payment == Payment::Visa->value ? Color::Lime :Color::Amber  ))
                    ->sortable(),
                Tables\Columns\TextColumn::make('the_numbers_of_hours')
                ->label(__('duration'))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                ->label(__('discount'))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax')
                ->label(__('tax'))
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                ->label(__('grand_total'))
                    ->suffix(' EG')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                ->label(__('total_price'))
                ->toggleable(isToggledHiddenByDefault: true)
                    ->suffix(' EG')
                    ->searchable(),

                Tables\Columns\TextColumn::make('paid')
                ->label(__('paid'))
                    ->suffix(' EG')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->query(
                Appointment::query()
             )
            ->filters([
                Tables\Filters\SelectFilter::make('hall')
                ->relationship('hall', 'name')
                ->searchable()
                ->preload(),
                Tables\Filters\SelectFilter::make('Payment')
                ->options(Payment::class)
                ->searchable()
                ->preload(),
                Tables\Filters\SelectFilter::make('status')
                ->options(Status::class)
                ->searchable()
                ->preload(),

                Filter::make('record_at')
                ->form([
                    DatePicker::make('created_from')->label('Appointments From'),
                    DatePicker::make('created_until')->label('Appointments To'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    // Check if both created_from and created_until are set
                    if (isset($data['created_from']) && isset($data['created_until'])) {
                        $startDate = Carbon::parse($data['created_from']);
                        $endDate = Carbon::parse($data['created_until']);
                        return $query->whereBetween('start_time', [$startDate, $endDate]); // Filter by check_in between start and end dates
                    }

                    // Return unmodified query if no filters applied
                    return $query;
                }),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })->default(false),
                Filter::make('confirmedDate')
                    ->form([
                        DatePicker::make('confirmedDate'),

                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['confirmedDate'],
                                fn (Builder $query, $date): Builder => $query->whereDate('confirmedDate', '=', $date),
                            );

                    })

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()->hidden(fn(Appointment $record) => ($record->status == Status::Cancelled->value ?true : false )),
                   Tables\Actions\DeleteAction::make()
                       ->after(function (Appointment $record) {
                           Task::query()->where('appointment_id', $record->id)->delete();
                           Notification::make()
                               ->title('The Task is deleted successfully')
                               ->danger()
                               ->body('this Appointment its well deleted from calender')
                               ->duration(5000)
                               ->send();
                           Reservation::query()->where('appointment_id', $record->id)->where('start_time', $record->start_time)->where('end_time', $record->end_time)->delete();
                           Notification::make()
                               ->title('The Reservation is deleted successfully')
                               ->danger()
                               ->body('this Reservation its well deleted from calender')
                               ->duration(5000)
                               ->send();
                       }),
                    Tables\Actions\Action::make('view pdf')
                        ->label('عرض الفاتورة')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Appointment $record) =>route('student.pdf.view',$record))
                        ->openUrlInNewTab(),
                        Tables\Actions\Action::make('Download pdf')
                        ->label('تنزيل الفاتورة')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('info')
                        ->url(fn(Appointment $record) =>route('student.pdf.dwonload',$record))
                        ->openUrlInNewTab(),

                    Tables\Actions\Action::make('view Information')
                        ->label('عرض تفاصيل الخطوبة')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Appointment $appointment) =>route('student.pdf.viewInformation',$appointment))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('Download Information')
                        ->label('طباعة تفاصيل الخطوبة')
                        ->icon('heroicon-o-document')
                        ->url(fn(Appointment $appointment) =>route('student.pdf.generateInformation',$appointment))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('view Crown')
                        ->label('عرض تفاصيل الاكليل')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Appointment $appointment) =>route('student.pdf.viewCrown',$appointment))
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('Download Information')
                        ->label('طباعة تفاصيل الاكليل')
                        ->icon('heroicon-o-document')
                        ->url(fn(Appointment $appointment) =>route('student.pdf.generateCrown',$appointment))
                        ->openUrlInNewTab(),

                ])
                    ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'view' => Pages\ViewAppointment::route('/{record}'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}

