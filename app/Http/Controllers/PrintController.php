<?php

namespace App\Http\Controllers;

use App\Models\Manifest;
use App\Models\Shipment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class PrintController extends Controller
{
    public function printThermalResi(Shipment $shipment, Request $request)
    {
        $shipment->load(["originBranch", "destinationBranch", "service", "items", "customer"]);

        $dns1d = new DNS1D();
        $dns2d = new DNS2D();

        $barcodePng = $dns1d->getBarcodePNG($shipment->tracking_number, "C128", 1.8, 48);
        $trackingUrl = url("/lacak-resi?tracking_number=" . urlencode($shipment->tracking_number));
        $qrCodePng = $dns2d->getBarcodePNG($trackingUrl, "QRCODE", 4, 4);

        if ($request->query("format") === "pdf") {
            // 100mm x 150mm paper in pt (1 mm = 2.83465 pt) => 283.46 x 425.20 pt
            $pdf = Pdf::loadView("print.thermal-resi", [
                "shipment" => $shipment,
                "barcodePng" => $barcodePng,
                "qrCodePng" => $qrCodePng,
                "isPdf" => true,
            ])->setPaper([0, 0, 283.46, 425.20], "portrait");

            return $pdf->stream("Resi-{$shipment->tracking_number}.pdf");
        }

        return view("print.thermal-resi", [
            "shipment" => $shipment,
            "barcodePng" => $barcodePng,
            "qrCodePng" => $qrCodePng,
            "isPdf" => false,
        ]);
    }

    public function printNota(Shipment $shipment, Request $request)
    {
        $shipment->load(["originBranch", "destinationBranch", "service", "items", "customer"]);

        $dns1d = new DNS1D();
        $barcodePng = $dns1d->getBarcodePNG($shipment->tracking_number, "C128", 1.5, 36);

        if ($request->query("format") === "pdf") {
            $pdf = Pdf::loadView("print.nota-tanda-terima", [
                "shipment" => $shipment,
                "barcodePng" => $barcodePng,
                "isPdf" => true,
            ])->setPaper("a5", "landscape");

            return $pdf->stream("Nota-{$shipment->tracking_number}.pdf");
        }

        return view("print.nota-tanda-terima", [
            "shipment" => $shipment,
            "barcodePng" => $barcodePng,
            "isPdf" => false,
        ]);
    }

    public function printManifest(Manifest $manifest, Request $request)
    {
        $manifest->load([
            "originBranch",
            "destinationBranch",
            "createdBy",
            "items.shipment.originBranch",
            "items.shipment.destinationBranch",
            "items.shipment.items",
        ]);

        $dns1d = new DNS1D();
        $dns2d = new DNS2D();

        $barcodePng = $dns1d->getBarcodePNG($manifest->manifest_number, "C128", 1.6, 40);
        $qrCodePng = $dns2d->getBarcodePNG(url("/admin/manifests/" . $manifest->id), "QRCODE", 4, 4);

        if ($request->query("format") === "pdf") {
            $pdf = Pdf::loadView("print.manifest-surat-jalan", [
                "manifest" => $manifest,
                "barcodePng" => $barcodePng,
                "qrCodePng" => $qrCodePng,
                "isPdf" => true,
            ])->setPaper("a4", "portrait");

            $safeNumber = str_replace(['/', '\\'], '-', $manifest->manifest_number);
            return $pdf->stream("Surat-Jalan-{$safeNumber}.pdf");
        }

        return view("print.manifest-surat-jalan", [
            "manifest" => $manifest,
            "barcodePng" => $barcodePng,
            "qrCodePng" => $qrCodePng,
            "isPdf" => false,
        ]);
    }
}
