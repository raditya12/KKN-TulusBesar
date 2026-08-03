<?php

namespace App\Filament\Resources\MasterPlaceholders\Schemas;

use App\Models\MasterPlaceholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasterPlaceholderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama_field')
                ->label('Nama Field')
                ->helperText('Label user-friendly, misal: Nama Lengkap')
                ->required()
                ->maxLength(255),

            TextInput::make('placeholder')
                ->label('Placeholder')
                ->helperText('Format: {{key_tanpa_spasi}}, misal: {{nama}}')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(100)
                ->rules(['regex:/^\{\{[a-z][a-z0-9_]*\}\}$/'])
                ->validationMessages([
                    'regex' => 'Format harus {{key}} dengan huruf kecil dan underscore.',
                ])
                ->prefix('{{')
                ->suffix('}}')
                ->formatStateUsing(fn (?string $state) => $state ? trim(str_replace(['{{', '}}'], '', $state)) : '')
                ->dehydrateStateUsing(fn (?string $state) => '{{'.trim($state ?? '').'}}'),

            Select::make('kategori')
                ->label('Kategori')
                ->options(fn () => MasterPlaceholder::query()
                    ->whereNotNull('kategori')
                    ->distinct()
                    ->pluck('kategori', 'kategori')
                    ->toArray()
                )
                ->searchable()
                ->createOptionForm([
                    TextInput::make('kategori_baru')
                        ->label('Nama Kategori Baru')
                        ->required(),
                ])
                ->createOptionUsing(fn (array $data) => $data['kategori_baru'])
                ->required(),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(2)
                ->maxLength(500),
        ]);
    }
}
