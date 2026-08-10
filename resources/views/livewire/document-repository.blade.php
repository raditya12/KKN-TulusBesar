<div>
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
                            <td class="px-6 py-4 text-right">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($doc->file_path) }}" target="_blank" download class="text-primary hover:text-secondary-container transition-colors flex items-center gap-1 ml-auto font-label-sm w-fit float-right">
                                    <span class="material-symbols-outlined text-[18px]">download</span> Unduh
                                </a>
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
</div>
