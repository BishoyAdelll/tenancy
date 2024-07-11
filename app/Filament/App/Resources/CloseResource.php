<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\CloseResource\Pages;
use App\Filament\App\Resources\CloseResource\RelationManagers;
use App\Models\Close;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CloseResource extends Resource
{
    protected static ?string $model = Close::class;

    protected static ?string $navigationIcon = 'heroicon-o-x-mark';
    protected static ?string $navigationGroup='Partitions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('start_time')
                    ->label(__('start_time'))
                    ->required()
                    ->live()
                ,
                Forms\Components\DateTimePicker::make('end_time')
                    ->label(__('end_time'))
                    ->required()
                    ->live()
                ,

                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Placeholder::make('.')
                    // ->label(__('difference_between_hours'))
                    ->content(function (callable $get) {
                        $checkStartTime = Carbon::parse($get('start_time'));
                        $checkEndTime = Carbon::parse($get('end_time'));

                        $difrance = $checkStartTime->diffInHours($checkEndTime);
                        $duration = $checkStartTime->diffInDays($checkEndTime);



                        return '  duration by hour  = '.$difrance.  ', duration by days = '.$duration;



                    }),
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
