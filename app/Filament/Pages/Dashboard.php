<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Kantor Cabang Dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public function getSubheading(): ?string
    {
        return "Overview of today's branch operations and metrics.";
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_shipment')
                ->label('Input Resi Baru')
                ->icon('heroicon-m-plus')
                ->url(url('/admin/shipments/create'))
                ->color('danger')
                ->extraAttributes([
                    'class' => 'stitch-input-resi-btn bg-[#c5161d] hover:bg-[#a81318] text-white font-bold rounded-xl px-5 py-2.5 shadow-md hover:shadow-lg transition-all',
                ]),
        ];
    }

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 1;
    }
}
