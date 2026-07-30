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
            'PJU' => 'P j u',
            'Sampah' => 'Sampah',
            'Peternakan' => 'Peternakan',
            'Fasilitas Umum' => 'Fasilitas umum',
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
