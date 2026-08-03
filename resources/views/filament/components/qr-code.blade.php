<div class="flex flex-col items-center justify-center p-4">
    <div class="mb-4 text-center">
        <h3 class="text-lg font-bold">{{ $title }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Scan QR Code ini untuk membuka halaman detail.</p>
    </div>
    
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
        <!-- Render QR Code SVG -->
        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->margin(1)->generate($url) !!}
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ $url }}" target="_blank" class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg text-sm font-semibold transition-colors">
            Buka Tautan
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-primary-600 text-white hover:bg-primary-500 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak QR
        </button>
    </div>
</div>
