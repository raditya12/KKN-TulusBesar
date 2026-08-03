<?php

namespace App\Filament\Resources\Surat;

use App\Filament\Resources\Surat\Pages\ArsipSurat;
use App\Models\Surat as SuratModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SuratResource extends Resource
{
    protected static ?string $model = SuratModel::class;

    protected static ?string $modelLabel = 'Surat';

    protected static ?string $pluralModelLabel = 'Surat';

    protected static ?string $navigationLabel = 'Arsip Surat';

    protected static ?string $slug = 'arsip-surat';

    protected static string|\UnitEnum|null $navigationGroup = 'Surat Menyurat';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 10;

    /**
     * Global search fields.
     */
    protected static ?string $recordTitleAttribute = 'nomor_surat';

    public static function getGloballySearchableAttributes(): array
    {
        return ['nomor_surat', 'nama_warga', 'nik'];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ArsipSurat::route('/'),
        ];
    }
}
