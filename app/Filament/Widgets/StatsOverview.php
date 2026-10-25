<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalShipments = Shipment::count();
        $inProcess = Shipment::whereIn('status', ['CREATED', 'ORIGIN_HUB', 'MANIFESTED', 'IN_TRANSIT', 'DESTINATION_HUB', 'OUT_FOR_DELIVERY'])->count();
        $delivered = Shipment::where('status', 'DELIVERED')->count();
        $totalRevenue = Shipment::sum('total_cost');

        return [
            Stat::make('Total Kiriman', number_format($totalShipments, 0, ',', '.') . ' Resi')
                ->description('Total AWB terdaftar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 12, 18, 15, 24, 30, $totalShipments % 50 + 10])
                ->color('primary'),

            Stat::make('Dalam Proses', number_format($inProcess, 0, ',', '.') . ' Paket')
                ->description('Manifest & Transit aktif')
                ->descriptionIcon('heroicon-m-truck')
                ->chart([15, 18, 12, 22, 19, 25, 28])
                ->color('warning'),

            Stat::make('Terkirim (Delivered)', number_format($delivered, 0, ',', '.') . ' Paket')
                ->description('Selesai ke penerima')
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([10, 15, 20, 25, 30, 35, 40])
                ->color('success'),

            Stat::make('Omset Pengiriman', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total pendapatan cabang')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart([30, 45, 60, 50, 75, 90, 110])
                ->color('info'),
        ];
    }
}
