<x-filament-panels::page>
    <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: flex-start; width: 100%;">
        <!-- Panel Kiri (Form Isian Surat - 35%) -->
        <div style="flex: 0 0 35%; min-width: 320px; box-sizing: border-box;">
            <x-filament::section icon="heroicon-o-pencil-square">
                <x-slot name="heading">Form Isian Surat</x-slot>
                <x-slot name="description">
                    Isi data di bawah ini. Dokumen DOCX dan PDF akan dibuat secara otomatis sesuai template Word.
                </x-slot>

                <div
                    x-data="{
                        debounceTimer: null,
                        isGenerating: false,

                        triggerDebounce() {
                            clearTimeout(this.debounceTimer);
                            this.debounceTimer = setTimeout(() => {
                                this.runReload();
                            }, 400);
                        },

                        runReload() {
                            clearTimeout(this.debounceTimer);
                            this.isGenerating = true;
                            $wire.reloadPreview().finally(() => {
                                this.isGenerating = false;
                            });
                        }
                    }"
                    @input="triggerDebounce()"
                    @change="triggerDebounce()"
                    style="margin-top: 1rem;"
                >
                    <!-- 1. Dropdown Jenis Surat -->
                    <div style="margin-bottom: 1.25rem;">
                        <label for="jenis_surat_id" style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #4b5563; margin-bottom: 0.375rem;">
                            Jenis Surat <span style="color: #ef4444;">*</span>
                        </label>
                        <select
                            id="jenis_surat_id"
                            wire:model.live="jenis_surat_id"
                            style="display: block; width: 100%; padding: 0.625rem 0.875rem; font-size: 0.875rem; border-radius: 0.5rem; border: 1px solid #d1d5db; background-color: #ffffff; color: #111827; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);"
                        >
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($jenisSuratOptions as $id => $nama)
                                <option value="{{ $id }}">{{ $nama }}</option>
                            @endforeach
                        </select>
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
                                    Field Dinamis Template
                                </h4>
                                <span style="font-size: 0.75rem; font-family: monospace; padding: 0.125rem 0.5rem; border-radius: 0.25rem; background-color: #f3f4f6; color: #8C5A35; font-weight: 700;">
                                    {{ count($placeholders) }} Field
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
                                            <span style="font-size: 0.75rem; font-family: monospace; color: #9ca3af; font-weight: 400;">(${{"{$ph}"}})</span>
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
                    @elseif($jenis_surat_id)
                        <div style="padding: 0.75rem; border-radius: 0.5rem; background-color: #fffbeb; border: 1px solid #fef3c7; color: #b45309; font-size: 0.875rem; margin-bottom: 1rem;">
                            Jenis surat ini belum memiliki template DOCX aktif.
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div style="padding-top: 1rem; display: flex; flex-direction: column; gap: 0.75rem;">
                        <x-filament::button
                            type="button"
                            wire:click="reloadMsWordPreview"
                            color="gray"
                            icon="heroicon-o-arrow-path"
                            style="width: 100%; justify-content: center;"
                        >
                            Render MS Word (100% Layout Resmi)
                        </x-filament::button>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                            <x-filament::button
                                type="button"
                                wire:click="generateDocx"
                                color="primary"
                                icon="heroicon-o-document-text"
                                style="width: 100%; justify-content: center;"
                            >
                                Generate DOCX
                            </x-filament::button>

                            <x-filament::button
                                type="button"
                                wire:click="generatePdf"
                                color="danger"
                                icon="heroicon-o-arrow-down-tray"
                                style="width: 100%; justify-content: center;"
                            >
                                Generate PDF
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </x-filament::section>
        </div>

        <!-- Panel Kanan (PDF Viewer A4 - 63%) -->
        <div
            x-data="{
                zoom: 1.0,
                loading: false,
                bustParam: 0,

                handleReload() {
                    this.loading = true;
                    this.bustParam = Date.now();
                    const iframe = this.$refs.pdfIframe;
                    if (iframe) {
                        iframe.src = '{{ $this->getPreviewUrl() }}?v=' + this.bustParam + '#toolbar=0&navpanes=0&scrollbar=1';
                    }
                },

                forceReload() {
                    this.loading = true;
                    $wire.reloadPreview().then(() => {
                    });
                }
            }"
            @reload-iframe.window="handleReload()"
            style="flex: 1 1 60%; min-width: 450px; position: sticky; top: 1.5rem; box-sizing: border-box;"
        >
            <x-filament::section icon="heroicon-o-document">
                <x-slot name="heading">
                    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <span>Preview PDF Surat</span>
                            <span x-show="loading" x-transition style="font-size: 0.75rem; font-weight: 600; color: #8C5A35; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <svg class="animate-spin" style="height: 0.875rem; width: 0.875rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memperbarui Preview...
                            </span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.375rem;">
                            <button type="button" @click="zoom = Math.min(zoom + 0.15, 2.0)" style="padding: 0.25rem 0.5rem; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: #ffffff; font-size: 0.75rem; font-weight: 600; cursor: pointer;">+ Zoom In</button>
                            <button type="button" @click="zoom = Math.max(zoom - 0.15, 0.6)" style="padding: 0.25rem 0.5rem; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: #ffffff; font-size: 0.75rem; font-weight: 600; cursor: pointer;">- Zoom Out</button>
                            <button type="button" @click="zoom = 1.0" style="padding: 0.25rem 0.5rem; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: #ffffff; font-size: 0.75rem; font-weight: 600; cursor: pointer;">100%</button>
                            <button type="button" @click="forceReload()" style="padding: 0.25rem 0.5rem; border-radius: 0.375rem; border: 1px solid #8C5A35; background-color: #8C5A35; color: #ffffff; font-size: 0.75rem; font-weight: 600; cursor: pointer;">Reload</button>
                        </div>
                    </div>
                </x-slot>
                <x-slot name="description">
                    Preview langsung diperbarui secara instan saat mengetik. Untuk cetak resmi gunakan tombol Generate.
                </x-slot>

                <!-- PDF Container -->
                <div style="background-color: #374151; padding: 1.5rem; border-radius: 0.75rem; overflow: auto; max-height: 82vh; border: 1px solid #1f2937; position: relative;">
                    @if($jenis_surat_id && $hasTemplate && $previewReady)
                        <div style="width: 100%; display: flex; justify-content: center; position: relative;">
                            <div
                                x-show="loading"
                                x-transition.opacity
                                style="position: absolute; inset: 0; background-color: rgba(55, 65, 81, 0.4); backdrop-filter: blur(1px); display: flex; align-items: center; justify-content: center; z-index: 20; border-radius: 0.5rem;"
                            >
                                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1.25rem; background-color: #ffffff; border-radius: 0.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2); border: 1px solid #e5e7eb;">
                                    <svg class="animate-spin" style="height: 1.25rem; width: 1.25rem; color: #8C5A35;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span style="font-size: 0.8125rem; font-weight: 600; color: #374151;">Memperbarui Preview...</span>
                                </div>
                            </div>

                            <iframe
                                x-ref="pdfIframe"
                                @load="loading = false"
                                src="{{ $this->getPreviewUrl() }}#toolbar=0&navpanes=0&scrollbar=1"
                                style="width: 100%; min-height: 800px; border: none; border-radius: 0.5rem; background-color: #ffffff; transition: transform 0.2s ease-in-out;"
                                :style="{ transform: 'scale(' + zoom + ')', transformOrigin: 'top center' }"
                            ></iframe>
                        </div>
                    @else
                        <div style="width: 100%; min-height: 600px; background-color: #ffffff; border: 2px dashed #9ca3af; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem; text-align: center;">
                            <div style="width: 4rem; height: 4rem; border-radius: 9999px; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; margin-bottom: 1rem;">
                                <x-filament::icon icon="heroicon-o-document-text" style="width: 2.5rem; height: 2.5rem;" />
                            </div>
                            <h3 style="font-size: 1rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                @if(!$jenis_surat_id)
                                    Silakan Pilih Jenis Surat
                                @else
                                    Memuat Preview PDF Dokumen...
                                @endif
                            </h3>
                            <p style="font-size: 0.8125rem; color: #6b7280; max-width: 22rem; margin: 0;">
                                @if(!$jenis_surat_id)
                                    Pilih jenis surat pada panel kiri. Preview akan muncul secara otomatis.
                                @else
                                    File preview PDF sedang diproses...
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
