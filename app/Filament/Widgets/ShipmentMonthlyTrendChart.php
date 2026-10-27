<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Carbon\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ShipmentMonthlyTrendChart extends ApexChartWidget
{
    protected static ?string $chartId = "shipmentMonthlyTrendChart";
    protected static ?string $heading = "Trend Volume Pengiriman (12 Bulan Terakhir)";
    protected static ?string $subheading = "Statistik jumlah resi pengiriman kargo per bulan";
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 1;

    protected function getOptions(): array
    {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth();
        
        $records = Shipment::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, count(*) as count")
            ->where("created_at", ">=", $startDate)
            ->groupBy("ym")
            ->orderBy("ym", "asc")
            ->pluck("count", "ym")
            ->toArray();

        $categories = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $key = $month->format("Y-m");
            $label = $month->translatedFormat("M Y");
            $categories[] = $label;
            $data[] = $records[$key] ?? 0;
        }

        return [
            "chart" => [
                "type" => "area",
                "height" => 330,
                "toolbar" => [
                    "show" => false,
                ],
                "fontFamily" => "Outfit, sans-serif",
                "dropShadow" => [
                    "enabled" => true,
                    "top" => 4,
                    "left" => 0,
                    "blur" => 6,
                    "opacity" => 0.12,
                    "color" => "#1d58cd",
                ],
            ],
            "series" => [
                [
                    "name" => "Total Resi Kargo",
                    "data" => $data,
                ],
            ],
            "xaxis" => [
                "categories" => $categories,
                "labels" => [
                    "style" => [
                        "colors" => "#64748b",
                        "fontWeight" => 600,
                        "fontSize" => "11px",
                    ],
                ],
                "axisBorder" => [
                    "show" => false,
                ],
                "axisTicks" => [
                    "show" => false,
                ],
            ],
            "yaxis" => [
                "labels" => [
                    "style" => [
                        "colors" => "#64748b",
                        "fontWeight" => 600,
                        "fontSize" => "11px",
                    ],
                ],
            ],
            "colors" => ["#1d58cd"],
            "fill" => [
                "type" => "gradient",
                "gradient" => [
                    "shadeIntensity" => 1,
                    "opacityFrom" => 0.45,
                    "opacityTo" => 0.05,
                    "stops" => [0, 95, 100],
                ],
            ],
            "stroke" => [
                "curve" => "smooth",
                "width" => 3,
            ],
            "dataLabels" => [
                "enabled" => false,
            ],
            "tooltip" => [
                "y" => [
                    
                ],
            ],
            "grid" => [
                "borderColor" => "#f1f5f9",
                "strokeDashArray" => 4,
            ],
        ];
    }
}
