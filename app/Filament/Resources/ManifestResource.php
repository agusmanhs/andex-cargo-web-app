<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManifestResource\Pages;
use App\Models\Branch;
use App\Models\Manifest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ManifestResource extends Resource
{
    protected static ?string $model = Manifest::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Operasional Kargo';
    protected static ?string $navigationLabel = 'Manifest Dispatch';
    protected static ?string $modelLabel = 'Manifest';
    protected static ?string $pluralModelLabel = 'Daftar Manifest Dispatch';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Manifest & Rute')
                    ->schema([
                        Forms\Components\TextInput::make('manifest_number')
                            ->label('Nomor Manifest')
                            ->default(fn () => 'MAN-' . date('ymd') . '-' . rand(10, 99))
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('origin_branch_id')
                            ->label('Cabang Asal (Gudang Dispatch)')
                            ->relationship('originBranch', 'name')
                            ->required(),
                        Forms\Components\Select::make('destination_branch_id')
                            ->label('Cabang Tujuan')
                            ->relationship('destinationBranch', 'name')
                            ->required(),
                        Forms\Components\Select::make('transport_type')
                            ->label('Moda Transportasi')
                            ->options([
                                'TRUCK' => 'Truk Darat (CDD/Fuso/Tronton)',
                                'KAPAL' => 'Kapal Laut (Pelni/Cargo)',
                                'PESAWAT' => 'Pesawat Udara',
                                'VAN' => 'Van / Blindvan Antar Kota',
                            ])
                            ->default('TRUCK')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Armada & Driver / Vendor')
                    ->schema([
                        Forms\Components\TextInput::make('vehicle_plate_number')->label('No. Plat Kendaraan / No. Voyage'),
                        Forms\Components\TextInput::make('driver_name')->label('Nama Driver / PIC Vendor'),
                        Forms\Components\TextInput::make('driver_phone')->label('No. Telp Driver')->tel(),
                        Forms\Components\TextInput::make('vendor_name')->label('Nama Vendor / Ekspedisi Rekanan'),
                    ])->columns(2),

                Forms\Components\Section::make('Waktu & Status Perjalanan')
                    ->schema([
                        Forms\Components\DateTimePicker::make('departure_time')->label('Waktu Berangkat'),
                        Forms\Components\DateTimePicker::make('estimated_arrival')->label('Estimasi Tiba (ETA)'),
                        Forms\Components\DateTimePicker::make('arrived_at')->label('Waktu Tiba Aktual'),
                        Forms\Components\Select::make('status')
                            ->label('Status Manifest')
                            ->options([
                                'DRAFT' => 'Draft (Muat Barang)',
                                'LOADING' => 'Proses Loading',
                                'DEPARTED' => 'Sudah Berangkat',
                                'IN_TRANSIT' => 'Dalam Perjalanan (Transit)',
                                'ARRIVED' => 'Tiba di Gudang Tujuan',
                                'CLOSED' => 'Selesai / Closed',
                            ])
                            ->default('DRAFT')
                            ->required(),
                        Forms\Components\Textarea::make('notes')->label('Catatan Operasional')->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('manifest_number')
                    ->label('No. Manifest')
                    ->searchable()
                    ->weight('bold')
                    ->copyable()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('originBranch.name')
                    ->label('Asal')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('destinationBranch.name')
                    ->label('Tujuan')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('transport_type')
                    ->label('Transport')
                    ->badge(),
                Tables\Columns\TextColumn::make('vehicle_plate_number')
                    ->label('Plat / Armada')
                    ->description(fn (Manifest $record): string => $record->driver_name ? 'Driver: ' . $record->driver_name : ''),
                Tables\Columns\TextColumn::make('total_shipments')
                    ->label('Total Resi')
                    ->suffix(' resi')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('total_weight')
                    ->label('Total Berat')
                    ->suffix(' Kg')
                    ->alignRight(),
                Tables\Columns\TextColumn::make('departure_time')
                    ->label('Berangkat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CLOSED', 'ARRIVED' => 'success',
                        'DEPARTED', 'IN_TRANSIT' => 'primary',
                        'LOADING' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('print_manifest')
                    ->label('Cetak Surat Jalan')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->url(fn (Manifest $record): string => route('print.manifest', $record))
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
            'index' => Pages\ListManifests::route('/'),
            'create' => Pages\CreateManifest::route('/create'),
            'edit' => Pages\EditManifest::route('/{record}/edit'),
        ];
    }
}
