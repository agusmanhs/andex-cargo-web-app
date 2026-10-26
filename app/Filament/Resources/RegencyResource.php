<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegencyResource\Pages;
use App\Models\Province;
use App\Models\Regency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RegencyResource extends Resource
{
    protected static ?string $model = Regency::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Master Wilayah & Tarif';
    protected static ?string $navigationLabel = 'Data Kabupaten / Kota';
    protected static ?string $modelLabel = 'Kabupaten / Kota';
    protected static ?string $pluralModelLabel = 'Daftar Kabupaten & Kota';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('province_code')
                    ->label('Provinsi')
                    ->options(fn () => Province::pluck('name', 'code'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label('Kode Kabupaten / Kota')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kabupaten / Kota')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Wilayah')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->fontFamily('mono')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kabupaten / Kota')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('province.name')
                    ->label('Provinsi')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('province_code')
                    ->label('Filter Provinsi')
                    ->options(fn () => Province::pluck('name', 'code'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegencies::route('/'),
            'create' => Pages\CreateRegency::route('/create'),
            'edit' => Pages\EditRegency::route('/{record}/edit'),
        ];
    }
}
