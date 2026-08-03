<?php

namespace App\Filament\Resources\TemplateSurat;

use App\Filament\Resources\TemplateSurat\Pages\CreateTemplateSurat;
use App\Filament\Resources\TemplateSurat\Pages\EditTemplateSurat;
use App\Filament\Resources\TemplateSurat\Pages\ListTemplateSurat;
use App\Filament\Resources\TemplateSurat\Pages\PreviewTemplateSurat;
use App\Filament\Resources\TemplateSurat\Tables\TemplateSuratTable;
use App\Models\TemplateSurat as TemplateSuratModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TemplateSuratResource extends Resource
{
    protected static ?string $model = TemplateSuratModel::class;

    protected static ?string $modelLabel = 'Template Surat';

    protected static ?string $pluralModelLabel = 'Template Surat';

    protected static ?string $navigationLabel = 'Template Surat';

    protected static ?string $slug = 'template-surat';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?int $navigationSort = 32;

    public static function form(Schema $schema): Schema
    {
        // Form is overridden by individual pages (Create/Edit) for more control
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return TemplateSuratTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTemplateSurat::route('/'),
            'create' => CreateTemplateSurat::route('/create'),
            'edit' => EditTemplateSurat::route('/{record}/edit'),
            'preview' => PreviewTemplateSurat::route('/{record}/preview'),
        ];
    }
}
