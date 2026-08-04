{{-- Panel placeholder untuk digunakan di dalam editor template --}}
<div x-data="placeholderPanel()" class="space-y-3">
    {{-- Search Input --}}
    <div class="relative">
        <input
            type="text"
            x-model="search"
            placeholder="Cari placeholder..."
            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-800 placeholder-slate-400 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500"
        />
    </div>

    {{-- Grouped Placeholders Container --}}
    <div class="max-h-[550px] overflow-y-auto pr-1 space-y-3">
        @foreach($placeholders as $kategori => $items)
            <div x-show="isKategoriVisible('{{ $kategori }}')" class="space-y-1.5">
                <div class="flex items-center justify-between px-1 pt-1 border-b border-slate-200 dark:border-slate-700 pb-1">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400">
                        {{ $kategori }}
                    </span>
                    <span class="text-[10px] rounded bg-slate-200 dark:bg-slate-700 px-1.5 py-0.5 text-slate-600 dark:text-slate-300 font-mono">
                        {{ count($items) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-1">
                    @foreach($items as $placeholder)
                        <button
                            type="button"
                            x-show="isVisible('{{ $placeholder->nama_field }}', '{{ $placeholder->placeholder }}')"
                            @click="insertPlaceholder('{{ $placeholder->placeholder }}')"
                            title="Klik untuk menyisipkan {{ $placeholder->placeholder }}"
                            class="group w-full rounded-md border border-slate-200 dark:border-slate-700/60 bg-slate-50 dark:bg-slate-800/80 px-2.5 py-1.5 text-left transition hover:border-amber-500 hover:bg-amber-50 dark:hover:border-amber-500 dark:hover:bg-amber-950/40"
                        >
                            <div class="flex items-center justify-between gap-1">
                                <span class="text-xs font-medium text-slate-700 dark:text-slate-200 group-hover:text-amber-800 dark:group-hover:text-amber-300">
                                    {{ $placeholder->nama_field }}
                                </span>
                                <span class="rounded bg-slate-200/80 dark:bg-slate-900 px-1.5 py-0.5 font-mono text-[10px] font-semibold text-slate-600 dark:text-slate-400 group-hover:bg-amber-200 dark:group-hover:bg-amber-900 group-hover:text-amber-900 dark:group-hover:text-amber-200">
                                    {{ $placeholder->placeholder }}
                                </span>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function placeholderPanel() {
    return {
        search: '',

        isVisible(namaField, placeholder) {
            if (!this.search) return true;
            const q = this.search.toLowerCase();
            return namaField.toLowerCase().includes(q) || placeholder.toLowerCase().includes(q);
        },

        isKategoriVisible(kategori) {
            if (!this.search) return true;
            return true;
        },

        insertPlaceholder(placeholder) {
            // Find Tiptap / Trix / Quill editor instance or active element
            const editorEl = document.querySelector('.fi-fo-rich-editor, .ql-editor, [contenteditable="true"]');

            if (editorEl) {
                // Focus editor
                editorEl.focus();
                
                // Exec command insertText if possible
                if (document.queryCommandSupported && document.queryCommandSupported('insertText')) {
                    document.execCommand('insertText', false, placeholder);
                    return;
                }
            }

            // Fallback: try textarea or input
            const activeEl = document.activeElement;
            if (activeEl && (activeEl.tagName === 'TEXTAREA' || activeEl.tagName === 'INPUT')) {
                const start = activeEl.selectionStart || 0;
                const end = activeEl.selectionEnd || 0;
                const val = activeEl.value || '';
                activeEl.value = val.substring(0, start) + placeholder + val.substring(end);
                activeEl.selectionStart = activeEl.selectionEnd = start + placeholder.length;
                activeEl.dispatchEvent(new Event('input', { bubbles: true }));
                return;
            }

            // Copy to clipboard
            if (navigator.clipboard) {
                navigator.clipboard.writeText(placeholder).then(() => {
                    alert('Variabel ' + placeholder + ' berhasil disalin ke clipboard! Silakan paste pada editor.');
                });
            }
        },
    };
}
</script>
