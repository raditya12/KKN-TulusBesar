<?php

namespace App\Filament\Resources\Surat;

use App\Filament\Resources\Surat\Pages\ListSurat;
use App\Filament\Resources\Surat\Pages\ViewSurat;
use App\Filament\Resources\Surat\Tables\SuratTable;
use App\Models\Surat as SuratModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SuratResource extends Resource
{
    protected static ?string $model = SuratModel::class;

    protected static ?string $modelLabel = 'Arsip Surat';

    protected static ?string $pluralModelLabel = 'Arsip Surat';

    protected static ?string $navigationLabel = 'Arsip Surat';

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi Surat';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 4;

    public static function table(Table $table): Table
    {
        return SuratTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSurat::route('/'),
            'view'  => ViewSurat::route('/{record}'),
        ];
    }
}
