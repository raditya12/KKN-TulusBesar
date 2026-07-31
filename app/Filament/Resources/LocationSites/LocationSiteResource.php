<?php

namespace App\Filament\Resources\LocationSites;

use App\Filament\Resources\LocationSites\Pages\CreateLocationSite;
use App\Filament\Resources\LocationSites\Pages\EditLocationSite;
use App\Filament\Resources\LocationSites\Pages\ListLocationSites;
use App\Filament\Resources\LocationSites\Schemas\LocationSiteForm;
use App\Filament\Resources\LocationSites\Tables\LocationSitesTable;
use App\Models\LocationSite;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LocationSiteResource extends Resource
{
    protected static ?string $model = LocationSite::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?string $modelLabel = 'Titik Peta';
    protected static ?string $pluralModelLabel = 'Data Pemetaan';
    protected static ?string $navigationLabel = 'Data Pemetaan';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LocationSiteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LocationSitesTable::configure($table);
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
            'index' => ListLocationSites::route('/'),
            'create' => CreateLocationSite::route('/create'),
            'edit' => EditLocationSite::route('/{record}/edit'),
        ];
    }
}
