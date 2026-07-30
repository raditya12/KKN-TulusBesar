<?php

namespace App\Filament\Resources\GisFeatures\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GisFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('category')
                    ->options([
            'PJU' => 'PJU',
            'Sampah' => 'Sampah',
            'Peternakan' => 'Peternakan',
            'Fasilitas Umum' => 'Fasilitas umum',
            'Situs Budaya' => 'Situs budaya',
        ])
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
            ]);
    }
}
