<?php

namespace App\Filament\Widgets;

use App\Models\AffiliateCommission;
use Filament\Widgets\ChartWidget;

class RegistrationCountChart extends ChartWidget
{
    protected static ?string $heading = 'Total de registros';

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
        $dates = AffiliateCommission::selectRaw('DATE(dt) as date')
        ->groupBy('date')
        ->orderByRaw('DATE(dt) desc')
        ->limit(30)
        ->pluck('date')
        ->toArray();

        return  array_reverse($dates);
    }

    //pega a quantidade de registros por dia agrupado
    protected function getValues(): array
    {
        $values = AffiliateCommission::selectRaw('DATE(dt) as date, SUM(registration_count) as total')
        ->groupBy('date')
        ->orderByRaw('DATE(dt) desc')
        ->limit(30)
        ->pluck('total')
        ->toArray();

        return array_reverse($values);
    }

    protected function getType(): string
    {
        return 'line';
    }
}
