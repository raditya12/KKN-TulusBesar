<div class="text-center qr-container" x-data style="padding: 1.5rem;">
    <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem; color: var(--text-color);">{{ $title }}</h2>
    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">Scan QR Code ini untuk membuka halaman detail</p>
    
    <div style="display: flex; justify-content: center; margin-bottom: 1.5rem;">
        <div class="qr-code-svg" style="background-color: #ffffff; padding: 1.25rem; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; display: inline-flex; justify-content: center; align-items: center;">
            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(220)->margin(0)->generate($url) !!}
        </div>
    </div>
    
    <p style="font-size: 0.75rem; color: #9ca3af; margin-bottom: 2.5rem; word-break: break-all; max-width: 300px; margin-left: auto; margin-right: auto;">
        {{ $url }}
    </p>
    
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <x-filament::button tag="a" href="{{ $url }}" target="_blank" color="gray" icon="heroicon-o-link">
            Buka Tautan
        </x-filament::button>
        
        <x-filament::button x-on:click="
            const qrSvg = $el.closest('.qr-container').querySelector('.qr-code-svg').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Cetak QR - {{ addslashes($title) }}</title>
                        <style>
                            @page { size: A4 portrait; margin: 0; }
                            body { 
                                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
                                display: flex; flex-direction: column; align-items: center; justify-content: space-between; 
                                height: 100vh; margin: 0; padding: 2cm; box-sizing: border-box; 
                                text-align: center; color: #111827; background-color: #ffffff;
                                overflow: hidden; /* Prevent scrolling/second page */
                            }
                            .header {
                                display: flex; justify-content: space-between; align-items: flex-start; 
                                width: 100%; max-width: 900px;
                            }
                            .header .left { 
                                text-align: left;
                            }
                            .header .left .title {
                                font-size: 2rem; font-weight: 900; letter-spacing: -0.025em; color: #111827;
                                line-height: 1; text-transform: uppercase;
                            }
                            .header .left .subtitle {
                                font-size: 1.1rem; font-weight: 600; color: #6b7280; margin-top: 0.25rem;
                            }
                            .header .right img { height: 90px; object-fit: contain; }
                            
                            .main-content {
                                flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
                                width: 100%; padding: 2rem 0;
                            }
                            h1 { 
                                font-size: 3.5rem; font-weight: 900; margin-bottom: 1rem; line-height: 1.1; 
                                text-transform: uppercase; letter-spacing: -0.025em; max-width: 900px;
                            }
                            p.sub { font-size: 1.5rem; color: #4b5563; font-weight: 500; margin-bottom: 3.5rem; }
                            .qr-container { 
                                padding: 3rem; background: #fff; border: 6px solid #111827; 
                                border-radius: 3rem; display: inline-flex; justify-content: center; align-items: center; 
                            }
                            .qr-container svg { width: 450px !important; height: 450px !important; }
                            
                            .footer {
                                width: 100%; max-width: 900px; border-top: 3px dashed #e5e7eb; 
                                padding-top: 1.5rem; margin-bottom: 1rem;
                            }
                            p.url { font-size: 1.25rem; font-weight: 600; color: #6b7280; margin: 0; word-break: break-all; }
                            
                            @media print { 
                                body { height: 100vh; padding: 1.5cm; } 
                            }
                        </style>
                    </head>
                    <body>
                        <div class='header'>
                            <div class='left'>
                                <div class='title'>DESA TULUSBESAR</div>
                                <div class='subtitle'>Kecamatan Tumpang, Kabupaten Malang</div>
                            </div>
                            <div class='right'>
                                <img src='https://upload.wikimedia.org/wikipedia/commons/d/d9/Logo_Kabupaten_Malang_-_Seal_of_Malang_Regency.svg' alt='Logo Kabupaten Malang'>
                            </div>
                        </div>

                        <div class='main-content'>
                            <h1>{{ addslashes($title) }}</h1>
                            <p class='sub'>Scan QR Code ini untuk informasi lebih detail.</p>
                            <div class='qr-container'>${qrSvg}</div>
                        </div>

                        <div class='footer'>
                            <p class='url'>{{ $url }}</p>
                        </div>

                        <script>
                            window.onload = () => { 
                                setTimeout(() => { 
                                    window.print(); 
                                    window.close(); 
                                }, 300); 
                            };
                        <\/script>
                    </body>
                </html>
            `);
            printWindow.document.close();
        " icon="heroicon-o-printer" color="primary">
            Cetak QR
        </x-filament::button>
    </div>
</div>
