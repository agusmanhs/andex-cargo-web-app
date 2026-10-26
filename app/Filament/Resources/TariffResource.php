<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TariffResource\Pages;
use App\Filament\Resources\TariffResource\RelationManagers;
use App\Models\Tariff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TariffResource extends Resource
{
    protected static ?string $model = Tariff::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = 'Master Wilayah & Tarif';
    protected static ?string $navigationLabel = 'Master Tarif Ekspedisi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name'),
                Forms\Components\TextInput::make('from_regency')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('to_regency')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('price_per_kg')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('min_weight')
                    ->numeric()
                    ->default(10.00),
                Forms\Components\TextInput::make('min_price')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('estimated_time')
                    ->maxLength(50),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('from_regency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('to_regency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price_per_kg')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_time')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            'index' => Pages\ListTariffs::route('/'),
            'create' => Pages\CreateTariff::route('/create'),
            'edit' => Pages\EditTariff::route('/{record}/edit'),
        ];
    }
}
