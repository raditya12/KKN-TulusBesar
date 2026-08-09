@php
    $state = $getState();
@endphp

@if(is_array($state) && count($state) > 0)
    <div style="max-height: 350px; overflow-y: auto; padding-right: 0.5rem;" class="custom-scrollbar">
        <ul style="list-style-type: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($state as $key => $value)
                <li style="display: flex; flex-direction: column; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6;">
                    <span style="font-size: 0.7rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">
                        {{ \Illuminate\Support\Str::headline($key) }}
                    </span>
                    <span style="font-size: 0.875rem; color: #374151; font-weight: 500;">
                        {{ $value ?: '-' }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
@else
    <p style="font-size: 0.875rem; color: #9ca3af; font-style: italic; margin: 0;">Tidak ada data form.</p>
@endif
