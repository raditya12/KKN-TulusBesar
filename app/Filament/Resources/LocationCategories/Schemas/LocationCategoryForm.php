<?php

namespace App\Filament\Resources\LocationCategories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class LocationCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(string $operation, $state, \Filament\Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('icon')
                    ->required()
                    ->default('location_on')
                    ->helperText('Gunakan nama ikon dari Google Material Symbols (cth: storefront, park)'),
                ColorPicker::make('color')
                    ->required()
                    ->default('#3b82f6'),
            ]);
    }
}
