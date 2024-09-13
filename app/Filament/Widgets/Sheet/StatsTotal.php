<?php

namespace App\Filament\Widgets\Sheet;

use App\Models\FinancialReport;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsTotal extends BaseWidget
{
    protected static ?int $sort = 1;
    use InteractsWithPageFilters;
    protected string $title = 'Estatísticas de Depósitos';

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

    protected function getStats(): array
    {
        return  [
            Stat::make('Total de dépositos', $this->formatValue($this->getCard('deposit_amount'))),
            Stat::make('FTDs Total', $this->formatValue($this->getCard('ftd_amount'))),
            Stat::make('FTDs Count', $this->formatValue($this->getCard('ftd_count'))),
            Stat::make('Total de registros', $this->getCard('registration')), 
        ];
    }

    // Ajusta o método para receber parâmetros opcionais
    protected function getCard($column)
    {
        $data = FinancialReport::selectRaw('SUM('.$column.') as total')
            ->when($this->startDate, function ($query) {
                return $query->where('date', '>=', $this->startDate)
                    ->where('date', '<=', $this->endDate);
            })
            ->get();

        return $data->first()->total ?? 0;
    }

    // Formatar o valor para exibição em real
    protected function formatValue($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
