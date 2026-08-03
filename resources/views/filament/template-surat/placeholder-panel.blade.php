{{-- Panel placeholder untuk digunakan di dalam editor template --}}
<div x-data="placeholderPanel()" class="space-y-3">
    {{-- Search --}}
    <div>
        <input
            type="text"
            x-model="search"
            placeholder="🔍 Cari placeholder..."
            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500"
        />
    </div>

    {{-- Grouped Placeholders --}}
    @foreach($placeholders as $kategori => $items)
        <div x-show="isKategoriVisible('{{ $kategori }}')" class="space-y-1">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider px-1 pt-2">
                {{ $kategori }}
            </p>

            @foreach($items as $placeholder)
                <button
                    type="button"
                    x-show="isVisible('{{ $placeholder->nama_field }}', '{{ $placeholder->placeholder }}')"
                    @click="insertPlaceholder('{{ $placeholder->placeholder }}')"
                    title="{{ $placeholder->deskripsi }}"
                    class="w-full text-left px-3 py-2 rounded-lg text-sm bg-gray-50 dark:bg-gray-700 hover:bg-primary-50 dark:hover:bg-primary-900 hover:text-primary-700 dark:hover:text-primary-300 transition-colors duration-150 group"
                >
                    <div class="flex items-center justify-between">
                        <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-primary-700 dark:group-hover:text-primary-300">
                            {{ $placeholder->nama_field }}
                        </span>
                        <span class="text-xs font-mono text-gray-400 dark:text-gray-500 group-hover:text-primary-500">
                            {{ $placeholder->placeholder }}
                        </span>
                    </div>
                </button>
            @endforeach
        </div>
    @endforeach
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
            // Check if any item in this kategori is visible
            return true; // Simplified — all categories stay visible
        },

        insertPlaceholder(placeholder) {
            // Find the Quill editor instance used by Filament's RichEditor
            const editorEl = document.querySelector('.ql-editor');

            if (editorEl) {
                // Insert at cursor position using Quill API
                const quill = Quill.find(editorEl.parentElement);
                if (quill) {
                    const range = quill.getSelection(true);
                    quill.insertText(range ? range.index : quill.getLength(), placeholder);
                    return;
                }
            }

            // Fallback: try textarea
            const textarea = document.querySelector('[data-field-wrapper] textarea, #template-editor-input');
            if (textarea) {
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const value = textarea.value;
                textarea.value = value.substring(0, start) + placeholder + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + placeholder.length;
                textarea.dispatchEvent(new Event('input', { bubbles: true }));
                return;
            }

            // Last resort: copy to clipboard
            navigator.clipboard.writeText(placeholder).then(() => {
                alert('Placeholder "' + placeholder + '" disalin ke clipboard. Tempel di posisi kursor editor.');
            });
        },
    };
}
</script>
