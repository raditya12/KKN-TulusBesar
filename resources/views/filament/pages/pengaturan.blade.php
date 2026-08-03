<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Pengaturan Aplikasi</x-slot>
        <x-slot name="description">Konfigurasi data desa yang digunakan pada kop surat dan sistem.</x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Identitas Desa --}}
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                    Identitas Desa
                </h3>

                @foreach([
                    ['key' => 'nama_desa', 'label' => 'Nama Desa', 'placeholder' => 'Desa Tulusbesar'],
                    ['key' => 'nama_kecamatan', 'label' => 'Kecamatan', 'placeholder' => 'Nama Kecamatan'],
                    ['key' => 'nama_kabupaten', 'label' => 'Kabupaten', 'placeholder' => 'Nama Kabupaten'],
                    ['key' => 'nama_provinsi', 'label' => 'Provinsi', 'placeholder' => 'Nama Provinsi'],
                    ['key' => 'kode_pos', 'label' => 'Kode Pos', 'placeholder' => '65000'],
                ] as $field)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ $field['label'] }}
                        </label>
                        <input
                            type="text"
                            wire:model="{{  $field['key']  }}"
                            placeholder="{{ $field['placeholder'] }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        />
                    </div>
                @endforeach
            </div>

            {{-- Kontak & Kepala Desa --}}
            <div class="space-y-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                    Kontak & Pejabat
                </h3>

                @foreach([
                    ['key' => 'nomor_telepon', 'label' => 'Nomor Telepon', 'placeholder' => '0341-xxxxxx'],
                    ['key' => 'alamat_kantor', 'label' => 'Alamat Kantor Desa', 'placeholder' => 'Jl. ...'],
                    ['key' => 'email_desa', 'label' => 'Email Desa', 'placeholder' => 'desa@example.com'],
                    ['key' => 'nama_kepala_desa', 'label' => 'Nama Kepala Desa', 'placeholder' => 'Bpk./Ibu ...'],
                    ['key' => 'nip_kepala_desa', 'label' => 'NIP Kepala Desa', 'placeholder' => 'Kosong jika tidak ada NIP'],
                ] as $field)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ $field['label'] }}
                        </label>
                        <input
                            type="text"
                            wire:model="{{ $field['key'] }}"
                            placeholder="{{ $field['placeholder'] }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                        />
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Logo Upload --}}
        <div class="mt-6">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-3">
                Logo & Kop Surat
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Path Logo Desa
                    </label>
                    <input
                        type="text"
                        wire:model="logo_path"
                        placeholder="Contoh: logos/logo-desa.png (path relatif dari storage/public)"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                    />
                    <p class="text-xs text-gray-500 mt-1">Akan digunakan pada template Custom Surat. Upload logo terlebih dahulu melalui file manager.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Kop Surat (HTML)
                    </label>
                    <textarea
                        wire:model="kop_surat_html"
                        rows="6"
                        placeholder="Paste kop surat HTML di sini..."
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary-500 font-mono text-sm"
                    ></textarea>
                    <p class="text-xs text-gray-500 mt-1">HTML kop surat akan ditambahkan secara otomatis pada Custom Surat. Anda dapat mengisi ini nanti setelah menerima template dari operator.</p>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <x-filament::button
                wire:click="save"
                wire:loading.attr="disabled"
                icon="heroicon-o-check"
            >
                <span wire:loading.remove wire:target="save">Simpan Pengaturan</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-panels::page>
