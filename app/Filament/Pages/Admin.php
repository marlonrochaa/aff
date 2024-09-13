<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\Sheet\DepositTotalSheet;
use App\Filament\Widgets\Sheet\FtdCountSheet;
use App\Filament\Widgets\Sheet\FtdTotalSheet;
use App\Filament\Widgets\Sheet\RegistrationSheet;
use App\Models\Affiliate;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;

class Admin extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.search';
    
    protected static ?string $title = 'Dashboard Geral';

    use HasFiltersForm;

    public $startDate;
    public $endDate;

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make('Filtros')
                ->label('Filtros')
                ->form([
                    DatePicker::make('startDate')
                        ->default(now()->subDays(7))
                        ->afterStateUpdated(function ($state) {
                            $this->startDate = $state;
                            $this->updateWidgets();
                        }),
                    DatePicker::make('endDate')
                        ->default(now())
                        ->afterStateUpdated(function ($state) {
                            $this->endDate = $state;
                            $this->updateWidgets();
                        }),
                ]),
        ];
    }

    protected function updateWidgets()
    {
        $this->dispatch("filtersUpdated", [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }

    public static function getNavigationLabel(): string
    {
        return 'Dash Geral';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            DepositTotalSheet::class,
            FtdCountSheet::class,
            FtdTotalSheet::class,
            RegistrationSheet::class
        ];
    }
}
