<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Regency;
use App\Models\Shipment;
use App\Models\ShippingService;
use App\Models\Tariff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicPortalController extends Controller
{
    public function index(): View
    {
        $services = ShippingService::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        $popularOrigins = Regency::whereIn('code', ['7371', '3171', '3578', '3273', '7171'])->get(); // Makassar, Jakarta, Surabaya, Bandung, Manado

        return view('portal.index', compact('services', 'branches', 'popularOrigins'));
    }

    public function track(Request $request): View
    {
        $trackingNumber = trim($request->query('resi') ?: $request->input('resi', ''));
        $shipment = null;
        $progressPercent = 0;

        if ($trackingNumber) {
            $shipment = Shipment::with(['originBranch', 'destinationBranch', 'service', 'trackingActivities'])
                ->where('tracking_number', $trackingNumber)
                ->first();

            if ($shipment) {
                $progressPercent = match ($shipment->status) {
                    'CREATED' => 15,
                    'PICKED_UP' => 30,
                    'ORIGIN_HUB' => 45,
                    'MANIFESTED', 'IN_TRANSIT' => 65,
                    'DESTINATION_HUB' => 80,
                    'OUT_FOR_DELIVERY' => 90,
                    'DELIVERED' => 100,
                    default => 50,
                };
            }
        }

        return view('portal.track', compact('trackingNumber', 'shipment', 'progressPercent'));
    }

    public function searchCities(Request $request): JsonResponse
    {
        $query = trim($request->query('q', ''));
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $regencies = Regency::where('name', 'LIKE', "%{$query}%")
            ->limit(15)
            ->get(['code', 'name']);

        return response()->json($regencies);
    }

    public function calculateTariff(Request $request): JsonResponse
    {
        $fromCode = $request->input('from');
        $toCode = $request->input('to');
        $weight = max(1, (float)$request->input('weight', 1));

        $tariffs = Tariff::with('service')
            ->where('from_regency', $fromCode)
            ->where('to_regency', $toCode)
            ->where('is_active', true)
            ->get();

        if ($tariffs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tarif untuk rute ini belum tersedia secara otomatis. Silakan hubungi Customer Service kami untuk penawaran khusus.'
            ]);
        }

        $results = $tariffs->map(function ($t) use ($weight) {
            $chargeableWeight = max($weight, (float)$t->min_weight);
            $calculatedTotal = $chargeableWeight * (float)$t->price_per_kg;
            $finalTotal = max($calculatedTotal, (float)$t->min_price);

            return [
                'service_name' => $t->service->name ?? 'Kargo Reguler',
                'service_type' => $t->service->transport_type ?? 'DARAT',
                'price_per_kg' => (float)$t->price_per_kg,
                'price_per_kg_formatted' => 'Rp ' . number_format($t->price_per_kg, 0, ',', '.'),
                'min_weight' => (float)$t->min_weight,
                'estimated_time' => $t->estimated_time ?: '2-4 Hari',
                'chargeable_weight' => $chargeableWeight,
                'total_cost' => $finalTotal,
                'total_cost_formatted' => 'Rp ' . number_format($finalTotal, 0, ',', '.'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $results,
        ]);
    }

    public function branches(): View
    {
        $branches = Branch::where('is_active', true)->get();
        return view('portal.branches', compact('branches'));
    }
}
