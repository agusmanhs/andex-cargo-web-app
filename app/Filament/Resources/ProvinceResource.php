<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProvinceResource\Pages;
use App\Models\Province;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProvinceResource extends Resource
{
    protected static ?string $model = Province::class;
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Master Wilayah & Tarif';
    protected static ?string $navigationLabel = 'Data Provinsi';
    protected static ?string $modelLabel = 'Provinsi';
    protected static ?string $pluralModelLabel = 'Daftar Provinsi';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode Provinsi')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Provinsi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Provinsi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->fontFamily('mono'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Provinsi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('regencies_count')
                    ->counts('regencies')
                    ->label('Total Kab/Kota')
                    ->suffix(' wilayah')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProvinces::route('/'),
            'create' => Pages\CreateProvince::route('/create'),
            'edit' => Pages\EditProvince::route('/{record}/edit'),
        ];
    }
}
