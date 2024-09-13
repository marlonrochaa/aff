<?php

namespace App\Filament\Widgets\Sheet;

use App\Models\FinancialReport;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class RegistrationSheet extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Registros';
    protected static ?int $sort = 2;

    public $startDate;
    public $endDate;

    protected $listeners = ["filtersUpdated" => "updateFilters"];

    public function __construct()
    {
        $this->startDate = Carbon::now()->subDays(7)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function updateFilters($filters)
    {
        $this->startDate = $filters['startDate'] ?? Carbon::now()->subDays(7)->format('Y-m-d');
        $this->endDate = $filters['endDate'] ?? Carbon::now()->format('Y-m-d');
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => $this->getValues(),
                ],
            ],
            'labels' => $this->getLabels(),
        ];
    }

    protected function getLabels(): array
    {
        // Coletar as datas
        return FinancialReport::selectRaw('date')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->where('date', '>=', $this->startDate)
            ->where('date', '<=', $this->endDate)
            ->pluck('date')
            ->toArray();
    }

    protected function getValues(): array
    {
        return FinancialReport::selectRaw('date, SUM(registration) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->where('date', '>=', $this->startDate)
            ->where('date', '<=', $this->endDate)
            ->pluck('total')
            ->toArray();
    }

    protected function getType(): string
    {
        return 'line';
    }
}
