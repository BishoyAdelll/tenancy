<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CloseResource\Pages;
use App\Filament\Resources\CloseResource\RelationManagers;
use App\Models\Close;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Carbon\Carbon;
use Filament\Tables\Table;
use Filament\Forms\Components\Placeholder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CloseResource extends Resource
{
    protected static ?string $model = Close::class;

    protected static ?string $navigationIcon = 'heroicon-o-no-symbol';
    protected static ?string $navigationGroup='Partitions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('start_time')
                    ->label(__('start_time'))
                    ->required()
                ->live(onBlur: true)

                   ,
                Forms\Components\DateTimePicker::make('end_time')
                    ->label(__('end_time'))
                    ->required()
                ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get,$state,Forms\Set $set){
                        $checkStartTime = Carbon::parse($get('start_time'));
                        $checkEndTime = Carbon::parse($state);

                        $difrance =$checkStartTime->diffInHours($checkEndTime) ;
                        $duration = $checkEndTime->diffInDays($checkStartTime);

                        $set('duration',$difrance);
//                            return '  duration by hour  = '.$difrance.  ', duration by days = '.$duration;

                    })
                    ,

                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('duration')
                    ->default(0)
                    ->label('duration')
                    ->readOnly()
                    ,
                        Forms\Components\Select::make('team_id')
                            ->label('Team')
                            ->relationship('team','name')
                            ->searchable()
                            ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_time')

                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')

                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCloses::route('/'),
            'create' => Pages\CreateClose::route('/create'),
            'view' => Pages\ViewClose::route('/{record}'),
            'edit' => Pages\EditClose::route('/{record}/edit'),
        ];
    }
}
