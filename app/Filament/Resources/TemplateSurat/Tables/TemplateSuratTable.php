<?php

namespace App\Filament\Resources\TemplateSurat\Tables;

use App\Models\TemplateSurat as TemplateSuratModel;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TemplateSuratTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul')
                    ->label('Judul Template')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('file_docx_path')
                    ->label('File DOCX')
                    ->formatStateUsing(fn ($state) => $state ? 'Ada' : 'Tidak ada')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),

                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('jenis_surat_id')
                    ->label('Jenis Surat')
                    ->relationship('jenisSurat', 'nama'),
            ])
            ->actions([
                Action::make('preview')
                    ->label('Preview')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (TemplateSuratModel $record) => TemplateSuratModel::find($record->id)
                        ? route('filament.admin.resources.template-surat.preview', $record)
                        : '#'
                    )
                    ->openUrlInNewTab(),

                EditAction::make(),

                DeleteAction::make()->requiresConfirmation(),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}
