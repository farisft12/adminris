<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrasi;
use App\Models\KodeRekening;
use App\Models\SubKegiatan;
use App\Models\User;
use App\Models\Year;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DataOverviewController extends Controller
{
    public function index(): View
    {
        $activeYear = session('active_year') ?? Year::latest('tahun')->value('tahun') ?? date('Y');

        $stats = [
            'users'          => User::count(),
            'sub_kegiatans'  => SubKegiatan::whereHas('year', fn($q) => $q->where('tahun', $activeYear))->count(),
            'kode_rekenings' => KodeRekening::count(),
            'total_anggaran' => SubKegiatan::whereHas('year', fn($q) => $q->where('tahun', $activeYear))->sum('anggaran'),
            'total_realisasi'=> Administrasi::whereYear('tanggal_nota_persetujuan', $activeYear)->selectRaw('SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) as total')->value('total') ?? 0,
        ];

        // Chart 1: Anggaran vs Realisasi (Top 10)
        $chartAnggaran = SubKegiatan::whereHas('year', fn($q) => $q->where('tahun', $activeYear))
            ->select('sub_kegiatans.*')
            ->selectRaw('(SELECT SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) FROM administrasis WHERE administrasis.sub_kegiatan_id = sub_kegiatans.id) as realisasi')
            ->orderByDesc('anggaran')
            ->limit(10)
            ->get()
            ->map(fn ($sk) => [
                'label' => mb_strlen($sk->nama_sub_kegiatan) > 30
                    ? mb_substr($sk->nama_sub_kegiatan, 0, 30) . '…'
                    : $sk->nama_sub_kegiatan,
                'anggaran'  => (float) $sk->anggaran,
                'terpakai'  => (float) ($sk->realisasi ?? 0),
                'sisa'      => (float) ($sk->anggaran - ($sk->realisasi ?? 0)),
            ]);

        // Chart 2: Realisasi Anggaran per Bulan (Rp)
        $chartBulanan = Administrasi::selectRaw("
                TO_CHAR(tanggal_nota_persetujuan, 'Mon') as label, 
                SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) as value, 
                EXTRACT(MONTH FROM tanggal_nota_persetujuan) as month_num
            ")
            ->whereYear('tanggal_nota_persetujuan', $activeYear)
            ->groupBy('label', 'month_num')
            ->orderBy('month_num')
            ->get();

        // Data Table: Detail per Sub Kegiatan
        $subKegiatanList = SubKegiatan::whereHas('year', fn($q) => $q->where('tahun', $activeYear))
            ->select('sub_kegiatans.*')
            ->selectRaw('(SELECT SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) FROM administrasis WHERE administrasis.sub_kegiatan_id = sub_kegiatans.id) as realisasi')
            ->orderBy('nama_sub_kegiatan')
            ->paginate(15);

        return view('admin.data-overview.index', compact('stats', 'chartAnggaran', 'chartBulanan', 'subKegiatanList', 'activeYear'));
    }
}
