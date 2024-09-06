<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PixelResource\Pages;
use App\Filament\Resources\PixelResource\RelationManagers;
use App\Models\Pixel;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PixelResource extends Resource
{
    protected static ?string $model = Pixel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rss';

    protected static ?string $modelLabel = 'Pixel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\BelongsToSelect::make('affiliate_id')
                    ->label('Afiliado')
                    ->relationship('affiliate', 'name')
                    ->required(),
                Forms\Components\Fieldset::make('Dados do pixel')
                    ->schema([
                        Forms\Components\TextInput::make('value.pixel_id')
                        ->label('Pixel ID')
                        ->required(),
                        Forms\Components\Textarea::make('value.access_token')
                            ->label('Access Token')
                            ->rows(4)
                            ->required(),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('affiliate.name')
                    ->label('Afiliado')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Deletar'),
                ])->label('Ação em massa'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPixels::route('/'),
            'create' => Pages\CreatePixel::route('/create'),
            'edit' => Pages\EditPixel::route('/{record}/edit'),
        ];
    }
}
