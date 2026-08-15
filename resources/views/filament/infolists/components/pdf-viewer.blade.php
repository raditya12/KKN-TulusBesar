@php
    $state = $getState();
@endphp

@if($state && \Illuminate\Support\Facades\Storage::disk('public')->exists($state))
    <div style="display: flex; gap: 0.75rem; margin-bottom: 1rem; justify-content: flex-end;">
        <a href="{{ \Illuminate\Support\Facades\Storage::url($state) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #f3f4f6; color: #374151; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; border: 1px solid #d1d5db; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='#f3f4f6'">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
            </svg>
            Buka Fullscreen
        </a>
        <a href="{{ \Illuminate\Support\Facades\Storage::url($state) }}" download target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #f3f4f6; color: #374151; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; border: 1px solid #d1d5db; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#e5e7eb'" onmouseout="this.style.backgroundColor='#f3f4f6'">
            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Unduh PDF
        </a>
    </div>
    <div style="width: 100%; display: flex; flex-direction: column; justify-content: flex-start; align-items: center; height: 100%;">
        <div style="width: 100%; position: relative; padding-bottom: 141.42%; border-radius: 0.375rem; overflow: hidden; border: 1px solid #d1d5db; background: #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <iframe
                src="{{ \Illuminate\Support\Facades\Storage::url($state) }}#toolbar=0&navpanes=0&view=FitH"
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
            ></iframe>
        </div>
    </div>
@else
    <div style="padding: 3rem; text-align: center; color: #6b7280; background-color: #f9fafb; border-radius: 0.375rem; border: 1px dashed #d1d5db; display: flex; flex-direction: column; align-items: center; justify-content: center; height: calc(100vh - 220px); min-height: 600px; width: 100%;">
        <svg style="width: 3rem; height: 3rem; margin-bottom: 1rem; color: #9ca3af;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p style="font-size: 1rem; font-weight: 500;">Dokumen PDF tidak tersedia.</p>
        <p style="font-size: 0.875rem; margin-top: 0.25rem;">File mungkin belum di-generate atau telah dihapus.</p>
    </div>
@endif
