<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TopDestinationsChart extends ApexChartWidget
{
    protected static ?string $chartId = "topDestinationsChart";
    protected static ?string $heading = "Kota Destinasi Utama (Rute Terpadat)";
    protected static ?string $subheading = "7 kota dengan volume kargo tertinggi di Pulau Sulawesi";
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = "full";

    protected function getOptions(): array
    {
        $topCities = Shipment::selectRaw("destination_city, count(*) as count")
            ->whereNotNull("destination_city")
            ->where("destination_city", "!=", "")
            ->groupBy("destination_city")
            ->orderBy("count", "desc")
            ->take(7)
            ->get();

        $categories = [];
        $data = [];

        foreach ($topCities as $row) {
            $categories[] = ucwords(strtolower($row->destination_city));
            $data[] = (int) $row->count;
        }

        return [
            "chart" => [
                "type" => "bar",
                "height" => 280,
                "toolbar" => [
                    "show" => false,
                ],
                "fontFamily" => "Outfit, sans-serif",
            ],
            "plotOptions" => [
                "bar" => [
                    "horizontal" => true,
                    "borderRadius" => 6,
                    "distributed" => true,
                    "dataLabels" => [
                        "position" => "top",
                    ],
                ],
            ],
            "series" => [
                [
                    "name" => "Volume Resi",
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
            ],
            "yaxis" => [
                "labels" => [
                    "style" => [
                        "colors" => "#1e293b",
                        "fontWeight" => 600,
                        "fontSize" => "12px",
                    ],
                ],
            ],
            "colors" => ["#1d58cd", "#2563eb", "#3b82f6", "#0284c7", "#0ea5e9", "#06b6d4", "#14b8a6"],
            "dataLabels" => [
                "enabled" => true,
                "offsetX" => 25,
                "style" => [
                    "fontSize" => "11px",
                    "colors" => ["#0f172a"],
                    "fontWeight" => 700,
                ],
            ],
            "legend" => [
                "show" => false,
            ],
            "grid" => [
                "borderColor" => "#f1f5f9",
                "strokeDashArray" => 4,
            ],
        ];
    }
}
