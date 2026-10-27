<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ShipmentStatusDonutChart extends ApexChartWidget
{
    protected static ?string $chartId = "shipmentStatusDonutChart";
    protected static ?string $heading = "Status Distribusi Kargo";
    protected static ?string $subheading = "Proporsi real-time status pengiriman";
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = [
        "default" => 12,
        "lg" => 4,
    ];

    protected function getOptions(): array
    {
        $statusLabels = [
            "DELIVERED" => "Terkirim",
            "DESTINATION_HUB" => "Tiba di Hub Tujuan",
            "IN_TRANSIT" => "Dalam Perjalanan",
            "MANIFESTED" => "Dimanifestasikan",
            "ORIGIN_HUB" => "Di Hub Asal",
            "CREATED" => "Draft / Baru",
        ];

        $counts = Shipment::selectRaw("status, count(*) as count")
            ->groupBy("status")
            ->pluck("count", "status")
            ->toArray();

        $labels = [];
        $series = [];

        foreach ($statusLabels as $statusKey => $label) {
            $val = $counts[$statusKey] ?? 0;
            if ($val > 0) {
                $labels[] = $label;
                $series[] = (int) $val;
            }
        }

        return [
            "chart" => [
                "type" => "donut",
                "height" => 330,
                "fontFamily" => "Outfit, sans-serif",
            ],
            "series" => $series,
            "labels" => $labels,
            "colors" => ["#10b981", "#0ea5e9", "#3b82f6", "#f59e0b", "#8b5cf6", "#94a3b8"],
            "plotOptions" => [
                "pie" => [
                    "donut" => [
                        "size" => "70%",
                        "labels" => [
                            "show" => true,
                            "total" => [
                                "show" => true,
                                "label" => "Total Kargo",
                                "color" => "#475569",
                                "fontWeight" => 700,
                            ],
                        ],
                    ],
                ],
            ],
            "legend" => [
                "position" => "bottom",
                "labels" => [
                    "colors" => "#475569",
                    "fontWeight" => 500,
                ],
            ],
            "dataLabels" => [
                "enabled" => false,
            ],
        ];
    }
}
