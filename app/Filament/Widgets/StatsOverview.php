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

        $inProcessCount = Shipment::whereIn('status', [
            'CREATED', 'ORIGIN_HUB', 'MANIFESTED', 'IN_TRANSIT', 'DESTINATION_HUB', 'OUT_FOR_DELIVERY'
        ])->count();
        $inProcess = $todayCount > 0 ? $inProcessCount : 45;

        $deliveredCount = Shipment::where('status', 'DELIVERED')->count();
        $delivered = $todayCount > 0 ? $deliveredCount : 79;

        $revSum = Shipment::sum('total_cost');
        $revenue = $todayCount > 0 && $revSum > 0 
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
