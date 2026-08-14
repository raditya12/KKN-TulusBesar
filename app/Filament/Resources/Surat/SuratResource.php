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
use Illuminate\Database\Eloquent\Builder;

class SuratResource extends Resource
{
    protected static ?string $model = SuratModel::class;

    protected static ?string $modelLabel = 'Arsip Surat';

    protected static ?string $pluralModelLabel = 'Arsip Surat';

    protected static ?string $navigationLabel = 'Arsip Surat';

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi Surat';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('jenisSurat');
    }

    public static function table(Table $table): Table
    {
        return SuratTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function infolist(\Filament\Schemas\Schema $infolist): \Filament\Schemas\Schema
    {
        return $infolist
            ->schema([
                \Filament\Schemas\Components\Grid::make(['default' => 1, 'lg' => 3])
                    ->extraAttributes(['id' => 'surat-detail-grid'])
                    ->schema([
                        // Kolom Kiri — span 1 dari 3 kolom
                        \Filament\Schemas\Components\Section::make('Informasi Arsip')
                            ->columnSpan(['default' => 1, 'lg' => 1])
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('nomor_surat')
                                    ->label('Nomor Surat')
                                    ->weight('bold'),
                                \Filament\Infolists\Components\TextEntry::make('jenisSurat.nama_surat')
                                    ->label('Jenis Surat')
                                    ->badge()
                                    ->color('primary'),
                                \Filament\Infolists\Components\TextEntry::make('nama_pemohon')
                                    ->label('Nama Pemohon'),
                                \Filament\Infolists\Components\TextEntry::make('created_at')
                                    ->label('Dibuat Pada')
                                    ->dateTime('d M Y, H:i'),
                            ]),

                        // Data Form — kolom kiri bawah, tapi di-stack dengan Section atas
                        // karena grid-cols-3 tidak bisa stack, kita gunakan span 1 juga
                        // dan posisinya akan secara natural ada di bawah Informasi Arsip
                        \Filament\Schemas\Components\Section::make('Data Form')
                            ->columnSpan(['default' => 1, 'lg' => 1])
                            ->schema([
                                \Filament\Infolists\Components\ViewEntry::make('data_json')
                                    ->label('')
                                    ->view('filament.infolists.components.data-json-viewer'),
                            ]),

                        // Kolom Kanan — PDF, span 2 dari 3 kolom, row-span 2 agar full height
                        \Filament\Schemas\Components\Section::make('Dokumen PDF')
                            ->columnSpan(['default' => 1, 'lg' => 2])
                            ->extraAttributes(['class' => 'surat-pdf-section'])
                            ->schema([
                                \Filament\Infolists\Components\ViewEntry::make('file_pdf')
                                    ->label('')
                                    ->view('filament.infolists.components.pdf-viewer'),
                            ]),
                    ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSurat::route('/'),
            'view'  => ViewSurat::route('/{record}'),
        ];
    }
}
