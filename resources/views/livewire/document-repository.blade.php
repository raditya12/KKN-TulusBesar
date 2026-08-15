<div x-data="{ showModal: false, doc: null }">
    <div class="bg-white rounded-3xl border border-outline-variant/40 shadow-sm overflow-hidden">
        <!-- Search & Filter Bar -->
        <div class="p-4 md:p-6 bg-surface-container-low border-b border-outline-variant/40 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="relative w-full md:w-96">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari dokumen..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-sm bg-surface-container-lowest">
            </div>
            <select wire:model.live="category_id" class="w-full md:w-auto px-4 py-3 rounded-xl border border-outline-variant/50 font-body-sm outline-none bg-surface-container-lowest text-on-surface">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- List / Table View -->
        <div class="relative min-h-[200px]">
            <div wire:loading class="absolute inset-0 bg-white/50 backdrop-blur-sm z-10 flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
            </div>

            <!-- Mobile Card View (Hidden on desktop) -->
            <div class="md:hidden flex flex-col divide-y divide-outline-variant/20">
                @forelse($documents as $doc)
                    @php
                        $ext = $doc->file_extension;
                        $iconColor = match($ext) {
                            'PDF' => 'bg-red-100 text-red-600',
                            'DOC', 'DOCX' => 'bg-blue-100 text-blue-600',
                            'XLS', 'XLSX' => 'bg-green-100 text-green-600',
                            default => 'bg-surface-variant text-on-surface-variant',
                        };
                        $iconName = match($ext) {
                            'PDF' => 'picture_as_pdf',
                            'DOC', 'DOCX' => 'description',
                            'XLS', 'XLSX' => 'table',
                            default => 'insert_drive_file',
                        };
                        $docData = [
                            'title' => $doc->title,
                            'description' => $doc->description,
                            'req_img' => $doc->requirement_image_path ? \Illuminate\Support\Facades\Storage::url($doc->requirement_image_path) : null,
                            'req_text' => $doc->requirements_text,
                            'files' => collect($doc->file_paths ?? [])->map(fn($path) => [
                                'name' => basename($path),
                                'url' => \Illuminate\Support\Facades\Storage::url($path),
                                'ext' => strtoupper(pathinfo($path, PATHINFO_EXTENSION)),
                                'size' => \Illuminate\Support\Facades\Storage::disk('public')->exists($path) ? round(\Illuminate\Support\Facades\Storage::disk('public')->size($path) / 1024, 2) . ' KB' : 'Tidak Ditemukan'
                            ])->toArray()
                        ];
                    @endphp
                    <div class="p-4 flex flex-col gap-4 hover:bg-surface-container/30 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-xl {{ $iconColor }} flex items-center justify-center shrink-0 shadow-sm border border-outline-variant/10">
                                <span class="material-symbols-outlined text-[24px]">{{ $iconName }}</span>
                            </div>
                            <div class="flex-1 min-w-0 pt-0.5">
                                <div class="font-label-md font-bold text-on-surface leading-tight mb-1">{{ $doc->title }}</div>
                                <div class="flex items-center gap-2 font-body-sm text-on-surface-variant text-xs">
                                    <span class="inline-flex items-center rounded-full bg-surface-variant/50 px-2 py-0.5 text-[10px] font-medium text-on-surface-variant ring-1 ring-inset ring-outline-variant/20">{{ $doc->category?->name ?? 'Tanpa Kategori' }}</span>
                                    <span>{{ $doc->file_size }} • {{ $ext }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mt-1">
                            <div class="font-body-sm text-on-surface-variant text-[11px] flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span> {{ $doc->updated_at->translatedFormat('d M Y') }}
                            </div>
                        </div>

                        <button type="button" @click="doc = {{ json_encode($docData) }}; showModal = true" class="w-full justify-center inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-on-primary rounded-xl font-label-md hover:bg-primary/90 transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">task_alt</span> Lihat Syarat & Unduh
                        </button>
                    </div>
                @empty
                    <div class="p-8 text-center text-on-surface-variant font-body-sm">
                        Tidak ada dokumen ditemukan.
                    </div>
                @endforelse
            </div>

            <!-- Desktop Table View (Hidden on mobile) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-variant/30 text-on-surface-variant font-label-sm border-b border-outline-variant/30 uppercase tracking-wider">
                            <th class="px-6 py-4">Nama Dokumen</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 whitespace-nowrap">Tanggal Diperbarui</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse($documents as $doc)
                            <tr class="hover:bg-surface-container/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $ext = $doc->file_extension;
                                            $iconColor = match($ext) {
                                                'PDF' => 'bg-red-100 text-red-600',
                                                'DOC', 'DOCX' => 'bg-blue-100 text-blue-600',
                                                'XLS', 'XLSX' => 'bg-green-100 text-green-600',
                                                default => 'bg-surface-variant text-on-surface-variant',
                                            };
                                            $iconName = match($ext) {
                                                'PDF' => 'picture_as_pdf',
                                                'DOC', 'DOCX' => 'description',
                                                'XLS', 'XLSX' => 'table',
                                                default => 'insert_drive_file',
                                            };
                                        @endphp
                                        <div class="w-10 h-10 rounded {{ $iconColor }} flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined">{{ $iconName }}</span>
                                        </div>
                                        <div>
                                            <div class="font-label-md font-bold text-on-surface">{{ $doc->title }}</div>
                                            <div class="font-body-sm text-on-surface-variant text-xs mt-0.5">{{ $doc->file_size }} • {{ $ext }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">{{ $doc->category?->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">{{ $doc->updated_at->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @php
                                        $docData = [
                                            'title' => $doc->title,
                                            'description' => $doc->description,
                                            'req_img' => $doc->requirement_image_path ? \Illuminate\Support\Facades\Storage::url($doc->requirement_image_path) : null,
                                            'req_text' => $doc->requirements_text,
                                            'files' => collect($doc->file_paths ?? [])->map(fn($path) => [
                                                'name' => basename($path),
                                                'url' => \Illuminate\Support\Facades\Storage::url($path),
                                                'ext' => strtoupper(pathinfo($path, PATHINFO_EXTENSION)),
                                                'size' => \Illuminate\Support\Facades\Storage::disk('public')->exists($path) ? round(\Illuminate\Support\Facades\Storage::disk('public')->size($path) / 1024, 2) . ' KB' : 'Tidak Ditemukan'
                                            ])->toArray()
                                        ];
                                    @endphp
                                    <button type="button" @click="doc = {{ json_encode($docData) }}; showModal = true" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-xl font-label-md hover:bg-primary/90 transition-colors shadow-sm whitespace-nowrap">
                                        <span class="material-symbols-outlined text-[20px]">task_alt</span> Lihat Syarat & Unduh
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-on-surface-variant font-body-sm">
                                    Tidak ada dokumen ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($documents->hasPages())
            <div class="p-4 border-t border-outline-variant/40">
                {{ $documents->links(data: ['scrollTo' => false]) }}
            </div>
        @endif
    </div>

    <!-- Modal Detail Persyaratan (AlpineJS) -->
    <template x-if="doc !== null">
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 w-screen h-screen">
            <!-- Backdrop -->
            <div x-show="showModal" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="showModal = false"
                class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

            <!-- Modal Content -->
            <div x-show="showModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-surface rounded-3xl w-full sm:w-[500px] md:w-[672px] max-h-[90vh] overflow-y-auto shadow-xl border border-outline-variant/30 flex flex-col z-10">
                
                <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center sticky top-0 bg-surface/90 backdrop-blur z-10">
                    <h3 class="font-title-lg text-on-surface line-clamp-1" x-text="'Persyaratan: ' + doc.title"></h3>
                    <button type="button" @click="showModal = false" class="text-on-surface-variant hover:text-error transition-colors p-1 rounded-full hover:bg-surface-variant/50">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Deskripsi Dokumen (Optional, less emphasized) -->
                    <template x-if="doc.description">
                        <div class="bg-surface-variant/30 p-4 rounded-2xl border border-outline-variant/20">
                            <h4 class="font-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Informasi</h4>
                            <p class="font-body-md text-on-surface" x-text="doc.description"></p>
                        </div>
                    </template>

                    <!-- Persyaratan Utama (Highly Emphasized) -->
                    <div>
                        <h4 class="font-title-lg text-primary mb-4 flex items-center gap-2 border-b border-outline-variant/30 pb-3">
                            <span class="material-symbols-outlined text-secondary-container text-2xl">task</span> 
                            Berkas yang Harus Disiapkan
                        </h4>
                        
                        <template x-if="doc.req_text">
                            <div class="prose prose-lg prose-p:leading-relaxed prose-li:marker:text-primary max-w-none text-on-surface font-body-lg bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30" x-html="doc.req_text">
                            </div>
                        </template>

                        <template x-if="!doc.req_text">
                            <div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/30 text-center py-8">
                                <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3 block">description</span>
                                <p class="font-body-lg text-on-surface font-medium">Tidak ada berkas tambahan yang perlu disiapkan.</p>
                                <p class="font-body-md text-on-surface-variant mt-1">Anda bisa langsung mengunduh formulir di bawah.</p>
                            </div>
                        </template>

                    <!-- Tautan Poster SOP jika ada -->
                        <template x-if="doc.req_img">
                            <div class="mt-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-on-surface-variant text-lg">image</span>
                                <a :href="doc.req_img" target="_blank" class="font-label-md text-secondary hover:text-primary underline underline-offset-4 transition-colors">
                                    Lihat Poster Panduan Visual (Opsional)
                                </a>
                            </div>
                        </template>

                        <!-- Berkas Unduhan -->
                        <div class="mt-8">
                            <h4 class="font-title-lg text-primary mb-4 flex items-center gap-2 border-b border-outline-variant/30 pb-3">
                                <span class="material-symbols-outlined text-secondary-container text-2xl">download_for_offline</span> 
                                Formulir & Dokumen
                            </h4>
                            
                            <template x-if="doc.files && doc.files.length > 0">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <template x-for="file in doc.files">
                                        <a :href="file.url" target="_blank" download class="flex items-center gap-3 p-3 rounded-2xl bg-surface-variant/30 hover:bg-surface-variant border border-outline-variant/30 transition-colors group">
                                            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined">description</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="font-label-md text-on-surface line-clamp-1 group-hover:text-primary transition-colors" x-text="file.name"></div>
                                                <div class="font-body-sm text-on-surface-variant text-[11px]" x-text="file.ext + ' • ' + file.size"></div>
                                            </div>
                                            <div class="shrink-0 text-primary">
                                                <span class="material-symbols-outlined">download</span>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!doc.files || doc.files.length === 0">
                                <div class="p-4 text-center text-on-surface-variant font-body-sm bg-surface-variant/30 rounded-2xl">
                                    Tidak ada file formulir yang tersedia.
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 border-t border-outline-variant/30 flex justify-end sticky bottom-0 bg-surface/95 backdrop-blur z-10">
                    <button type="button" @click="showModal = false" class="px-8 py-2.5 rounded-2xl font-label-lg text-on-surface bg-surface-variant hover:bg-surface-variant/80 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
