<?php

namespace App\Filament\App\Widgets;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Record;
use App\Models\RecordTime;
use App\Models\Reservation;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
class LatestAdminClient extends BaseWidget
{
    protected static ?string $heading = 'appointments Reserved';
    protected static ?int $sort=3;
    protected int|string |array $columnSpan ='full';

    public function table(Table $table): Table
    {

        return $table
            ->query(
               Reservation::query()->whereBelongsTo(Filament::getTenant())
            )
            ->filters([
                Tables\Filters\SelectFilter::make('hall')
                    ->label('Church')
                    ->relationship('hall', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('Appointment')
                    ->relationship('appointment', 'number')
                    ->searchable()
                    ->preload(),
                    Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('From'),
                        DatePicker::make('created_until')->label('To'),
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
                    })


                ])
            ->defaultSort('created_at','desc')
            ->columns([
                Tables\Columns\TextColumn::make('appointment.number')
                    ->label(__('filament.name'))
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hall.name')
                    // ->label(__('filament.date'))
                    ->label('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label(__('from'))
                    ->dateTime('Y-m-d h:i A')
                    // 'h:i A'
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label(__('to'))
                    ->dateTime('Y-m-d h:i A')
                    ->searchable()
                    ->sortable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);

    }

}
