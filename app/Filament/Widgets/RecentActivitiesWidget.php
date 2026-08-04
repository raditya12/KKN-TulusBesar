<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentActivitiesWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Aktivitas Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Surat::query()
                    ->with(['jenisSurat'])
                    ->latest()
                    ->limit(10)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->description(fn (Surat $record): string => $record->created_at->diffForHumans())
                    ->sortable(),

                TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('nama_warga')
                    ->label('Nama Warga')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'dicetak' => 'info',
                        'scan_uploaded' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'dicetak' => 'Sudah Dicetak',
                        'scan_uploaded' => 'Sudah Upload Scan',
                        default => $state,
                    }),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}
