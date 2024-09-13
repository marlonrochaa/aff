<?php

namespace App\Filament\Widgets;

use App\Models\Affiliate;
use App\Models\AffiliateCommission;
use App\Models\Manager;
use App\Models\Profile;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class StatsDepositTotal extends BaseWidget
{
    protected static ?int $sort = 1;
    use InteractsWithPageFilters;
    protected string $title = 'Estatísticas de Depósitos';

    protected function getStats(): array
    {
        $cards = [];

        // Verifica se há algum dos filtros aplicados
        if ($this->filters['affiliate_id'] || $this->filters['profile_id'] || $this->filters['manager_id']) {
            
            // Prioridade para o filtro 'affiliate_id'. Se mais de um filtro for passado, usará o primeiro.
            if ($this->filters['affiliate_id']) {
                // Cria um conjunto de cards para cada 'affiliate_id' selecionado
                foreach ($this->filters['affiliate_id'] as $key => $affiliate_id) {
                    $affiliate = Affiliate::find($affiliate_id);

                    //$cards[] = Stat::make('Total de depósitos (Afiliado: ' . $affiliate->name . ')', $this->formatValue($this->getCard('deposit_total', $affiliate_id)))
                    //->color('red');
                    $cards[] = Stat::make('Total de depósitos (' . $affiliate->name . ')', $this->formatValue($this->getCard('deposit_total', $affiliate_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'Total de depósitos (' . $affiliate->name . ')', 
                            'value' => $this->formatValue($this->getCard('deposit_total', $affiliate_id)),
                            'color' => 'red'
                        ]
                    )
                    ;
                    
                    $cards[] = Stat::make('FTDs Total (' . $affiliate->name . ')', $this->formatValue($this->getCard('ftd_total', $affiliate_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'FTDs Total (' . $affiliate->name . ')', 
                            'value' => $this->formatValue($this->getCard('ftd_total', $affiliate_id)),
                            'color' => 'blue'
                        ]
                    );

                    $cards[] = Stat::make('FTDs Count (' . $affiliate->name . ')', $this->getCard('ftd_count', $affiliate_id))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'FTDs Count (' . $affiliate->name . ')', 
                            'value' => $this->getCard('ftd_count', $affiliate_id),
                            'color' => 'green'
                        ]
                    );

                    $cards[] = Stat::make('Total de registros (' . $affiliate->name . ')', $this->getCard('registration_count', $affiliate_id))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'Total de registros (' . $affiliate->name . ')', 
                            'value' => $this->getCard('registration_count', $affiliate_id),
                            'color' => 'yellow'
                        ]
                    );
                }
            }
            // Se o filtro 'affiliate_id' não foi passado, usa o 'profile_id'
            elseif ($this->filters['profile_id']) {
                foreach ($this->filters['profile_id'] as $key => $profile_id) {
                    $profile = Profile::find($profile_id);

                    $cards[] = Stat::make('Total de depósitos (' . $profile->name . ')', $this->formatValue($this->getCard('deposit_total', null, $profile_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'Total de depósitos (' . $profile->name . ')', 
                            'value' => $this->formatValue($this->getCard('deposit_total', null, $profile_id)),
                            'color' => 'red'
                        ]
                    );
                    $cards[] = Stat::make('FTDs Total (' . $profile->name . ')', $this->formatValue($this->getCard('ftd_total', null, $profile_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'FTDs Total (' . $profile->name . ')', 
                            'value' => $this->formatValue($this->getCard('ftd_total', null, $profile_id)),
                            'color' => 'blue'
                        ]
                    );
                    $cards[] = Stat::make('FTDs Count (' . $profile->name . ')', $this->getCard('ftd_count', null, $profile_id))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'FTDs Count (' . $profile->name . ')', 
                            'value' => $this->getCard('ftd_count', null, $profile_id),
                            'color' => 'green'
                        ]
                    );
                    $cards[] = Stat::make('Total de registros (' . $profile->name . ')', $this->getCard('registration_count', null, $profile_id))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'Total de registros (' . $profile->name . ')', 
                            'value' => $this->getCard('registration_count', null, $profile_id),
                            'color' => 'yellow'
                        ]
                    );
                }
            }
            // Se nenhum dos dois anteriores, usa o 'manager_id'
            elseif ($this->filters['manager_id']) {
                foreach ($this->filters['manager_id'] as $key => $manager_id) {
                    $manager = Manager::find($manager_id);
                    $cards[] = Stat::make('Total de depósitos (' . $manager->name . ')', $this->formatValue($this->getCard('deposit_total', null, null, $manager_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'Total de depósitos (' . $manager->name . ')', 
                            'value' => $this->formatValue($this->getCard('deposit_total', null, null, $manager_id)),
                            'color' => 'red'
                        ]
                    );
                    $cards[] = Stat::make('FTDs Total (' . $manager->name . ')', $this->formatValue($this->getCard('ftd_total', null, null, $manager_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'FTDs Total (' . $manager->name . ')', 
                            'value' => $this->formatValue($this->getCard('ftd_total', null, null, $manager_id)),
                            'color' => 'blue'
                        ]
                    );
                    $cards[] = Stat::make('FTDs Count (' . $manager->name . ')', $this->formatValue($this->getCard('ftd_count', null, null, $manager_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'FTDs Count (' . $manager->name . ')', 
                            'value' =>$this->getCard('ftd_count', null, null, $manager_id),
                            'color' => 'green'
                        ]
                    );
                    $cards[] = Stat::make('Total de registros (' . $manager->name . ')', $this->formatValue($this->getCard('registration_count', null, null, $manager_id)))
                    ->view('filament.widgets.custom-stat', 
                        [
                            'title' => 'Total de registros (' . $manager->name . ')', 
                            'value' =>$this->getCard('registration_count', null, null, $manager_id),
                            'color' => 'yellow'
                        ]
                    );
                }
            }
        }

        // Se nenhum filtro for passado, retorna cards padrão (ou pode retornar vazio)
        return  $cards ?: [
            Stat::make('Total de dépositos', $this->formatValue($this->getCard('deposit_total'))),
            Stat::make('FTDs Total', $this->formatValue($this->getCard('ftd_total'))),
            Stat::make('FTDs Count', $this->getCard('ftd_count')),
            Stat::make('Total de registros', $this->getCard('registration_count')), 
        ];
    }

    // Ajusta o método para receber parâmetros opcionais
    protected function getCard($column, $affiliate_id = null, $profile_id = null, $manager_id = null)
    {
        $data = AffiliateCommission::selectRaw('SUM('.$column.') as total')
            ->join('affiliates', 'affiliate_commissions.affiliate_id', '=', 'affiliates.id')
            ->when($this->filters['startDate'], function ($query) {
                return $query->where('dt', '>=', $this->filters['startDate'])
                    ->where('dt', '<=', $this->filters['endDate']);
            })
            ->when($affiliate_id, function ($query) use ($affiliate_id) {
                return $query->where('affiliate_id', $affiliate_id);
            })
            ->when($profile_id, function ($query) use ($profile_id) {
                return $query->where('affiliates.profile_id', $profile_id);
            })
            ->when($manager_id, function ($query) use ($manager_id) {
                return $query->where('affiliates.manager_id', $manager_id);
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
