<?php

namespace App\Filament\Resources\CulturalSites;

use App\Filament\Resources\CulturalSites\Pages\CreateCulturalSite;
use App\Filament\Resources\CulturalSites\Pages\EditCulturalSite;
use App\Filament\Resources\CulturalSites\Pages\ListCulturalSites;
use App\Filament\Resources\CulturalSites\Schemas\CulturalSiteForm;
use App\Filament\Resources\CulturalSites\Tables\CulturalSitesTable;
use App\Models\CulturalSite;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CulturalSiteResource extends Resource
{
    protected static ?string $model = CulturalSite::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CulturalSiteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CulturalSitesTable::configure($table);
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
            'index' => ListCulturalSites::route('/'),
            'create' => CreateCulturalSite::route('/create'),
            'edit' => EditCulturalSite::route('/{record}/edit'),
        ];
    }
}
