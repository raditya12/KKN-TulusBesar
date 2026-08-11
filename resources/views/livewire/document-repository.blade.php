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

        <!-- Table -->
        <div class="overflow-x-auto relative min-h-[200px]">
            <div wire:loading class="absolute inset-0 bg-white/50 backdrop-blur-sm z-10 flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
            </div>
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
                                        'file_url' => \Illuminate\Support\Facades\Storage::url($doc->file_path)
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
                    <template x-if="doc.description">
                        <div>
                            <h4 class="font-label-md text-on-surface-variant mb-2">Deskripsi Dokumen</h4>
                            <p class="font-body-md text-on-surface" x-text="doc.description"></p>
                        </div>
                    </template>

                    <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/30">
                        <h4 class="font-title-md text-primary mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary-container">checklist</span> Berkas yang Perlu Disiapkan
                        </h4>
                        
                        <template x-if="doc.req_img">
                            <div class="mb-4">
                                <img :src="doc.req_img" alt="SOP / Persyaratan" class="w-full rounded-xl border border-outline-variant/20 shadow-sm">
                            </div>
                        </template>

                        <template x-if="doc.req_text">
                            <div class="prose prose-sm max-w-none text-on-surface font-body-md" x-html="doc.req_text">
                            </div>
                        </template>

                        <template x-if="!doc.req_img && !doc.req_text">
                            <div class="text-center py-4">
                                <p class="font-body-md text-on-surface-variant">Langsung unduh formulir di bawah, tidak ada berkas khusus yang perlu disiapkan sebelumnya.</p>
                            </div>
                        </template>
                    </div>
                </div>
                
                <div class="p-6 border-t border-outline-variant/30 flex justify-end gap-3 sticky bottom-0 bg-surface/90 backdrop-blur z-10">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl font-label-md text-on-surface bg-surface-variant hover:bg-surface-variant/80 transition-colors">
                        Batal
                    </button>
                    <a :href="doc.file_url" target="_blank" download class="px-5 py-2.5 rounded-xl font-label-md text-on-primary bg-primary hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-md">
                        <span class="material-symbols-outlined text-[20px]">download</span> Unduh Formulir
                    </a>
                </div>
            </div>
        </div>
    </template>
</div>
