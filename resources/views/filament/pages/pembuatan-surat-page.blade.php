<x-filament-panels::page>
    <x-filament::section icon="heroicon-o-pencil-square">
        <x-slot name="heading">Form Isian Surat</x-slot>
        <x-slot name="description">
            Pilih jenis surat, isi data form yang tersedia, lalu klik "Generate Surat". Preview template kosong dapat dilihat menggunakan tombol "Preview Template".
        </x-slot>

        <form wire:submit="generateSurat" style="margin-top: 1rem;">
            <!-- 1. Dropdown Jenis Surat & Preview Action -->
            <div style="margin-bottom: 1.25rem;">
                <label for="jenis_surat_id" style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #4b5563; margin-bottom: 0.375rem;">
                    Jenis Surat <span style="color: #ef4444;">*</span>
                </label>
                <div style="display: flex; gap: 0.75rem; align-items: stretch;">
                    <select
                        id="jenis_surat_id"
                        wire:model.live="jenis_surat_id"
                        style="flex: 1; padding: 0.625rem 0.875rem; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; color: #111827; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                    >
                        <option value="">-- Pilih Jenis Surat --</option>
                        @foreach($jenisSuratOptions as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>

                    @if($hasTemplate)
                        {{ $this->previewTemplateAction }}
                    @endif
                </div>
                @error('jenis_surat_id')
                    <p style="font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem; font-weight: 500;">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Nomor Surat -->
            <div style="margin-bottom: 1.25rem;">
                <label for="nomor_surat" style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #4b5563; margin-bottom: 0.375rem;">
                    Nomor Surat <span style="color: #ef4444;">*</span>
                </label>
                <input
                    type="text"
                    id="nomor_surat"
                    wire:model="nomor_surat"
                    placeholder="Contoh: 470 / 012 / 35.07.19.2005 / 2026"
                    style="display: block; width: 100%; padding: 0.625rem 0.875rem; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; color: #111827; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                />
                @error('nomor_surat')
                    <p style="font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem; font-weight: 500;">{{ $message }}</p>
                @enderror
            </div>

            <!-- 3. Tanggal Surat -->
            <div style="margin-bottom: 1.25rem;">
                <label for="tanggal_surat" style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #4b5563; margin-bottom: 0.375rem;">
                    Tanggal Surat <span style="color: #ef4444;">*</span>
                </label>
                <input
                    type="date"
                    id="tanggal_surat"
                    wire:model="tanggal_surat"
                    style="display: block; width: 100%; padding: 0.625rem 0.875rem; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; color: #111827; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                />
                @error('tanggal_surat')
                    <p style="font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem; font-weight: 500;">{{ $message }}</p>
                @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 1.5rem 0;" />

            <!-- 4. Dynamic Form dari Placeholder DOCX -->
            @if($hasTemplate)
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                        <h4 style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; margin: 0;">
                            Isi Data Warga di Bawah
                        </h4>
                        <span style="font-size: 0.75rem; font-family: monospace; padding: 0.125rem 0.5rem; border-radius: 0.25rem; background-color: #f3f4f6; color: #8C5A35; font-weight: 700;">
                            {{ count($placeholders) }} Data
                        </span>
                    </div>

                    @if(count($placeholders) === 0)
                        <p style="font-size: 0.875rem; color: #6b7280; font-style: italic;">
                            Tidak ada tag placeholder <code>${...}</code> yang terdeteksi pada template ini.
                        </p>
                    @else
                        @foreach($placeholders as $ph)
                            <div style="margin-bottom: 1.25rem;">
                                <label for="ph_{{ $loop->index }}" style="display: block; font-size: 0.8125rem; font-weight: 600; color: #374151; margin-bottom: 0.375rem;">
                                    {{ $this->getLabel($ph) }} <span style="color: #ef4444;">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="ph_{{ $loop->index }}"
                                    wire:model="formData.{{ $ph }}"
                                    placeholder="Masukkan {{ strtolower($this->getLabel($ph)) }}..."
                                    style="display: block; width: 100%; padding: 0.625rem 0.875rem; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; color: #111827; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                                />
                                @error('formData.' . $ph)
                                    <p style="font-size: 0.75rem; color: #dc2626; margin-top: 0.25rem; font-weight: 500;">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Action Button Generate -->
                <div style="padding-top: 1rem;">
                    <x-filament::button
                        type="submit"
                        color="primary"
                        icon="heroicon-o-document-text"
                        style="width: 100%; justify-content: center; padding: 0.75rem;"
                    >
                        Generate Surat
                    </x-filament::button>
                </div>
            @elseif($jenis_surat_id)
                <div style="padding: 0.75rem; border-radius: 0.5rem; background-color: #fffbeb; border: 1px solid #fef3c7; color: #b45309; font-size: 0.875rem; margin-bottom: 1rem;">
                    Jenis surat ini belum memiliki template DOCX aktif.
                </div>
            @endif
        </form>
    </x-filament::section>
    
    <x-filament-actions::modals />
</x-filament-panels::page>
