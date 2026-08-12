<?php

namespace App\Filament\Pages;

use App\Models\FamilyMember;
use App\Models\SyncLog;
use App\Services\GoogleSheetsService;
use App\Services\PendudukSyncService;
use BackedEnum;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Log;
use UnitEnum;

class DataPendudukPage extends Page
{
    protected static ?string $navigationLabel = 'Data Penduduk';

    protected static UnitEnum|string|null $navigationGroup = 'Data Penduduk';

    protected string $view = 'filament.pages.data-penduduk-page';

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 0;

    public ?array $syncResult = null;

    public bool $isSyncing = false;

    public function getTitle(): string|Htmlable
    {
        return 'Data Penduduk';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola dan pantau data penduduk Desa Tulusbesar.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('tarik_data')
                ->label('↻ Tarik Data')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Tarik Data dari Google Sheets?')
                ->modalDescription('Data terbaru dari Google Sheets akan disinkronkan ke sistem. Proses ini mungkin memerlukan beberapa saat.')
                ->modalSubmitActionLabel('Tarik Data')
                ->modalCancelActionLabel('Batal')
                ->action(fn () => $this->tarikData()),
        ];
    }

    public function tarikData(): void
    {
        try {
            $sheetsService = new GoogleSheetsService;
            $syncService = new PendudukSyncService;

            $structuredData = $sheetsService->fetchStructuredData();

            if (empty($structuredData['rows'])) {
                Notification::make()
                    ->title('Tidak ada data baru dari Google Sheets.')
                    ->warning()
                    ->send();

                return;
            }

            $result = $syncService->sync($structuredData);

            $this->syncResult = $result;

            // Cek jika ada peringatan validasi (kolom extra/missing non-kritis)
            $validation = $structuredData['validation'] ?? [];
            $extraCols = $validation['extra'] ?? [];

            $body = implode("\n", [
                "• Data keluarga baru: {$result['families_inserted']}",
                "• Data keluarga diperbarui: {$result['families_updated']}",
                "• Data anggota baru: {$result['members_inserted']}",
                "• Data anggota diperbarui: {$result['members_updated']}",
                "• Dilewati: {$result['rows_skipped']}",
                "• Error: {$result['error_count']}",
            ]);

            if ($result['error_count'] > 0) {
                Notification::make()
                    ->title("Sinkronisasi selesai dengan {$result['error_count']} error")
                    ->body($body)
                    ->warning()
                    ->persistent()
                    ->send();
            } else {
                Notification::make()
                    ->title('Sinkronisasi berhasil!')
                    ->body($body)
                    ->success()
                    ->send();
            }

        } catch (Exception $e) {
            Log::error('DataPendudukPage tarikData error', ['error' => $e->getMessage()]);

            Notification::make()
                ->title('Gagal mengambil data')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    protected function getViewData(): array
    {
        $lastSync = SyncLog::orderByDesc('synced_at')->first();

        $totalPenduduk = FamilyMember::count();
        $totalKK = FamilyMember::where('nomor_anggota', 0)->count();
        $lakiLaki = FamilyMember::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = FamilyMember::where('jenis_kelamin', 'Perempuan')->count();

        return [
            'lastSync' => $lastSync,
            'totalPenduduk' => $totalPenduduk,
            'totalKK' => $totalKK,
            'lakiLaki' => $lakiLaki,
            'perempuan' => $perempuan,
            'syncResult' => $this->syncResult,
        ];
    }
}
