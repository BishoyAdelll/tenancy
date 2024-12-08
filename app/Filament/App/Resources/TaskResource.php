<?php

namespace App\Filament\App\Resources;

use App\Enums\Status;
use App\Filament\App\Resources\TaskResource\Pages;
use App\Filament\App\Resources\TaskResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Task;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-battery-50';
    protected static ?string $navigationGroup='Task Calender';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label(__('name'))
                            ->options(User::all()->pluck('name','id'))
                            ->native(false)
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('appointment_id')
                            ->label(__('appointment_id'))
                            ->options(Appointment::all()->pluck('number','id'))
                            ->native(false)
                            ->searchable()
                            ->preload(),
                        Forms\Components\DatePicker::make('due_date')
                            ->label(__('due_date')),
                        Forms\Components\TimePicker::make('time')
                            ->label(__('time'))
                            ->required()
                        ,
                        Forms\Components\RichEditor::make('description')
                            ->label(__('description')),
                        Forms\Components\Select::make('status')
                            ->label(__('status'))
                            ->required()
                            ->options(Status::class)
                            ->native(false),
                        Forms\Components\TextInput::make('hall')
                            ->required(),
                        Forms\Components\TextInput::make('number')
                            ->required()
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->time('h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')

                    ->icon(fn (string $state): string => match ($state) {
                        Status::Booked->value  => 'heroicon-o-shield-check',
                        Status::Cancelled->value  => 'heroicon-o-x-mark',
                        Status::Confirmed->value => 'heroicon-o-check',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        Status::Booked->value  => 'info',
                        Status::Cancelled->value  => 'danger',
                        Status::Confirmed->value  => 'success',
                        default => 'gray',
                    })
                ,
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'view' => Pages\ViewTask::route('/{record}'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
