<?php

namespace App\Filament\Resources\JenisSurat;

use App\Filament\Resources\JenisSurat\Pages\CreateJenisSurat;
use App\Filament\Resources\JenisSurat\Pages\EditJenisSurat;
use App\Filament\Resources\JenisSurat\Pages\ListJenisSurat;
use App\Filament\Resources\JenisSurat\Schemas\JenisSuratForm;
use App\Filament\Resources\JenisSurat\Tables\JenisSuratTable;
use App\Models\JenisSurat as JenisSuratModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class JenisSuratResource extends Resource
{
    protected static ?string $model = JenisSuratModel::class;

    protected static ?string $modelLabel = 'Jenis Surat';

    protected static ?string $pluralModelLabel = 'Jenis Surat';

    protected static ?string $navigationLabel = 'Jenis Surat';

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi Surat';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return JenisSuratForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisSuratTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListJenisSurat::route('/'),
            'create' => CreateJenisSurat::route('/create'),
            'edit'   => EditJenisSurat::route('/{record}/edit'),
        ];
    }
}
