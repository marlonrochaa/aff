<?php

namespace App\Filament\Widgets;

use App\Models\AffiliateCommission;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class DepositTotalChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Total de depósitos';
    protected static ?int $sort = 2;

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
        ->when($this->filters['startDate'], function ($query) {
            return $query->where('dt', '>=', $this->filters['startDate'])
            ->where('dt', '<=', $this->filters['endDate']);
        })
        ->pluck('date')
        ->toArray();

        return  array_reverse($dates);
    }

    protected function getValues(): array
    {
        $values = AffiliateCommission::selectRaw('DATE(dt) as date, SUM(deposit_total) as total')
        ->join('affiliates', 'affiliate_commissions.affiliate_id', '=', 'affiliates.id')
        ->groupBy('date')
        ->orderByRaw('DATE(dt) desc')
        ->when($this->filters['startDate'], function ($query) {
            return $query->where('dt', '>=', $this->filters['startDate'])
            ->where('dt', '<=', $this->filters['endDate']);
        })
        ->when($this->filters['affiliate_id'], function ($query) {
            return $query->whereIn('affiliate_id', $this->filters['affiliate_id']);
        })
        ->when($this->filters['profile_id'], function ($query) {
            return $query->whereIn('affiliates.profile_id', $this->filters['profile_id']);
        })
        ->when($this->filters['manager_id'], function ($query) {
            return $query->whereIn('affiliates.manager_id', $this->filters['manager_id']);
        })
        ->pluck('total')
        ->toArray();

        return array_reverse($values);
    }

    protected function getType(): string
    {
        return 'line';
    }
}
