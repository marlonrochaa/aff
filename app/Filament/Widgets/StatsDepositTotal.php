<?php

namespace App\Filament\Widgets;

use App\Models\AffiliateCommission;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsDepositTotal extends BaseWidget
{
    protected static ?int $sort = 1;
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        return [
            Stat::make('Total de dépositos', $this->formatValue($this->getCard('deposit_total'))),
            Stat::make('FTDs Total', $this->formatValue($this->getCard('ftd_total'))),
            Stat::make('FTDs Count', $this->getCard('ftd_count')),
            Stat::make('Total de registros', $this->getCard('registration_count')), 
        ];
    }

    protected function getCard($column)
    {
        $affiliate_id = $this->filters['affiliate_id'] ?? null;
        $profile_id = $this->filters['profile_id'] ?? null;
        $manager_id = $this->filters['manager_id'] ?? null;
        
        $data = AffiliateCommission::selectRaw('SUM('.$column.') as total')
        ->join('affiliates', 'affiliate_commissions.affiliate_id', '=', 'affiliates.id')
        ->when($this->filters['startDate'], function ($query) {
            return $query->where('dt', '>=', $this->filters['startDate'])
            ->where('dt', '<=', $this->filters['endDate']);
        })
        ->when($affiliate_id, function ($query) use ($affiliate_id) {
            return $query->whereIn('affiliate_id', $affiliate_id);
        })
        ->when($profile_id, function ($query) use ($profile_id) {
            return $query->whereIn('affiliates.profile_id', $profile_id);
        })
        ->when($manager_id, function ($query) use ($manager_id) {
            return $query->whereIn('affiliates.manager_id', $manager_id);
        })
        ->get();

        return $data->first()->total ?? 0;
    }

    //formata o valor para exibição em real
    protected function formatValue($value)
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}
