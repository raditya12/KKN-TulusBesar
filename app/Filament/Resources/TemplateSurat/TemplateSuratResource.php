<?php

namespace App\Filament\Resources\TemplateSurat;

use App\Filament\Resources\TemplateSurat\Pages\CreateTemplateSurat;
use App\Filament\Resources\TemplateSurat\Pages\EditTemplateSurat;
use App\Filament\Resources\TemplateSurat\Pages\ListTemplateSurat;
use App\Filament\Resources\TemplateSurat\Schemas\TemplateSuratForm;
use App\Filament\Resources\TemplateSurat\Tables\TemplateSuratTable;
use App\Models\TemplateSurat as TemplateSuratModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TemplateSuratResource extends Resource
{
    protected static ?string $model = TemplateSuratModel::class;

    protected static ?string $modelLabel = 'Template Surat';

    protected static ?string $pluralModelLabel = 'Template Surat';

    protected static ?string $navigationLabel = 'Template Surat';

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi Surat';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return TemplateSuratForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('jenisSurat');
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
            'index'  => ListTemplateSurat::route('/'),
            'create' => CreateTemplateSurat::route('/create'),
            'edit'   => EditTemplateSurat::route('/{record}/edit'),
        ];
    }
}
