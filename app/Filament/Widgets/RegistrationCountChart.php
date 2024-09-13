<?php

namespace App\Filament\Widgets;

use App\Models\AffiliateCommission;
use App\Models\Affiliate;
use App\Models\Profile;
use App\Models\Manager;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class RegistrationCountChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected static ?string $heading = 'Total de registros';
    protected static ?int $sort = 5;
    protected array $colorMap = [];

    // Função para gerar cores aleatórias
    protected function getFixedColor(int $id): string
    {
        if (!isset($this->colorMap[$id])) {
            $this->colorMap[$id] = '#' . substr(md5($id), 0, 6); // Gera cor baseada no ID
        }
        return $this->colorMap[$id];
    }

    protected function getData(): array
    {
        $datasets = [];

        // Verifica se há filtros e aplica, senão mostra todos os dados
        if ($this->filters['affiliate_id']) {
            foreach ($this->filters['affiliate_id'] as $affiliate_id) {
                $affiliate = Affiliate::find($affiliate_id);
                $datasets[] = [
                    'label' => 'Affiliate: ' . ($affiliate ? $affiliate->name : 'Unknown'),
                    'data' => $this->getValues('affiliate_id', $affiliate_id),
                    'borderColor' => $this->getFixedColor($affiliate_id),
                    'tension' => 0.2,
                ];
            }
        } elseif ($this->filters['profile_id']) {
            foreach ($this->filters['profile_id'] as $profile_id) {
                $profile = Profile::find($profile_id);
                $datasets[] = [
                    'label' => 'Perfil: ' . ($profile ? $profile->name : 'Unknown'),
                    'data' => $this->getValues('profile_id', $profile_id),
                    'borderColor' => $this->getFixedColor($profile_id),
                    'tension' => 0.2,
                ];
            }
        } elseif ($this->filters['manager_id']) {
            foreach ($this->filters['manager_id'] as $manager_id) {
                $manager = Manager::find($manager_id);
                $datasets[] = [
                    'label' => 'Gerente: ' . ($manager ? $manager->name : 'Unknown'),
                    'data' => $this->getValues('manager_id', $manager_id),
                    'borderColor' => $this->getFixedColor($manager_id),
                    'tension' => 0.2,
                ];
            }
        } else {
            // Nenhum filtro foi aplicado: mostrar dados globais
            $datasets[] = [
                'label' => 'Total',
                'data' => $this->getValues(),
                'borderColor' => $this->getFixedColor(rand(1, 500)),
                'tension' => 0.2,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $this->getLabels(),
        ];
    }

    // Labels das datas
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

        return array_reverse($dates);
    }

    // Obtenção dos valores
    // O parâmetro $type permite filtrar por 'affiliate_id', 'profile_id' ou 'manager_id', ou não passar nada para todos os dados
    protected function getValues(string $type = null, int $id = null): array
    {
        $values = AffiliateCommission::selectRaw('DATE(dt) as date, SUM(registration_count) as total')
            ->join('affiliates', 'affiliate_commissions.affiliate_id', '=', 'affiliates.id')
            ->groupBy('date')
            ->orderByRaw('DATE(dt) desc')
            ->when($this->filters['startDate'], function ($query) {
                return $query->where('dt', '>=', $this->filters['startDate'])
                    ->where('dt', '<=', $this->filters['endDate']);
            })
            ->when($type === 'affiliate_id', function ($query) use ($id) {
                return $query->where('affiliate_id', $id);
            })
            ->when($type === 'profile_id', function ($query) use ($id) {
                return $query->where('affiliates.profile_id', $id);
            })
            ->when($type === 'manager_id', function ($query) use ($id) {
                return $query->where('affiliates.manager_id', $id);
            })
            ->pluck('total')
            ->toArray();

        return array_reverse($values);
    }

    // Tipo de gráfico
    protected function getType(): string
    {
        return 'line';
    }
}
