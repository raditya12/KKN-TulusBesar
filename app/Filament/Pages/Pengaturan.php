<?php

namespace App\Filament\Pages;

use App\Models\Pengaturan as PengaturanModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;

class Pengaturan extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static \UnitEnum|string|null $navigationGroup = 'Administrasi';

    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = PengaturanModel::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make('Identitas Desa')
                            ->description('Informasi dasar mengenai wilayah dan administrasi desa.')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                TextInput::make('nama_desa')->label('Nama Desa')->placeholder('Desa Tulusbesar'),
                                TextInput::make('nama_kecamatan')->label('Kecamatan')->placeholder('Nama Kecamatan'),
                                TextInput::make('nama_kabupaten')->label('Kabupaten')->placeholder('Nama Kabupaten'),
                                TextInput::make('nama_provinsi')->label('Provinsi')->placeholder('Nama Provinsi'),
                                TextInput::make('kode_pos')->label('Kode Pos')->placeholder('65000'),
                            ])->columnSpan(1),

                        Section::make('Kontak & Pejabat')
                            ->description('Data kontak resmi dan informasi Kepala Desa yang menjabat.')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                TextInput::make('nomor_telepon')->label('Nomor Telepon')->placeholder('0341-xxxxxx'),
                                TextInput::make('alamat_kantor')->label('Alamat Kantor Desa')->placeholder('Jl. ...'),
                                TextInput::make('email_desa')->label('Email Desa')->placeholder('desa@example.com')->email(),
                                TextInput::make('nama_kepala_desa')->label('Nama Kepala Desa')->placeholder('Bpk./Ibu ...'),
                                TextInput::make('nip_kepala_desa')->label('NIP Kepala Desa')->placeholder('Kosong jika tidak ada NIP'),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save')
                ->color('primary')
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            PengaturanModel::set($key, $value);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
