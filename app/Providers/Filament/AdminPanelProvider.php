<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Search;
use App\Filament\Resources\AffiliateResource;
use App\Filament\Resources\PixelResource;
use App\Filament\Widgets\FtdChart;
use App\Filament\Widgets\RegistrationCountChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\LegacyComponents\Widget;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            //->registration(Register::class)
            //->passwordReset()
            //->emailVerification()
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->userMenuItems([
                'logout' => MenuItem::make()->label('Sair'),
                //esconde a página de search
                // MenuItem::make()
                //     ->label('Perfil')
                //     ->url(fn (): string => '')
                //     ->icon('heroicon-o-cog-6-tooth'),
            ])
            // ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
            //     return $builder->items([
            //         NavigationItem::make('Dashboard', Pages\Dashboard::class)->icon('heroicon-o-home')->url('/admin'),
            //         NavigationItem::make('Afiliados', AffiliateResource::class)->icon('heroicon-o-user-group')->url('/admin/affiliates'),
            //         NavigationItem::make('Pixels', PixelResource::class)->icon('heroicon-o-rss')->url('/admin/pixels'),
            //         NavigationItem::make('Buscar', Search::class),
            //     ]);
            // })
            ->brandName('BetVoa')
            //->brandLogo(asset('images/logo.svg'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
                
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
            // ->tenant(Team::class, ownershipRelationship: 'team')
            // ->tenantRegistration(RegisterTeam::class)
            // ->tenantProfile(EditTeamProfile::class)
            //->tenantMenu(false);
    }
}
