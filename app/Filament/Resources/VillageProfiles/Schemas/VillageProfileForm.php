<?php

namespace App\Filament\Resources\VillageProfiles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VillageProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('visi')
                    ->columnSpanFull(),
                Textarea::make('misi')
                    ->columnSpanFull(),
                Textarea::make('sejarah')
                    ->columnSpanFull(),
                TextInput::make('total_population')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('area_size')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
