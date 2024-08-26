<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ColorEntry;
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric()
                    ->label('User ID'),
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->label('Position'),
                Forms\Components\TextInput::make('gender')
                    ->required()
                    ->label('Gender'),
                Forms\Components\TextInput::make('shift')
                    ->required()
                    ->label('Shift'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->rules(['mimes:jpg,jpeg,png', 'max:1024'])  // Validates the image file type and size (max 1MB)
                    ->label('Profile Image'),
                Forms\Components\TextInput::make('experience')
                    ->required()
                    ->numeric()
                    ->label('Experience (Years)'),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->numeric()
                    ->label('Phone Number'),
                Forms\Components\Select::make('department_id')
                    ->required()
                    ->relationship('department','name')
                    ->label('Department Name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shift')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('experience')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                Section::make("Doctor")
                 ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')
                        ->label('Name')
                        ->icon('heroicon-m-user')
                        ->iconColor('primary')
                        ->color('primary')
                        ->weight(FontWeight::Bold)
                        ->fontFamily(FontFamily::Mono)
                        ,
                        TextEntry::make('user.email')
                        ->label('Email')
                        ->icon('heroicon-m-envelope')
                        ->iconColor('primary')
                        ->color('primary')
                        ->weight(FontWeight::Bold)
                        ->fontFamily(FontFamily::Sans),

                        TextEntry::make("id")
                        ->label('Doctor ID')
                        ->color('secondary')
                        ->weight(FontWeight::Light)
                        ->fontFamily(FontFamily::Serif),
                        TextEntry::make('position')
                        ->label('Position')
                        ->color('info')
                        ->weight(FontWeight::Medium)
                        ->fontFamily(FontFamily::Mono),
                        TextEntry::make('gender')
                        ->label('Gender')
                        ->weight(FontWeight::Bold)
                        ->fontFamily(FontFamily::Sans)
                        ->color('success'),
                        TextEntry::make('shift')
                        ->label('Shift')

                        ->color('warning')
                         ->weight(FontWeight::Bold)
                        ->fontFamily(FontFamily::Serif),
                        ImageEntry::make('image')
                        ->label('Profile Image')
                        ->width(100)
                        ->height(50)
                        ,
                        TextEntry::make('phone_number')
                         ->label('Phone Number')
                        ->color('success')
                        ->weight(FontWeight::Bold)
                        ->fontFamily(FontFamily::Sans),
                    ])

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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'view' => Pages\ViewDoctor::route('/{record}'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
