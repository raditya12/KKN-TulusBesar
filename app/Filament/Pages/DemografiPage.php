<?php

namespace App\Filament\Pages;

use App\Models\Family;
use App\Models\FamilyMember;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class DemografiPage extends Page
{
    protected static ?string $navigationLabel = 'Demografi';

    protected static UnitEnum|string|null $navigationGroup = 'Data Penduduk';

    protected string $view = 'filament.pages.demografi-page';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?int $navigationSort = 2;

    public function getTitle(): string|Htmlable
    {
        return 'Demografi Desa Tulusbesar';
    }

    public function getSubheading(): ?string
    {
        return 'Visualisasi data demografis penduduk Desa Tulusbesar.';
    }

    protected function getViewData(): array
    {
        // ── Stats Utama ───────────────────────────────────────────
        $totalPenduduk = FamilyMember::count();
        $totalKK = FamilyMember::where('nomor_anggota', 0)->count();
        $lakiLaki = FamilyMember::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan = FamilyMember::where('jenis_kelamin', 'Perempuan')->count();

        // ── Jenis Kelamin ────────────────────────────────────────
        $byJenisKelamin = FamilyMember::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->whereNotNull('jenis_kelamin')
            ->groupBy('jenis_kelamin')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->jenis_kelamin => $r->total]);

        // ── Kelompok Umur (calculated via DB) ───────────────────
        $byKelompokUmur = collect([
            '0–5 tahun' => FamilyMember::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 0 AND 5')->count(),
            '6–12 tahun' => FamilyMember::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 6 AND 12')->count(),
            '13–17 tahun' => FamilyMember::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 17')->count(),
            '18–25 tahun' => FamilyMember::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 25')->count(),
            '26–40 tahun' => FamilyMember::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 26 AND 40')->count(),
            '41–60 tahun' => FamilyMember::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 41 AND 60')->count(),
            '61+ tahun' => FamilyMember::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) >= 61')->count(),
            'Tidak Diketahui' => FamilyMember::whereNull('tanggal_lahir')->count(),
        ])->filter(fn ($v) => $v > 0);

        // ── Per Dusun (Single aggregated query) ─────────────────
        $wargaPerDusun = DB::table('family_members')
            ->join('families', 'family_members.family_id', '=', 'families.id')
            ->select('families.dusun', DB::raw('count(*) as total_warga'))
            ->whereNotNull('families.dusun')
            ->groupBy('families.dusun')
            ->pluck('total_warga', 'dusun');

        $byDusun = Family::select('dusun', DB::raw('count(*) as total_kk'))
            ->whereNotNull('dusun')
            ->groupBy('dusun')
            ->orderByDesc('total_kk')
            ->get()
            ->map(fn ($r) => [
                'dusun'       => $r->dusun,
                'total_kk'    => $r->total_kk,
                'total_warga' => $wargaPerDusun->get($r->dusun, 0),
            ]);

        // ── Per RW (Single aggregated query) ────────────────────
        $wargaPerRw = DB::table('family_members')
            ->join('families', 'family_members.family_id', '=', 'families.id')
            ->select('families.rw', DB::raw('count(*) as total_warga'))
            ->whereNotNull('families.rw')
            ->groupBy('families.rw')
            ->pluck('total_warga', 'rw');

        $byRw = Family::select('rw', DB::raw('count(*) as total_kk'))
            ->whereNotNull('rw')
            ->groupBy('rw')
            ->orderBy('rw')
            ->get()
            ->map(fn ($r) => [
                'rw'          => $r->rw,
                'total_kk'    => $r->total_kk,
                'total_warga' => $wargaPerRw->get($r->rw, 0),
            ]);

        // ── Agama ────────────────────────────────────────────────
        $byAgama = FamilyMember::select('agama', DB::raw('count(*) as total'))
            ->whereNotNull('agama')
            ->where('agama', '!=', '')
            ->groupBy('agama')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->agama => $r->total]);

        // ── Pendidikan ───────────────────────────────────────────
        $byPendidikan = FamilyMember::select('pendidikan_terakhir', DB::raw('count(*) as total'))
            ->whereNotNull('pendidikan_terakhir')
            ->where('pendidikan_terakhir', '!=', '')
            ->groupBy('pendidikan_terakhir')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->pendidikan_terakhir => $r->total]);

        // ── Pekerjaan ────────────────────────────────────────────
        $byPekerjaan = FamilyMember::select('jenis_pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('jenis_pekerjaan')
            ->where('jenis_pekerjaan', '!=', '')
            ->groupBy('jenis_pekerjaan')
            ->orderByDesc('total')
            ->get()
            ->mapWithKeys(fn ($r) => [$r->jenis_pekerjaan => $r->total]);

        // ── Distribusi Jumlah Anggota KK ────────────────────────
        $byJumlahAnggota = Family::withCount(['members as jumlah_anggota'])
            ->get()
            ->groupBy('jumlah_anggota')
            ->map(fn ($group, $key) => $group->count())
            ->sortKeys()
            ->mapWithKeys(fn ($v, $k) => ["{$k} anggota" => $v]);

        return compact(
            'totalPenduduk',
            'totalKK',
            'lakiLaki',
            'perempuan',
            'byJenisKelamin',
            'byKelompokUmur',
            'byDusun',
            'byRw',
            'byAgama',
            'byPendidikan',
            'byPekerjaan',
            'byJumlahAnggota'
        );
    }
}
