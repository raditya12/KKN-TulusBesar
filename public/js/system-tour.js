/**
 * System Tour — Admin Desa Tulusbesar
 * Driver.js loaded via CDN. Status saved per-user via AJAX.
 */
(function () {
    "use strict";

    /* ------ RESOLVE SIDEBAR ITEM BY TEXT ------ */
    function resolveSidebarItem(labelText) {
        var selectors = [".fi-sidebar-nav a", "nav a", "aside a", '[class*="fi-sidebar"] a'];
        for (var s = 0; s < selectors.length; s++) {
            var links = document.querySelectorAll(selectors[s]);
            for (var i = 0; i < links.length; i++) {
                var link = links[i];
                var spans = link.querySelectorAll("span");
                for (var j = 0; j < spans.length; j++) {
                    if (spans[j].textContent.trim() === labelText) { return link; }
                }
                if ((link.textContent || "").replace(/\s+/g, " ").trim() === labelText) { return link; }
            }
        }
        return null;
    }

    /* ------ OPEN SIDEBAR GROUP IF COLLAPSED ------ */
    function ensureSidebarGroupOpen(groupLabel) {
        return new Promise(function (resolve) {
            var candidates = document.querySelectorAll(
                '.fi-sidebar-group-label, [class*="fi-sidebar-group"] button, nav button, aside button'
            );
            for (var i = 0; i < candidates.length; i++) {
                var el = candidates[i];
                var text = (el.textContent || "").replace(/\s+/g, " ").trim();
                if (text === groupLabel) {
                    if (el.getAttribute("aria-expanded") === "false") {
                        el.click();
                        setTimeout(resolve, 350);
                        return;
                    }
                    break;
                }
            }
            resolve();
        });
    }

    /* ------ 14 STEP DEFINITIONS ------ */
    var STEPS_CONFIG = [
        { label: "Dashboard",                key: "dashboard",     group: null,
          title: "🏠 Dashboard",
          description: "Dashboard adalah halaman utama untuk melihat ringkasan informasi sistem secara cepat, seperti jumlah arsip surat dan aktivitas terbaru desa." },
        { label: "Data Penduduk",            key: "data-penduduk", group: "Data Penduduk",
          title: "📋 Data Penduduk",
          description: "Menu ini adalah pusat data penduduk desa. Semua informasi kependudukan yang tersimpan di sistem dapat diakses dari sini." },
        { label: "Data Warga",               key: "data-warga",    group: "Data Penduduk",
          title: "👥 Data Warga",
          description: "Lihat dan kelola informasi setiap warga yang telah terdata. Gunakan fitur pencarian dan filter untuk menemukan data dengan cepat." },
        { label: "Demografi",                key: "demografi",     group: "Data Penduduk",
          title: "📊 Demografi Penduduk",
          description: "Lihat gambaran statistik penduduk desa secara visual: jumlah penduduk, distribusi berdasarkan berbagai kategori, dan statistik penting lainnya." },
        { label: "Jenis Surat",              key: "jenis-surat",   group: "Administrasi Surat",
          title: "📑 Jenis Surat",
          description: "Kelola daftar jenis surat dalam administrasi desa, seperti Surat Kelahiran, Surat Kematian, Surat Keterangan, dan jenis lainnya." },
        { label: "Arsip Surat",              key: "arsip-surat",   group: "Administrasi Surat",
          title: "📂 Arsip Surat",
          description: "Simpan dan cari arsip surat desa secara digital. Setiap arsip memuat nomor surat, nama pemohon, jenis surat, tanggal, dan file dokumen. Arsip digital mengurangi ketergantungan pada penyimpanan dokumen kertas." },
        { label: "Foto Kegiatan",            key: "foto-kegiatan", group: "CMS",
          title: "📸 Foto Kegiatan",
          description: "Kelola dokumentasi foto kegiatan desa yang nantinya ditampilkan pada website resmi Desa Tulusbesar." },
        { label: "Situs Wisata & Budaya",    key: "wisata-budaya", group: "CMS",
          title: "🏛️ Situs Wisata & Budaya",
          description: "Kelola informasi mengenai tempat wisata dan situs budaya yang ada di Desa Tulusbesar untuk dipublikasikan kepada masyarakat." },
        { label: "Data WebGIS",              key: "webgis",        group: "CMS",
          title: "🗺️ Data WebGIS",
          description: "Kelola data lokasi yang ditampilkan pada peta digital desa. Tambahkan titik lokasi beserta informasi lengkap terkait setiap tempat." },
        { label: "Berita Desa",              key: "berita-desa",   group: "CMS",
          title: "📰 Berita Desa",
          description: "Kelola berita dan informasi kegiatan Desa Tulusbesar yang ditampilkan kepada masyarakat melalui website resmi desa." },
        { label: "Data UMKM",                key: "umkm",          group: "CMS",
          title: "🛒 Data UMKM",
          description: "Kelola informasi usaha mikro, kecil, dan menengah (UMKM) yang ada di desa agar dapat dikenal masyarakat lebih luas." },
        { label: "Repositori Dokumen Publik",key: "repositori",    group: "CMS",
          title: "📚 Repositori Dokumen Publik",
          description: "Kelola dokumen desa yang dapat diunduh oleh masyarakat. Berbeda dengan Arsip Surat yang bersifat internal, menu ini khusus untuk dokumen yang diperuntukkan bagi publik." },
        { label: "Perangkat Desa",           key: "perangkat-desa",group: "CMS",
          title: "👔 Perangkat Desa",
          description: "Kelola informasi struktur dan data perangkat Desa Tulusbesar yang ditampilkan pada sistem dan website desa." },
        { label: "Data Profil Desa",         key: "profil-desa",   group: "CMS",
          title: "🏡 Data Profil Desa",
          description: "Kelola informasi profil lengkap Desa Tulusbesar, mulai dari sejarah, visi-misi, hingga data umum desa untuk sistem dan website resmi." },
    ];

    /* ------ BUILD STEPS ------ */
    function buildSteps() {
        var steps = [];
        for (var i = 0; i < STEPS_CONFIG.length; i++) {
            var cfg = STEPS_CONFIG[i];
            var el = resolveSidebarItem(cfg.label);
            var step = { popover: { title: cfg.title, description: cfg.description, side: "right", align: "start" } };
            if (el) {
                el.setAttribute("data-tour", cfg.key);
                step.element = '[data-tour="' + cfg.key + '"]';
            }
            steps.push(step);
        }
        return steps;
    }

    /* ------ AJAX STATUS HELPERS ------ */
    function getCsrf() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute("content") : "";
    }

    function postTourStatus(endpoint) {
        return fetch(endpoint, {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": getCsrf(), "Accept": "application/json" },
            body: JSON.stringify({}),
        }).catch(function () { /* silently fail */ });
    }

    function markTourCompleted() {
        postTourStatus("/admin/tour/complete");
        window.dispatchEvent(new CustomEvent("tour-status-changed", { detail: { completed: true } }));
    }

    window.resetSystemTour = function () {
        postTourStatus("/admin/tour/reset").then(function () {
            window.dispatchEvent(new CustomEvent("tour-status-changed", { detail: { completed: false } }));
        });
    };

    /* ------ COMPLETION MODAL ------ */
    function showCompletionModal() {
        var existing = document.getElementById("tour-completion-overlay");
        if (existing) { existing.remove(); }

        var overlay = document.createElement("div");
        overlay.id = "tour-completion-overlay";
        overlay.style.cssText = "position:fixed;inset:0;z-index:100000;display:flex;align-items:center;justify-content:center;background:rgba(15,23,42,0.65);backdrop-filter:blur(6px);animation:tourFadeIn .3s ease";
        overlay.innerHTML =
            '<div style="background:#fff;border-radius:1.25rem;padding:2.5rem;max-width:440px;width:90%;text-align:center;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);animation:tourSlideUp .4s ease">'
            + '<div style="font-size:3.5rem;margin-bottom:.75rem">🎉</div>'
            + '<h2 style="font-size:1.4rem;font-weight:800;color:#1c1917;margin:0 0 .5rem">Panduan Selesai!</h2>'
            + '<p style="font-size:.9rem;color:#64748b;line-height:1.7;margin:0 0 .5rem">Anda sudah mengenal menu utama Sistem Desa Tulusbesar.</p>'
            + '<p style="font-size:.9rem;color:#64748b;line-height:1.7;margin:0 0 1.75rem">Anda sekarang dapat mulai menggunakan sistem untuk mengelola data penduduk, administrasi surat, arsip, informasi desa, dan konten publik.</p>'
            + '<button id="tour-completion-btn" style="display:inline-flex;align-items:center;gap:.5rem;padding:.8rem 2rem;border-radius:.75rem;background:linear-gradient(135deg,#8C5A35 0%,#4A2B1D 100%);color:#fff;font-size:.95rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(140,90,53,.4)">🚀 Mulai Menggunakan Sistem</button>'
            + '</div>';
        document.body.appendChild(overlay);

        document.getElementById("tour-completion-btn").addEventListener("click", function () {
            overlay.remove();
            window.dispatchEvent(new CustomEvent("tour-status-changed", { detail: { completed: true } }));
        });
    }

    /* ------ OPEN ALL SIDEBAR GROUPS ------ */
    function openAllGroups() {
        var groups = ["Data Penduduk", "Administrasi Surat", "CMS"];
        return groups.reduce(function (p, g) {
            return p.then(function () { return ensureSidebarGroupOpen(g); });
        }, Promise.resolve());
    }

    /* ------ START TOUR ------ */
    window.startSystemTour = function () {
        if (typeof window.driver === "undefined" || !window.driver.js || !window.driver.js.driver) {
            alert("Komponen panduan belum siap. Coba muat ulang halaman terlebih dahulu.");
            return;
        }
        var driverFn = window.driver.js.driver;

        openAllGroups().then(function () {
            setTimeout(function () {
                var steps = buildSteps();
                var tourDriver = driverFn({
                    showProgress: true,
                    animate: true,
                    smoothScroll: true,
                    allowClose: true,
                    overlayColor: "rgba(15,23,42,0.72)",
                    stagePadding: 10,
                    stageRadius: 10,
                    popoverClass: "tulusbesar-tour-popover",
                    nextBtnText: "Berikutnya &#8594;",
                    prevBtnText: "&#8592; Kembali",
                    doneBtnText: "Selesai &#10003;",
                    progressText: "Langkah {{current}} dari {{total}}",
                    steps: steps,
                    onDestroyStarted: function () {
                        var isLast = !tourDriver.hasNextStep();
                        markTourCompleted();
                        tourDriver.destroy();
                        if (isLast) { showCompletionModal(); }
                    },
                });
                tourDriver.drive();
            }, 400);
        });
    };

    /* ------ INJECT STYLES ------ */
    function injectStyles() {
        if (document.getElementById("tulusbesar-tour-styles")) { return; }
        var style = document.createElement("style");
        style.id = "tulusbesar-tour-styles";
        style.textContent =
            "@keyframes tourFadeIn{from{opacity:0}to{opacity:1}}"
            + "@keyframes tourSlideUp{from{opacity:0;transform:translateY(20px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}"
            + ".tulusbesar-tour-popover{border-radius:1rem!important;box-shadow:0 20px 40px -8px rgba(0,0,0,.22)!important;font-family:Outfit,sans-serif!important}"
            + ".tulusbesar-tour-popover .driver-popover-title{font-size:1rem!important;font-weight:700!important;color:#1c1917!important;margin-bottom:.4rem!important}"
            + ".tulusbesar-tour-popover .driver-popover-description{font-size:.875rem!important;color:#57534e!important;line-height:1.6!important}"
            + ".tulusbesar-tour-popover .driver-popover-progress-text{font-size:.75rem!important;color:#a8a29e!important}"
            + ".tulusbesar-tour-popover .driver-popover-footer button{border-radius:.5rem!important;font-weight:600!important;font-size:.82rem!important;padding:.45rem 1rem!important;text-shadow:none!important;border:none!important;cursor:pointer!important}"
            + ".tulusbesar-tour-popover .driver-popover-next-btn{background:linear-gradient(135deg,#8C5A35 0%,#4A2B1D 100%)!important;color:#fff!important}"
            + ".tulusbesar-tour-popover .driver-popover-prev-btn{background:#f5f5f4!important;color:#44403c!important}"
            + ".tulusbesar-tour-popover .driver-popover-close-btn{color:#a8a29e!important;font-size:1.2rem!important}";
        document.head.appendChild(style);
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", injectStyles);
    } else {
        injectStyles();
    }
})();
