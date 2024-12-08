<?php

namespace App\Filament\Resources;

use App\Enums\Status;
use App\Enums\Type;
use App\Filament\Resources\HallResource\Pages;
use App\Filament\Resources\HallResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Hall;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class HallResource extends Resource
{
    protected static ?string $model = Hall::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup='Partitions';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('hall_name'))
                        ->maxLength(255)
                    ->required()
                        ,
                    Forms\Components\Select::make('team_id')
                        ->label('Team')
                        ->relationship('team','name')
                        ->searchable()
                        ->preload(),
                    Forms\Components\Select::make('type')
                        ->label(__('Type'))
                        ->required()
                        ->options(Type::class)
                        ->native(false)
                    ,
                    Forms\Components\TextInput::make('location')
                        ->label(__('hall_location'))
                        ->url()
                        ->suffixIcon('heroicon-m-globe-alt')
                        ->nullable()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('address')
                        ->label(__('hall_address'))
                        ->nullable()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('Maximum_number_of_people')
                        ->label(__('Capacity'))
                        ->required()
                        ->numeric(),

                    Forms\Components\TextInput::make('hall_price')
                        ->label(__('hall_hall_price'))
                        ->required()
                        ->numeric()
                        ,

                ])->columns(2),
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label(__('hall_image'))
                        ->multiple()
                        ->downloadable()
                        ->imageEditor()
//                        ->image()
                        ->openable()
                        ,
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('hall_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->label(__('hall_location'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('hall_address'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('Maximum_number_of_people')
                    ->label(__('Capacity'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hall_price')
                    ->label(__('hall_hall_price'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(Hall $record)=>( $record->type == Type::Church->value ? 'primary' : 'warning' ))
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
            'index' => Pages\ListHalls::route('/'),
            'create' => Pages\CreateHall::route('/create'),
            'view' => Pages\ViewHall::route('/{record}'),
            'edit' => Pages\EditHall::route('/{record}/edit'),
        ];
    }
}
