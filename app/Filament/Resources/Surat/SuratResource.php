<?php

namespace App\Filament\Resources\Surat;

use App\Filament\Resources\Surat\Pages\ListSurat;
use App\Filament\Resources\Surat\Pages\ViewSurat;
use App\Filament\Resources\Surat\Tables\SuratTable;
use App\Models\Surat as SuratModel;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Form;
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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Arsip Surat')
                    ->schema([
                        TextInput::make('nomor_surat')
                            ->label('Nomor Surat')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nama_pemohon')
                            ->label('Nama Pemohon')
                            ->required()
                            ->maxLength(255),
                        Select::make('jenis_surat_id')
                            ->relationship('jenisSurat', 'nama_surat')
                            ->label('Jenis Surat')
                            ->required(),
                        DatePicker::make('created_at')
                            ->label('Tanggal')
                            ->default(now())
                            ->required(),
                        FileUpload::make('file_docx')
                            ->label('Upload Word (Opsional)')
                            ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'])
                            ->directory('arsip-surat/docx')
                            ->preserveFilenames()
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function infolist(\Filament\Schemas\Schema $infolist): \Filament\Schemas\Schema
    {
        return $infolist
            ->columns(1)
            ->schema([
                \Filament\Schemas\Components\Grid::make(['default' => 1, 'xl' => 12])
                    ->schema([
                        // CSS Override Khusus Halaman Ini (Force Full Width)
                        \Filament\Infolists\Components\ViewEntry::make('force_full_width')
                            ->label('')
                            ->view('filament.infolists.components.force-full-width')
                            ->columnSpan('full'),

                        // Kolom 1: Informasi Arsip (3/12)
                        \Filament\Schemas\Components\Section::make('Informasi Arsip')
                            ->columnSpan(['default' => 1, 'xl' => 3])
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

                        // Kolom 2: Data Form (4/12)
                        \Filament\Schemas\Components\Section::make('Data Form')
                            ->columnSpan(['default' => 1, 'xl' => 4])
                            ->schema(function (?SuratModel $record) {
                                if (!$record || !is_array($record->data_json) || empty($record->data_json)) {
                                    return [\Filament\Infolists\Components\TextEntry::make('empty')->label('')->default('Tidak ada data form.')];
                                }

                                $data = $record->data_json;
                                $sections = [];

                                $groupPemohon = [];
                                $groupPeristiwa = [];
                                $groupPelapor = [];
                                $groupLainnya = [];

                                foreach ($data as $key => $value) {
                                    $upperKey = strtoupper(str_replace(['_', '-'], ' ', $key));
                                    
                                    $entry = \Filament\Infolists\Components\TextEntry::make('data_json.' . $key)
                                        ->label($upperKey)
                                        ->default('-');

                                    if (str_contains($upperKey, 'PELAPOR')) {
                                        $groupPelapor[] = $entry;
                                    } elseif (in_array($upperKey, ['HARI', 'TANGGAL', 'JAM', 'DI', 'SEBAB KEMATIAN', 'SEBAB', 'WAKTU', 'TEMPAT', 'HARI TANGGAL'])) {
                                        $groupPeristiwa[] = $entry;
                                    } elseif (in_array($upperKey, ['NAMA', 'NIK', 'UMUR', 'ALAMAT', 'JENIS KELAMIN', 'AGAMA', 'PEKERJAAN', 'TEMPAT LAHIR', 'TANGGAL LAHIR'])) {
                                        if ($upperKey === 'NIK') {
                                            $entry->label('NIK UTAMA ( PEMOHON / ALMARHUM )');
                                        }
                                        $groupPemohon[] = $entry;
                                    } else {
                                        if (!str_contains($upperKey, 'NOMOR SURAT')) {
                                            $groupLainnya[] = $entry;
                                        }
                                    }
                                }

                                if (count($groupPemohon) > 0) {
                                    $sections[] = \Filament\Schemas\Components\Fieldset::make('Data Utama (Pemohon / Almarhum)')
                                        ->schema($groupPemohon)
                                        ->columns(['default' => 1, 'sm' => 2]);
                                }
                                
                                if (count($groupPeristiwa) > 0) {
                                    $sections[] = \Filament\Schemas\Components\Fieldset::make('Data Detail / Peristiwa')
                                        ->schema($groupPeristiwa)
                                        ->columns(['default' => 1, 'sm' => 2]);
                                }

                                if (count($groupPelapor) > 0) {
                                    $sections[] = \Filament\Schemas\Components\Fieldset::make('Data Pelapor')
                                        ->schema($groupPelapor)
                                        ->columns(['default' => 1, 'sm' => 2]);
                                }

                                if (count($groupLainnya) > 0) {
                                    $sections[] = \Filament\Schemas\Components\Fieldset::make('Data Tambahan')
                                        ->schema($groupLainnya)
                                        ->columns(['default' => 1, 'sm' => 2]);
                                }

                                return $sections;
                            }),

                        // Kolom 3: Dokumen PDF (5/12)
                        \Filament\Schemas\Components\Section::make('Dokumen PDF')
                            ->columnSpan(['default' => 1, 'xl' => 5])
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
            'create' => Pages\CreateSurat::route('/create'),
            'view'  => ViewSurat::route('/{record}'),
        ];
    }
}
