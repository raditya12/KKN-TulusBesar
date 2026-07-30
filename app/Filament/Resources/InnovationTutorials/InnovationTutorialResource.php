<?php

namespace App\Filament\Resources\InnovationTutorials;

use App\Filament\Resources\InnovationTutorials\Pages\CreateInnovationTutorial;
use App\Filament\Resources\InnovationTutorials\Pages\EditInnovationTutorial;
use App\Filament\Resources\InnovationTutorials\Pages\ListInnovationTutorials;
use App\Filament\Resources\InnovationTutorials\Schemas\InnovationTutorialForm;
use App\Filament\Resources\InnovationTutorials\Tables\InnovationTutorialsTable;
use App\Models\InnovationTutorial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InnovationTutorialResource extends Resource
{
    protected static ?string $model = InnovationTutorial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return InnovationTutorialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InnovationTutorialsTable::configure($table);
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
            'index' => ListInnovationTutorials::route('/'),
            'create' => CreateInnovationTutorial::route('/create'),
            'edit' => EditInnovationTutorial::route('/{record}/edit'),
        ];
    }
}
