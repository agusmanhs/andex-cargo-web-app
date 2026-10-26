<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CorporateTariffResource\Pages;
use App\Models\CorporateTariff;
use App\Models\Customer;
use App\Models\Regency;
use App\Models\ShippingService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CorporateTariffResource extends Resource
{
    protected static ?string $model = CorporateTariff::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Master Wilayah & Tarif';
    protected static ?string $navigationLabel = 'Tarif Kontrak Corporate';
    protected static ?string $modelLabel = 'Tarif Kontrak Corporate';
    protected static ?string $pluralModelLabel = 'Daftar Tarif Kontrak Corporate';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Klien & Kontrak')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Klien / Perusahaan Corporate')
                            ->options(fn () => Customer::where('customer_type', 'CORPORATE')->orWhere('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('service_id')
                            ->label('Layanan Kargo')
                            ->options(fn () => ShippingService::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('contract_number')
                            ->label('No. Kontrak / SPK / P.O')
                            ->placeholder('Contoh: SPK/ANDX/2026/001'),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Masa Berlaku Kontrak'),
                    ])->columns(2),

                Forms\Components\Section::make('Rute & Penentuan Harga Khusus')
                    ->schema([
                        Forms\Components\Select::make('from_kabupaten')
                            ->label('Kota Asal')
                            ->options(fn () => Regency::pluck('name', 'code'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('to_kabupaten')
                            ->label('Kota Tujuan')
                            ->options(fn () => Regency::pluck('name', 'code'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('price_per_kg')
                            ->label('Tarif Kontrak (Rp / Kg)')
                            ->prefix('Rp')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('min_weight')
                            ->label('Minimal Berat (Kg)')
                            ->numeric()
                            ->default(10.00),
                        Forms\Components\TextInput::make('min_price')
                            ->label('Minimal Biaya (Rp)')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('estimated_time')
                            ->label('Estimasi Tiba (Hari)')
                            ->default('2-3 Hari'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Kesepakatan Kontrak')
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Tarif Kontrak Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Perusahaan Corporate')
                    ->searchable()
                    ->weight('bold')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Layanan')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('originRegency.name')
                    ->label('Asal')
                    ->default(fn (CorporateTariff $record) => $record->from_kabupaten),
                Tables\Columns\TextColumn::make('destinationRegency.name')
                    ->label('Tujuan')
                    ->default(fn (CorporateTariff $record) => $record->to_kabupaten)
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('price_per_kg')
                    ->label('Harga / Kg')
                    ->money('IDR')
                    ->weight('bold')
                    ->color('success')
                    ->alignRight(),
                Tables\Columns\TextColumn::make('min_weight')
                    ->label('Min Berat')
                    ->suffix(' Kg')
                    ->alignRight(),
                Tables\Columns\TextColumn::make('contract_number')
                    ->label('No. Kontrak')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('customer_id')
                    ->label('Filter Perusahaan')
                    ->relationship('customer', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCorporateTariffs::route('/'),
            'create' => Pages\CreateCorporateTariff::route('/create'),
            'edit' => Pages\EditCorporateTariff::route('/{record}/edit'),
        ];
    }
}
