<style>
    /* Custom Javanese Earthy Theme for Filament */
    body {
        background-color: #fcf9f5 !important;
        background-image: url('{{ asset("images/dummy/hero.jpg") }}') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
    }
    
    /* Darken the background to make content readable */
    body::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(250, 245, 240, 0.85); /* light earthy overlay */
        z-index: -1;
    }

    .dark body::before {
        background: rgba(30, 20, 15, 0.9); /* dark earthy overlay */
    }

    /* Glassmorphism for Filament panels and topbar */
    .fi-main {
        background: transparent !important;
    }

    .fi-topbar {
        background: rgba(255, 255, 255, 0.6) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border-bottom: 1px solid rgba(140, 90, 53, 0.2) !important;
    }
    
    .dark .fi-topbar {
        background: rgba(30, 20, 15, 0.7) !important;
        border-bottom: 1px solid rgba(140, 90, 53, 0.3) !important;
    }

    /* Content Cards Glassmorphism */
    .fi-ta-content, .fi-fo-content, .fi-section, .fi-wi-stats-overview-stat {
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(140, 90, 53, 0.2) !important;
        border-radius: 1rem !important;
        box-shadow: 0 10px 30px -10px rgba(74, 43, 29, 0.1) !important;
    }
    
    .dark .fi-ta-content, .dark .fi-fo-content, .dark .fi-section, .dark .fi-wi-stats-overview-stat {
        background: rgba(40, 30, 25, 0.8) !important;
        border: 1px solid rgba(140, 90, 53, 0.3) !important;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important;
    }

    /* Primary buttons gradient */
    .fi-btn-primary {
        background: linear-gradient(135deg, #8C5A35 0%, #4A2B1D 100%) !important;
        border: none !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
    }
    .fi-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(74, 43, 29, 0.3) !important;
    }
</style>
