<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Shipment;
use App\Models\ShippingService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Operasional Kargo';
    protected static ?string $navigationLabel = 'Data Resi (AWB)';
    protected static ?string $modelLabel = 'Resi Pengiriman';
    protected static ?string $pluralModelLabel = 'Daftar Resi Pengiriman';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Resi & Layanan')
                            ->schema([
                                Forms\Components\TextInput::make('tracking_number')
                                    ->label('Nomor Resi / AWB')
                                    ->default(fn () => 'ANDX' . date('ymd') . rand(100, 999))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),
                                Forms\Components\Select::make('origin_branch_id')
                                    ->label('Cabang Asal')
                                    ->relationship('originBranch', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Select::make('destination_branch_id')
                                    ->label('Cabang Transit / Tujuan')
                                    ->relationship('destinationBranch', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('service_id')
                                    ->label('Layanan Pengiriman')
                                    ->relationship('service', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Section::make('Data Pengirim & Penerima')
                            ->schema([
                                Forms\Components\Fieldset::make('PENGIRIM')
                                    ->schema([
                                        Forms\Components\TextInput::make('sender_name')->label('Nama Pengirim')->required(),
                                        Forms\Components\TextInput::make('sender_phone')->label('No. Telepon / WA')->tel()->required(),
                                        Forms\Components\TextInput::make('origin_city')->label('Kota Asal')->default('MAKASSAR')->required(),
                                        Forms\Components\Textarea::make('sender_address')->label('Alamat Lengkap')->columnSpanFull(),
                                    ])->columns(3),

                                Forms\Components\Fieldset::make('PENERIMA')
                                    ->schema([
                                        Forms\Components\TextInput::make('receiver_name')->label('Nama Penerima')->required(),
                                        Forms\Components\TextInput::make('receiver_phone')->label('No. Telepon / WA')->tel()->required(),
                                        Forms\Components\TextInput::make('destination_city')->label('Kota Tujuan')->required(),
                                        Forms\Components\Textarea::make('receiver_address')->label('Alamat Lengkap')->columnSpanFull(),
                                    ])->columns(3),
                            ]),

                        Forms\Components\Section::make('Detail Koli & Timbangan')
                            ->schema([
                                Forms\Components\TextInput::make('total_colly')
                                    ->label('Jumlah Koli')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                Forms\Components\TextInput::make('actual_weight')
                                    ->label('Berat Aktual (Kg)')
                                    ->numeric()
                                    ->default(1.00)
                                    ->required(),
                                Forms\Components\TextInput::make('chargeable_weight')
                                    ->label('Berat Charge (Kg)')
                                    ->numeric()
                                    ->default(1.00)
                                    ->required(),
                                Forms\Components\Textarea::make('notes')
                                    ->label('Keterangan / Isi Paket')
                                    ->columnSpanFull(),
                            ])->columns(3),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Tarif & Pembayaran')
                            ->schema([
                                Forms\Components\TextInput::make('tariff_per_kg')
                                    ->label('Tarif / Kg')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('shipping_cost')
                                    ->label('Ongkos Kirim')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('packing_cost')
                                    ->label('Biaya Packing')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('other_cost')
                                    ->label('Biaya Lain')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('total_cost')
                                    ->label('Total Biaya')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\Select::make('payment_type')
                                    ->label('Metode Pembayaran')
                                    ->options([
                                        'CASH' => 'CASH (Tunai)',
                                        'COD' => 'COD (Bayar Tujuan)',
                                        'INVOICE' => 'INVOICE (Tagihan/Tempo)',
                                    ])
                                    ->default('CASH')
                                    ->required(),
                                Forms\Components\Select::make('payment_status')
                                    ->label('Status Bayar')
                                    ->options([
                                        'UNPAID' => 'Belum Lunas',
                                        'PAID' => 'Lunas',
                                    ])
                                    ->default('UNPAID')
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Status Operasional')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status Kiriman')
                                    ->options([
                                        'CREATED' => 'Order Dibuat',
                                        'PICKED_UP' => 'Barang Di-Pickup',
                                        'ORIGIN_HUB' => 'Gudang Asal',
                                        'MANIFESTED' => 'Sudah Masuk Manifest',
                                        'IN_TRANSIT' => 'Dalam Perjalanan (Transit)',
                                        'DESTINATION_HUB' => 'Tiba di Gudang Tujuan',
                                        'OUT_FOR_DELIVERY' => 'Sedang Diantar Kurir',
                                        'DELIVERED' => 'Terkirim / Selesai',
                                        'RETURNED' => 'Retur / Kembali',
                                    ])
                                    ->default('ORIGIN_HUB')
                                    ->required(),
                                Forms\Components\TextInput::make('current_location')
                                    ->label('Posisi Terakhir')
                                    ->placeholder('Misal: Gudang Makassar'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tracking_number')
                    ->label('No. Resi')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('originBranch.name')
                    ->label('Asal')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('destination_city')
                    ->label('Tujuan')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sender_name')
                    ->label('Pengirim')
                    ->description(fn (Shipment $record): string => $record->receiver_name ? 'Penerima: ' . $record->receiver_name : '')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_colly')
                    ->label('Koli')
                    ->suffix(' koli')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('chargeable_weight')
                    ->label('Berat')
                    ->suffix(' Kg')
                    ->alignRight(),
                Tables\Columns\TextColumn::make('total_cost')
                    ->label('Total Biaya')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->alignRight(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CASH' => 'success',
                        'COD' => 'warning',
                        'INVOICE' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'DELIVERED' => 'success',
                        'IN_TRANSIT', 'OUT_FOR_DELIVERY' => 'primary',
                        'MANIFESTED' => 'warning',
                        'ORIGIN_HUB', 'CREATED', 'PICKED_UP' => 'info',
                        'RETURNED', 'CANCELLED' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ORIGIN_HUB' => 'Gudang Asal',
                        'MANIFESTED' => 'Manifest',
                        'IN_TRANSIT' => 'Transit',
                        'DESTINATION_HUB' => 'Hub Tujuan',
                        'OUT_FOR_DELIVERY' => 'Kurir Antar',
                        'DELIVERED' => 'Terkirim',
                        'RETURNED' => 'Retur',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('origin_branch_id')
                    ->label('Cabang Asal')
                    ->relationship('originBranch', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'ORIGIN_HUB' => 'Gudang Asal',
                        'MANIFESTED' => 'Manifest',
                        'IN_TRANSIT' => 'Dalam Perjalanan',
                        'DELIVERED' => 'Terkirim',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('print_thermal')
                    ->label('Cetak Resi')
                    ->icon('heroicon-o-printer')
                    ->color('danger')
                    ->url(fn (Shipment $record): string => route('print.resi', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('print_nota')
                    ->label('Nota')
                    ->icon('heroicon-o-receipt-percent')
                    ->color('primary')
                    ->url(fn (Shipment $record): string => route('print.nota', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->bulkActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()
                    ->label('Export Terpilih ke Excel'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
