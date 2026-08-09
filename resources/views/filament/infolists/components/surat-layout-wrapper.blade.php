<div class="custom-surat-layout">
    <div class="surat-column-left">
        {{ $getChildComponentContainer()->getComponents()[0] }}
    </div>
    <div class="surat-column-right">
        {{ $getChildComponentContainer()->getComponents()[1] }}
    </div>
</div>

<style>
    .custom-surat-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        align-items: start;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .surat-column-left {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .surat-column-right {
        display: flex;
        flex-direction: column;
        width: 100%;
        min-width: 0;
    }

    @media (min-width: 768px) {
        .custom-surat-layout {
            grid-template-columns: minmax(250px, 0.35fr) minmax(400px, 0.65fr);
        }
    }

    @media (min-width: 1024px) {
        .custom-surat-layout {
            grid-template-columns: minmax(280px, 0.32fr) minmax(600px, 0.68fr);
            gap: 24px;
        }
    }
</style>
