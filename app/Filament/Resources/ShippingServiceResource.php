<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingServiceResource\Pages;
use App\Filament\Resources\ShippingServiceResource\RelationManagers;
use App\Models\ShippingService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShippingServiceResource extends Resource
{
    protected static ?string $model = ShippingService::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Master Wilayah & Tarif';
    protected static ?string $navigationLabel = 'Layanan Ekspedisi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('transport_type')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('min_weight')
                    ->required()
                    ->numeric()
                    ->default(1.00),
                Forms\Components\TextInput::make('estimated_time')
                    ->maxLength(50),
                Forms\Components\TextInput::make('icon')
                    ->maxLength(50),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transport_type'),
                Tables\Columns\TextColumn::make('min_weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('icon')
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
            'index' => Pages\ListShippingServices::route('/'),
            'create' => Pages\CreateShippingService::route('/create'),
            'edit' => Pages\EditShippingService::route('/{record}/edit'),
        ];
    }
}
