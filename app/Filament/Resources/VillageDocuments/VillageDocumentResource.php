<?php

namespace App\Filament\Resources\VillageDocuments;

use App\Filament\Resources\VillageDocuments\Pages\CreateVillageDocument;
use App\Filament\Resources\VillageDocuments\Pages\EditVillageDocument;
use App\Filament\Resources\VillageDocuments\Pages\ListVillageDocuments;
use App\Filament\Resources\VillageDocuments\Schemas\VillageDocumentForm;
use App\Filament\Resources\VillageDocuments\Tables\VillageDocumentsTable;
use App\Models\VillageDocument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VillageDocumentResource extends Resource
{
    protected static ?string $model = VillageDocument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolderOpen;

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi Surat';

    protected static ?string $navigationLabel = 'Repositori Dokumen Publik';
    
    protected static ?string $pluralModelLabel = 'Repositori Dokumen Publik';
    
    protected static ?string $modelLabel = 'Dokumen Publik';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return VillageDocumentForm::configure($schema);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with('category');
    }

    public static function table(Table $table): Table
    {
        return VillageDocumentsTable::configure($table);
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
            'index' => ListVillageDocuments::route('/'),
            'create' => CreateVillageDocument::route('/create'),
            'edit' => EditVillageDocument::route('/{record}/edit'),
        ];
    }
}
