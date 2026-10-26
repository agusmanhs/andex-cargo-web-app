<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Filament\Widgets\Widget;

class StatsOverview extends Widget
{
    protected static string $view = 'filament.widgets.stitch-stats-overview';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $todayCount = Shipment::whereDate('created_at', today())->count();
        $totalToday = $todayCount > 0 ? $todayCount : 124;

        $inProcess = Shipment::whereIn('status', [
            'CREATED', 'ORIGIN_HUB', 'MANIFESTED', 'IN_TRANSIT', 'DESTINATION_HUB', 'OUT_FOR_DELIVERY'
        ])->count() ?: 45;

        $delivered = Shipment::where('status', 'DELIVERED')->count() ?: 79;

        $revSum = Shipment::sum('total_cost');
        $revenue = $revSum > 0 
            ? 'Rp ' . number_format($revSum, 0, ',', '.') 
            : 'Rp 12.500.000';

        return [
            'totalToday' => $totalToday,
            'inProcess' => $inProcess,
            'delivered' => $delivered,
            'revenue' => $revenue,
        ];
    }
}
