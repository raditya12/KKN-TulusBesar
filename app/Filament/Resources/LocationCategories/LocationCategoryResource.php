<?php

namespace App\Filament\Resources\LocationCategories;

use App\Filament\Resources\LocationCategories\Pages\CreateLocationCategory;
use App\Filament\Resources\LocationCategories\Pages\EditLocationCategory;
use App\Filament\Resources\LocationCategories\Pages\ListLocationCategories;
use App\Filament\Resources\LocationCategories\Schemas\LocationCategoryForm;
use App\Filament\Resources\LocationCategories\Tables\LocationCategoriesTable;
use App\Models\LocationCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LocationCategoryResource extends Resource
{
    protected static ?string $model = LocationCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return LocationCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LocationCategoriesTable::configure($table);
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
            'index' => ListLocationCategories::route('/'),
            'create' => CreateLocationCategory::route('/create'),
            'edit' => EditLocationCategory::route('/{record}/edit'),
        ];
    }
}
