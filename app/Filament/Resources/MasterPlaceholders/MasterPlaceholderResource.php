<?php

namespace App\Filament\Resources\MasterPlaceholders;

use App\Filament\Resources\MasterPlaceholders\Pages\CreateMasterPlaceholder;
use App\Filament\Resources\MasterPlaceholders\Pages\EditMasterPlaceholder;
use App\Filament\Resources\MasterPlaceholders\Pages\ListMasterPlaceholders;
use App\Filament\Resources\MasterPlaceholders\Schemas\MasterPlaceholderForm;
use App\Filament\Resources\MasterPlaceholders\Tables\MasterPlaceholderTable;
use App\Models\MasterPlaceholder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MasterPlaceholderResource extends Resource
{
    protected static ?string $model = MasterPlaceholder::class;

    protected static ?string $modelLabel = 'Placeholder';

    protected static ?string $pluralModelLabel = 'Master Placeholder';

    protected static ?string $navigationLabel = 'Master Placeholder';

    protected static ?string $slug = 'master-placeholder';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-code-bracket';

    protected static ?int $navigationSort = 31;

    public static function form(Schema $schema): Schema
    {
        return MasterPlaceholderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasterPlaceholderTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMasterPlaceholders::route('/'),
            'create' => CreateMasterPlaceholder::route('/create'),
            'edit' => EditMasterPlaceholder::route('/{record}/edit'),
        ];
    }
}
