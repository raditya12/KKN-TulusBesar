<?php

namespace App\Filament\Resources\GisFeatures;

use App\Filament\Resources\GisFeatures\Pages\CreateGisFeature;
use App\Filament\Resources\GisFeatures\Pages\EditGisFeature;
use App\Filament\Resources\GisFeatures\Pages\ListGisFeatures;
use App\Filament\Resources\GisFeatures\Schemas\GisFeatureForm;
use App\Filament\Resources\GisFeatures\Tables\GisFeaturesTable;
use App\Models\GisFeature;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class GisFeatureResource extends Resource
{
    protected static ?string $model = GisFeature::class;

    protected static ?string $modelLabel = 'Data WebGIS';

    protected static ?string $pluralModelLabel = 'Data WebGIS';

    protected static ?string $navigationLabel = 'Data WebGIS';

    protected static \UnitEnum|string|null $navigationGroup = 'CMS';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Schema $schema): Schema
    {
        return GisFeatureForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GisFeaturesTable::configure($table);
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
            'index' => ListGisFeatures::route('/'),
            'create' => CreateGisFeature::route('/create'),
            'edit' => EditGisFeature::route('/{record}/edit'),
        ];
    }
}
