<?php

namespace App\Filament\Resources\Surat;

use App\Filament\Resources\Surat\Pages\CreateSurat;
use App\Filament\Resources\Surat\Pages\EditSurat;
use App\Filament\Resources\Surat\Pages\ListSurat;
use App\Filament\Resources\Surat\Pages\ViewSurat;
use App\Filament\Resources\Surat\Tables\SuratTable;
use App\Models\JenisSurat;
use App\Models\Surat as SuratModel;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
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

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('jenisSurat');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Arsip')
                ->description('Isi data arsip surat yang akan disimpan.')
                ->schema([
                    TextInput::make('nomor_surat')
                        ->label('Nomor Surat')
                        ->placeholder('Masukkan nomor surat')
                        ->required()
                        ->string()
                        ->maxLength(255)
                        ->validationMessages([
                            'required' => 'Nomor surat wajib diisi.',
                            'max' => 'Nomor surat terlalu panjang (maks. 255 karakter).',
                        ]),

                    TextInput::make('nama_pemohon')
                        ->label('Nama Pemohon')
                        ->placeholder('Masukkan nama pemohon')
                        ->required()
                        ->string()
                        ->maxLength(255)
                        ->validationMessages([
                            'required' => 'Nama pemohon wajib diisi.',
                            'max' => 'Nama pemohon terlalu panjang (maks. 255 karakter).',
                        ]),

                    Select::make('jenis_surat_id')
                        ->label('Jenis Surat')
                        ->placeholder('Pilih jenis surat')
                        ->options(fn () => JenisSurat::active()->pluck('nama_surat', 'id')->toArray())
                        ->searchable()
                        ->nullable()
                        ->helperText('Opsional. Pilih untuk mengelompokkan arsip berdasarkan jenis.'),

                    FileUpload::make('file_dokumen')
                        ->label('File Surat')
                        ->helperText('Upload dokumen surat yang telah dibuat sebelumnya. (Opsional)')
                        ->directory('arsip-surat/dokumen')
                        ->disk('public')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/pdf',
                        ])
                        ->maxSize(10240) // 10 MB
                        ->downloadable()
                        ->previewable(false)
                        ->nullable()
                        ->validationMessages([
                            'max' => 'Ukuran file terlalu besar (maks. 10 MB).',
                            'mimes' => 'Format file tidak didukung. Gunakan DOCX atau PDF.',
                        ]),
                ])
                ->columns(1),
        ]);
    }

    public static function infolist(Schema $infolist): Schema
    {
        return $infolist->schema([
            Section::make('Detail Arsip Surat')
                ->schema([
                    TextEntry::make('nomor_surat')
                        ->label('Nomor Surat')
                        ->weight('bold')
                        ->fontFamily('mono')
                        ->copyable()
                        ->copyMessage('Nomor surat disalin'),

                    TextEntry::make('nama_pemohon')
                        ->label('Nama Pemohon'),

                    TextEntry::make('jenisSurat.nama_surat')
                        ->label('Jenis Surat')
                        ->badge()
                        ->color('primary')
                        ->placeholder('-'),

                    TextEntry::make('created_at')
                        ->label('Tanggal Arsip')
                        ->dateTime('d M Y, H:i'),

                    TextEntry::make('file_dokumen')
                        ->label('Nama File')
                        ->formatStateUsing(fn ($state) => $state ? basename($state) : '-'),

                    TextEntry::make('file_dokumen')
                        ->label('Ukuran File')
                        ->formatStateUsing(function ($state) {
                            if (! $state) {
                                return '-';
                            }
                            $path = storage_path('app/public/'.$state);
                            if (file_exists($path)) {
                                $bytes = filesize($path);
                                if ($bytes >= 1048576) {
                                    return round($bytes / 1048576, 2).' MB';
                                }

                                return round($bytes / 1024, 1).' KB';
                            }

                            return '-';
                        }),
                ])
                ->columns(2),
        ]);
    }

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
            'create' => CreateSurat::route('/create'),
            'view' => ViewSurat::route('/{record}'),
            'edit' => EditSurat::route('/{record}/edit'),
        ];
    }
}
