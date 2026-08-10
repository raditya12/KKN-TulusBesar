<style>
    /*
     * ================================================================
     * SCOPED CSS — Halaman Buat / Edit Template Surat
     * Target: .ts-form-grid (extraAttributes pada Grid component)
     * Tidak memengaruhi halaman Filament lainnya.
     * ================================================================
     */

    /*
     * Filament v5 menggunakan CSS custom properties untuk grid:
     *   --cols-{breakpoint}: repeat(N, minmax(0, 1fr))
     * Grid 2 kolom menghasilkan split 50/50 secara default.
     * Kita override agar proporsi 38% / 62% (kiri / kanan).
     *
     * .ts-form-grid adalah div yang di-render Grid::toEmbeddedHtml()
     * yang kemudian berisi child schema (.fi-sc.fi-grid.fi-grid-cols).
     */

    /* ── Override proporsi kolom pada grid child schema ── */
    @media (min-width: 1024px) {
        .ts-form-grid > .fi-sc {
            /* Override CSS custom property grid columns untuk 38% / 62% */
            --cols-lg: minmax(0, 0.62fr) minmax(0, 1fr) !important;
            column-gap: 1.5rem !important;
            row-gap: 0.5rem !important;
            align-items: start !important;
        }
    }

    /* ── Preview Section: flex column agar konten bisa mengisi tinggi ── */
    .ts-preview-section {
        display: flex;
        flex-direction: column;
    }

    /* Paksa internal Filament Section untuk stretch */
    .ts-preview-section > div,
    .ts-preview-section .fi-section-content-ctn,
    .ts-preview-section .fi-section-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    /* ── iframe wrapper — area utama preview ── */
    .ts-preview-frame-wrapper {
        position: relative;
        width: 100%;
        min-height: 550px;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #d1d5db;
        background: #e5e7eb;
    }

    @media (min-width: 1024px) {
        .ts-preview-frame-wrapper {
            min-height: calc(100vh - 14rem);
        }
    }

    .ts-preview-frame-wrapper iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    /* ── Thin scrollbar utility ── */
    .ts-scroll::-webkit-scrollbar         { width: 4px; }
    .ts-scroll::-webkit-scrollbar-track   { background: transparent; }
    .ts-scroll::-webkit-scrollbar-thumb   { background: #d1d5db; border-radius: 4px; }
    .ts-scroll::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
</style>
