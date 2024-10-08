<?php
namespace App\Filament\Pages;

use App\Filament\Widgets\DepositTotalChart;
use App\Filament\Widgets\FtdCountChart;
use App\Filament\Widgets\FtdTotalChart;
use App\Filament\Widgets\RegistrationCountChart;
use App\Filament\Widgets\StatsDepositTotal;
use App\Models\Affiliate;
use App\Models\Manager;
use App\Models\Profile;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;
    protected static ?string $title = 'Dashboard Smartico';
    protected static ?string $icon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label('Data Inicial')
                            ->required()
                            ->default(now()->subDays(7)),
                        DatePicker::make('endDate')
                            ->label('Data Final')
                            ->required()
                            ->default(now()),
                        Select::make('affiliate_id')
                            ->label('Afiliado')
                            ->multiple()
                            ->placeholder('Todos')
                            ->options(fn () => Affiliate::pluck('name', 'id'))
                            ->default(null),
                        Select::make('manager_id')
                            ->label('Gerente')
                            ->multiple()
                            ->placeholder('Todos')
                            ->options(fn () => Manager::pluck('name', 'id'))
                            ->default(null),
                        Select::make('profile_id')
                            ->label('Perfil')
                            ->multiple()
                            ->placeholder('Todos')
                            ->options(fn () => Profile::pluck('name', 'id'))
                            ->default(null),
                    ])
                    ->columns(5),
            ]);
    }

    public function getWidgets(): array
    {
        return [
            StatsDepositTotal::class,
            DepositTotalChart::class,
            FtdCountChart::class,
            FtdTotalChart::class,
            RegistrationCountChart::class,

        ];
    }
}