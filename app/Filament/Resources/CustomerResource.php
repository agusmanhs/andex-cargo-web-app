<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Operasional Kargo';
    protected static ?string $navigationLabel = 'Data Pelanggan (Customer)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode Customer')
                    ->maxLength(30),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Customer / Perusahaan')
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('pic_name')
                    ->label('Nama PIC / Kontak')
                    ->maxLength(100),
                Forms\Components\TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('whatsapp')
                    ->label('Nomor WhatsApp')
                    ->maxLength(30),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->maxLength(100),
                Forms\Components\Select::make('customer_type')
                    ->label('Jenis Pelanggan')
                    ->options([
                        'REGULAR' => 'Regular / Perorangan',
                        'CORPORATE' => 'Corporate / Perusahaan',
                    ])
                    ->default('REGULAR')
                    ->required(),
                Forms\Components\Select::make('branch_id')
                    ->label('Cabang Terdaftar')
                    ->relationship('branch', 'name')
                    ->default(2),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat Lengkap')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->weight('bold')
                    ->color('primary')
                    ->copyable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pelanggan / Perusahaan')
                    ->searchable()
                    ->weight('bold')
                    ->wrap(),
                Tables\Columns\TextColumn::make('pic_name')
                    ->label('PIC')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No. Telepon / WA')
                    ->description(fn (Customer $record): ?string => $record->whatsapp && $record->whatsapp !== $record->phone ? 'WA: ' . $record->whatsapp : null)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('regency')
                    ->label('Kota/Kabupaten')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        if (is_numeric($state)) {
                            $kab = Kabupaten::where('kode_kabupaten', $state)->first();
                            return $kab ? $kab->nama_kabupaten : $state;
                        }
                        return $state;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CORPORATE' => 'info',
                        'REGULAR' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('customer_type')
                    ->label('Tipe Pelanggan')
                    ->options([
                        'CORPORATE' => 'Corporate (B2B)',
                        'REGULAR' => 'Regular',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
