<?php

namespace App\Filament\Resources\VillageHistories;

use App\Filament\Resources\VillageHistories\Pages\CreateVillageHistory;
use App\Filament\Resources\VillageHistories\Pages\EditVillageHistory;
use App\Filament\Resources\VillageHistories\Pages\ListVillageHistories;
use App\Filament\Resources\VillageHistories\Schemas\VillageHistoryForm;
use App\Filament\Resources\VillageHistories\Tables\VillageHistoriesTable;
use App\Models\VillageHistory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class VillageHistoryResource extends Resource
{
    protected static ?string $model = VillageHistory::class;

    protected static ?string $modelLabel = 'Garis Waktu Sejarah';

    protected static ?string $pluralModelLabel = 'Garis Waktu Sejarah';

    protected static ?string $navigationLabel = 'Garis Waktu Sejarah';

    protected static \UnitEnum|string|null $navigationGroup = 'Profil Desa';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    public static function form(Schema $schema): Schema
    {
        return VillageHistoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VillageHistoriesTable::configure($table);
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
            'index' => ListVillageHistories::route('/'),
            'create' => CreateVillageHistory::route('/create'),
            'edit' => EditVillageHistory::route('/{record}/edit'),
        ];
    }
}
