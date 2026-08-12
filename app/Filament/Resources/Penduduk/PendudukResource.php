<?php

namespace App\Filament\Resources\Penduduk;

use App\Filament\Resources\Penduduk\Pages\ListPenduduk;
use App\Filament\Resources\Penduduk\Pages\ViewPenduduk;
use App\Models\Family;
use App\Models\FamilyMember;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class PendudukResource extends Resource
{
    protected static ?string $model = FamilyMember::class;

    protected static ?string $modelLabel = 'Penduduk';

    protected static ?string $pluralModelLabel = 'Data Warga';

    protected static ?string $navigationLabel = 'Data Warga';

    protected static UnitEnum|string|null $navigationGroup = 'Data Penduduk';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('family');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('jenis_kelamin')
                    ->label('L/P')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'Laki-laki' => 'info',
                        'Perempuan' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'Laki-laki' => 'L',
                        'Perempuan' => 'P',
                        default => $state ?? '-',
                    })
                    ->sortable(),

                TextColumn::make('tanggal_lahir')
                    ->label('Tgl Lahir')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('umur')
                    ->label('Umur')
                    ->suffix(' thn')
                    ->getStateUsing(fn (FamilyMember $record) => $record->umur)
                    ->sortable(false),

                TextColumn::make('status_hubungan')
                    ->label('Hubungan')
                    ->badge()
                    ->color(fn (?string $state) => $state === 'Kepala Keluarga' ? 'warning' : 'gray')
                    ->sortable(),

                TextColumn::make('family.nama_kepala_keluarga')
                    ->label('Keluarga Dari (KK)')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                TextColumn::make('family.dusun')
                    ->label('Dusun')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('family.rw')
                    ->label('RW')
                    ->sortable(),

                TextColumn::make('family.rt')
                    ->label('RT')
                    ->sortable(),

                TextColumn::make('agama')
                    ->label('Agama')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('jenis_pekerjaan')
                    ->label('Pekerjaan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('dusun')
                    ->label('Dusun')
                    ->options(fn () => Family::select('dusun')
                        ->distinct()
                        ->whereNotNull('dusun')
                        ->orderBy('dusun')
                        ->pluck('dusun', 'dusun')
                        ->toArray()
                    )
                    ->query(fn (Builder $query, array $data) => $query->when(
                        $data['value'],
                        fn ($q, $v) => $q->whereHas('family', fn ($fq) => $fq->where('dusun', $v))
                    )),

                SelectFilter::make('rw')
                    ->label('RW')
                    ->options(fn () => Family::select('rw')
                        ->distinct()
                        ->whereNotNull('rw')
                        ->orderBy('rw')
                        ->pluck('rw', 'rw')
                        ->toArray()
                    )
                    ->query(fn (Builder $query, array $data) => $query->when(
                        $data['value'],
                        fn ($q, $v) => $q->whereHas('family', fn ($fq) => $fq->where('rw', $v))
                    )),

                SelectFilter::make('rt')
                    ->label('RT')
                    ->options(fn () => Family::select('rt')
                        ->distinct()
                        ->whereNotNull('rt')
                        ->orderBy('rt')
                        ->pluck('rt', 'rt')
                        ->toArray()
                    )
                    ->query(fn (Builder $query, array $data) => $query->when(
                        $data['value'],
                        fn ($q, $v) => $q->whereHas('family', fn ($fq) => $fq->where('rt', $v))
                    )),

                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),

                SelectFilter::make('agama')
                    ->label('Agama')
                    ->options(fn () => FamilyMember::select('agama')
                        ->distinct()
                        ->whereNotNull('agama')
                        ->orderBy('agama')
                        ->pluck('agama', 'agama')
                        ->toArray()
                    ),

                SelectFilter::make('pendidikan_terakhir')
                    ->label('Pendidikan')
                    ->options(fn () => FamilyMember::select('pendidikan_terakhir')
                        ->distinct()
                        ->whereNotNull('pendidikan_terakhir')
                        ->orderBy('pendidikan_terakhir')
                        ->pluck('pendidikan_terakhir', 'pendidikan_terakhir')
                        ->toArray()
                    ),

                SelectFilter::make('jenis_pekerjaan')
                    ->label('Pekerjaan')
                    ->options(fn () => FamilyMember::select('jenis_pekerjaan')
                        ->distinct()
                        ->whereNotNull('jenis_pekerjaan')
                        ->orderBy('jenis_pekerjaan')
                        ->pluck('jenis_pekerjaan', 'jenis_pekerjaan')
                        ->toArray()
                    ),

                SelectFilter::make('kelompok_umur')
                    ->label('Kelompok Umur')
                    ->options([
                        '0-5' => '0–5 tahun',
                        '6-12' => '6–12 tahun',
                        '13-17' => '13–17 tahun',
                        '18-25' => '18–25 tahun',
                        '26-40' => '26–40 tahun',
                        '41-60' => '41–60 tahun',
                        '61+' => '61+ tahun',
                    ])
                    ->query(fn (Builder $query, array $data) => $query->when(
                        $data['value'],
                        fn ($q, $v) => $q->kelompokUmur($v)
                    )),
            ])

            ->recordActions([
                ViewAction::make()->label('Detail'),
            ])

            ->searchPlaceholder('Cari nama warga...')
            ->emptyStateIcon('heroicon-o-users')
            ->emptyStateHeading('Belum ada data warga')
            ->emptyStateDescription('Klik tombol "Tarik Data" di halaman Data Penduduk untuk mengambil data dari Google Sheets.')
            ->defaultSort('nama')
            ->striped()
            ->paginated([25, 50, 100]);
    }

    public static function infolist(Schema $infolist): Schema
    {
        return $infolist->schema([
            Section::make('Data Pribadi')
                ->icon('heroicon-o-user')
                ->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('nama')
                            ->label('Nama Lengkap')
                            ->weight('bold'),

                        TextEntry::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->badge()
                            ->color(fn (?string $state) => match ($state) {
                                'Laki-laki' => 'info',
                                'Perempuan' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('status_hubungan')
                            ->label('Status Hubungan')
                            ->badge()
                            ->color(fn (?string $state) => $state === 'Kepala Keluarga' ? 'warning' : 'gray'),

                        TextEntry::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->date('d F Y')
                            ->placeholder('-'),

                        TextEntry::make('umur')
                            ->label('Umur')
                            ->suffix(' tahun')
                            ->getStateUsing(fn (FamilyMember $record) => $record->umur ?? '-')
                            ->placeholder('-'),

                        TextEntry::make('agama')
                            ->label('Agama')
                            ->placeholder('-'),

                        TextEntry::make('pendidikan_terakhir')
                            ->label('Pendidikan Terakhir')
                            ->placeholder('-'),

                        TextEntry::make('jenis_pekerjaan')
                            ->label('Pekerjaan')
                            ->placeholder('-'),
                    ]),
                ]),

            Section::make('Data Wilayah')
                ->icon('heroicon-o-map-pin')
                ->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('family.dusun')
                            ->label('Dusun')
                            ->badge()
                            ->color('primary')
                            ->placeholder('-'),

                        TextEntry::make('family.rw')
                            ->label('RW')
                            ->placeholder('-'),

                        TextEntry::make('family.rt')
                            ->label('RT')
                            ->placeholder('-'),
                    ]),
                ]),

            Section::make('Data Keluarga')
                ->icon('heroicon-o-home')
                ->schema([
                    TextEntry::make('family.nama_kepala_keluarga')
                        ->label('Nama Kepala Keluarga')
                        ->weight('semibold')
                        ->placeholder('-'),

                    TextEntry::make('anggota_keluarga')
                        ->label('Anggota Keluarga Lainnya')
                        ->getStateUsing(function (FamilyMember $record) {
                            $anggota = $record->family->members()
                                ->where('nomor_anggota', '>', 0)
                                ->where('id', '!=', $record->id)
                                ->get();

                            if ($anggota->isEmpty()) {
                                return 'Tidak ada anggota lain';
                            }

                            return $anggota->map(fn ($a) => "{$a->nama} ({$a->status_hubungan})"
                            )->join(', ');
                        })
                        ->placeholder('-'),
                ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenduduk::route('/'),
            'view' => ViewPenduduk::route('/{record}'),
        ];
    }
}
