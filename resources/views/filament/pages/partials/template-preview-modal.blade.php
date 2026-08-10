{{-- ── PDF Preview only ─────────────────────────────────────────────── --}}
@if ($pdfUrl)
    <div style="position:relative; width:100%; height:75vh; min-height:480px; border-radius:0.5rem; overflow:hidden; border:1px solid #d1d5db; background:#e5e7eb;">
        <iframe
            src="{{ $pdfUrl }}#toolbar=0&navpanes=0&scrollbar=1"
            title="Preview Template Surat"
            style="position:absolute; inset:0; width:100%; height:100%; border:none;"
        ></iframe>
    </div>
@else
    <div style="display:flex; align-items:center; justify-content:center; height:200px; background:#f1f5f9; border-radius:0.5rem; border:1px dashed #cbd5e1;">
        <p style="color:#94a3b8; font-size:0.875rem;">Preview tidak tersedia</p>
    </div>
@endif
