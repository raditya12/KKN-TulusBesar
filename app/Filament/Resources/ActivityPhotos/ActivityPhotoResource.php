<?php

namespace App\Filament\Resources\ActivityPhotos;

use App\Filament\Resources\ActivityPhotos\Pages\CreateActivityPhoto;
use App\Filament\Resources\ActivityPhotos\Pages\EditActivityPhoto;
use App\Filament\Resources\ActivityPhotos\Pages\ListActivityPhotos;
use App\Filament\Resources\ActivityPhotos\Schemas\ActivityPhotoForm;
use App\Filament\Resources\ActivityPhotos\Tables\ActivityPhotosTable;
use App\Models\ActivityPhoto;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ActivityPhotoResource extends Resource
{
    protected static ?string $model = ActivityPhoto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'description';

    protected static ?string $modelLabel = 'Album Sejarah';

    protected static ?string $pluralModelLabel = 'Album Sejarah';

    protected static ?string $navigationLabel = 'Album Sejarah';

    protected static \UnitEnum|string|null $navigationGroup = 'CMS';

    public static function form(Schema $schema): Schema
    {
        return ActivityPhotoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityPhotosTable::configure($table);
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
            'index' => ListActivityPhotos::route('/'),
            'create' => CreateActivityPhoto::route('/create'),
            'edit' => EditActivityPhoto::route('/{record}/edit'),
        ];
    }
}
