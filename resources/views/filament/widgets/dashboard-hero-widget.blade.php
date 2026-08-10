<x-filament-widgets::widget>
    <style>
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .hero-card {
            position: relative;
            overflow: hidden;
            border-radius: 1.25rem;
            background: linear-gradient(135deg, #6b3a1f 0%, #8C5A35 45%, #b07240 80%, #c9894f 100%);
            padding: 2rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            box-shadow: 0 8px 32px rgba(140, 90, 53, 0.35), 0 2px 8px rgba(0,0,0,0.15);
            animation: fadeSlideUp 0.4s ease both;
        }
        .hero-card::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            pointer-events: none;
        }
        .hero-card::after {
            content: '';
            position: absolute;
            bottom: -80px; left: 30%;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }
        .hero-dots {
            position: absolute;
            top: 1rem; left: 1rem;
            width: 120px; height: 120px;
            background-image: radial-gradient(circle, rgba(255,255,255,0.12) 1.5px, transparent 1.5px);
            background-size: 14px 14px;
            pointer-events: none;
        }
        .hero-left { position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 9999px;
            padding: 0.3rem 0.875rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            margin-bottom: 0.875rem;
            backdrop-filter: blur(4px);
            letter-spacing: 0.02em;
        }
        .hero-greeting {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin: 0 0 0.5rem;
            letter-spacing: -0.02em;
        }
        .hero-subtitle {
            font-size: 0.925rem;
            color: rgba(255,255,255,0.75);
            margin: 0;
            font-weight: 400;
        }
        .hero-right {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 1rem;
            flex-shrink: 0;
        }
        .hero-clock {
            text-align: right;
        }
        .hero-time {
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1;
            letter-spacing: -0.03em;
            font-variant-numeric: tabular-nums;
        }
        .hero-date {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.65);
            margin-top: 0.25rem;
            font-weight: 500;
        }
        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.375rem;
            background: rgba(255,255,255,0.95);
            color: #7a4d28;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            letter-spacing: 0.01em;
        }
        .hero-btn:hover {
            background: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.18);
        }
        .hero-btn svg {
            width: 1rem; height: 1rem;
        }
        @media (max-width: 640px) {
            .hero-card { flex-direction: column; align-items: flex-start; padding: 1.5rem; }
            .hero-right { align-items: flex-start; }
            .hero-clock { text-align: left; }
            .hero-time { font-size: 2rem; }
        }
    </style>

    <div class="hero-card">
        <div class="hero-dots"></div>

        <div class="hero-left">
            <div class="hero-badge">
                <span>{{ $icon }}</span>
                <span>Panel Admin Desa Tulusbesar</span>
            </div>
            <h1 class="hero-greeting">{{ $salam }}, Admin!</h1>
            <p class="hero-subtitle">Pusat kendali administrasi dan sistem informasi Desa Tulusbesar.</p>
        </div>

        <div class="hero-right">
            <div class="hero-clock">
                <div class="hero-time" id="hero-live-clock">{{ $waktu }}</div>
                <div class="hero-date">{{ $tanggal }}</div>
            </div>
            <a href="{{ \App\Filament\Pages\PembuatanSuratPage::getUrl() }}" class="hero-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Buat Surat
            </a>
        </div>
    </div>

    <script>
        (function() {
            function updateClock() {
                const el = document.getElementById('hero-live-clock');
                if (!el) return;
                const now = new Date();
                const h = String(now.getHours()).padStart(2, '0');
                const m = String(now.getMinutes()).padStart(2, '0');
                el.textContent = h + ':' + m;
            }
            updateClock();
            setInterval(updateClock, 10000);
        })();
    </script>
</x-filament-widgets::widget>
