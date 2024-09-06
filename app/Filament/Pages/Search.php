<?php

namespace App\Filament\Pages;

// use Filament\Pages\Page;

class Search //extends //Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.search';
    
    protected static ?string $title = 'Buscar';

    public static function getNavigationLabel(): string
    {
        return 'Buscar';
    }
}
