<style>
    /* Custom Javanese Earthy Theme for Filament */
    body {
        background-color: #fcf9f5 !important;
        background-image: url('{{ asset("images/hero-bg.jpg") }}') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
    }
    
    /* Earthy overlay - lighter to not obscure content */
    body::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(250, 245, 240, 0.88);
        z-index: -1;
    }

    .dark body::before {
        background: rgba(20, 12, 8, 0.92);
    }

    /* Main content area - transparent, NO overflow restrictions */
    .fi-main {
        background: transparent !important;
    }

    /* Top navigation bar */
    .fi-topbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid rgba(140, 90, 53, 0.2) !important;
    }
    
    .dark .fi-topbar {
        background: rgba(30, 20, 15, 0.95) !important;
        backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid rgba(140, 90, 53, 0.3) !important;
    }

    /* Content Cards - glassmorphism, allow overflow for forms */
    .fi-ta-content,
    .fi-section,
    .fi-wi-stats-overview-stat {
        background: rgba(255, 255, 255, 0.92) !important;
        border: 1px solid rgba(140, 90, 53, 0.15) !important;
        border-radius: 1rem !important;
        box-shadow: 0 8px 24px -8px rgba(74, 43, 29, 0.12) !important;
    }

    /* Form content - IMPORTANT: allow full width & no height restrictions */
    .fi-fo-content {
        background: rgba(255, 255, 255, 0.92) !important;
        border: 1px solid rgba(140, 90, 53, 0.15) !important;
        border-radius: 1rem !important;
        box-shadow: 0 8px 24px -8px rgba(74, 43, 29, 0.12) !important;
        overflow: visible !important;
        min-height: auto !important;
    }

    .dark .fi-ta-content,
    .dark .fi-fo-content,
    .dark .fi-section,
    .dark .fi-wi-stats-overview-stat {
        background: rgba(35, 22, 15, 0.85) !important;
        border: 1px solid rgba(140, 90, 53, 0.3) !important;
        box-shadow: 0 8px 24px -8px rgba(0, 0, 0, 0.5) !important;
    }

    /* Full width for page wrapper */
    .fi-page {
        width: 100% !important;
        max-width: 100% !important;
    }

    /* Ensure form grids are fully responsive */
    .fi-fo-grid {
        width: 100% !important;
    }

    /* Primary buttons */
    .fi-btn-primary {
        background: linear-gradient(135deg, #8C5A35 0%, #4A2B1D 100%) !important;
        border: none !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
    }
    .fi-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(74, 43, 29, 0.3) !important;
    }

    /* Rich editor toolbar should be visible */
    .trix-toolbar {
        background: rgba(255, 255, 255, 0.98) !important;
        border: 1px solid rgba(140, 90, 53, 0.2) !important;
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 0.5rem !important;
    }

    /* Fix ImageColumn in card grid - ensure images fill the card top */
    .fi-ta-col-wrp:has(img) {
        padding: 0 !important;
    }
    .fi-ta-col-wrp img {
        width: 100% !important;
        height: 200px !important;
        object-fit: cover !important;
        border-radius: 0.75rem 0.75rem 0 0 !important;
        display: block !important;
    }
    /* Card container styling */
    [class*="fi-ta-record"] {
        border-radius: 0.75rem !important;
        overflow: hidden !important;
        border: 1px solid rgba(140, 90, 53, 0.12) !important;
        box-shadow: 0 2px 8px rgba(74, 43, 29, 0.08) !important;
        transition: box-shadow 0.2s, transform 0.2s !important;
    }
    [class*="fi-ta-record"]:hover {
        box-shadow: 0 8px 24px rgba(74, 43, 29, 0.15) !important;
        transform: translateY(-2px) !important;
    }
</style>
