<?php

namespace App\Http\Controllers;

use App\Models\Administrasi;
use App\Models\Npd;
use App\Models\NpdDetail;
use App\Models\SubKegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubKegiatanController extends Controller
{
    public function show(Request $request, SubKegiatan $subKegiatan): View
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }
        $subKegiatan->load('year');
        return view('sub-kegiatan.show', compact('subKegiatan'));
    }

    public function npd(Request $request, SubKegiatan $subKegiatan): View
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }
        $subKegiatan->load(['year', 'kodeRekenings']);
        $kodeRekenings = $subKegiatan->kodeRekenings()->orderBy('kode_rekening')->get();

        $akumulasiPerKode = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');

        $totalAdministrasiPerKode = Administrasi::query()
            ->where('sub_kegiatan_id', $subKegiatan->id)
            ->selectRaw('kode_rekening_id, SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) as total_input')
            ->groupBy('kode_rekening_id')
            ->pluck('total_input', 'kode_rekening_id');

        $npdPerKodeRekening = $kodeRekenings->map(function ($kr) use ($akumulasiPerKode, $totalAdministrasiPerKode, $request) {
            $anggaran = (float) ($kr->pivot->anggaran ?? 0);
            $akumulasi = (float) ($akumulasiPerKode->get($kr->id, 0));
            $totalAdministrasi = (float) ($totalAdministrasiPerKode->get($kr->id, 0));
            $maxPencairan = $totalAdministrasi - $akumulasi;
            if ($maxPencairan < 0) {
                $maxPencairan = 0;
            }
            $pencairanSaatIni = 0;
            if ($request->old("pencairan.{$kr->id}") !== null) {
                $pencairanSaatIni = (float) $request->old("pencairan.{$kr->id}");
            }
            $sisa = $anggaran - $akumulasi - $pencairanSaatIni;
            return [
                'kode_rekening' => $kr->kode_rekening,
                'nama_rekening' => $kr->nama_rekening,
                'kode_rekening_id' => $kr->id,
                'anggaran' => $anggaran,
                'akumulasi' => $akumulasi,
                'total_administrasi' => $totalAdministrasi,
                'max_pencairan' => $maxPencairan,
                'pencairan_saat_ini' => $pencairanSaatIni,
                'sisa' => $sisa,
            ];
        });

        $npds = $subKegiatan->npds()->with('details')->orderByDesc('tanggal')->orderByDesc('id')->get();

        return view('sub-kegiatan.npd', compact('subKegiatan', 'npdPerKodeRekening', 'npds'));
    }

    public function storeNpd(Request $request, SubKegiatan $subKegiatan): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }

        $kodeRekenings = $subKegiatan->kodeRekenings()->pluck('id')->all();
        $rules = [
            'pencairan' => 'nullable|array',
            'pencairan.*' => 'numeric|min:0',
        ];
        $request->validate($rules);

        $pencairan = $request->input('pencairan', []);
        foreach (array_keys($pencairan) as $kodeRekeningId) {
            if (! in_array((int) $kodeRekeningId, $kodeRekenings, true)) {
                abort(422, 'Invalid kode_rekening_id');
            }
        }

        $totalAdministrasiPerKode = Administrasi::query()
            ->where('sub_kegiatan_id', $subKegiatan->id)
            ->selectRaw('kode_rekening_id, SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) as total_input')
            ->groupBy('kode_rekening_id')
            ->pluck('total_input', 'kode_rekening_id');
        $akumulasiPerKode = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');
        foreach ($pencairan as $kodeRekeningId => $jumlah) {
            $totalAdministrasi = (float) ($totalAdministrasiPerKode->get($kodeRekeningId, 0));
            $akumulasi = (float) ($akumulasiPerKode->get($kodeRekeningId, 0));
            $maxPencairan = $totalAdministrasi - $akumulasi;
            if ($maxPencairan < 0) {
                $maxPencairan = 0;
            }
            if ((float) $jumlah > $maxPencairan) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['pencairan.' . $kodeRekeningId => 'Pencairan tidak boleh melebihi total realisasi administrasi (maks. Rp ' . number_format($maxPencairan, 0, ',', '.') . ').']);
            }
        }

        $tahun = $subKegiatan->year?->tahun ?? date('Y');
        $urutan = $subKegiatan->npds()->whereYear('tanggal', $tahun)->count() + 1;
        $nomor = ($subKegiatan->kode_sub ?: 'SK') . '-' . $tahun . '-' . str_pad((string) $urutan, 3, '0', STR_PAD_LEFT);

        $npd = $subKegiatan->npds()->create([
            'nomor' => $nomor,
            'tanggal' => $request->input('tanggal', now()->toDateString()),
        ]);

        foreach ($pencairan as $kodeRekeningId => $jumlah) {
            $jumlah = (float) $jumlah;
            if ($jumlah > 0 && in_array((int) $kodeRekeningId, $kodeRekenings, true)) {
                $npd->details()->create([
                    'kode_rekening_id' => $kodeRekeningId,
                    'jumlah' => $jumlah,
                ]);
            }
        }

        return redirect()->route('sub-kegiatan.npd.show', [$subKegiatan, $npd])
            ->with('success', 'NPD berhasil disimpan.');
    }

    public function showNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): View
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }
        if ($npd->sub_kegiatan_id !== $subKegiatan->id) {
            abort(404);
        }

        $subKegiatan->load(['year', 'kodeRekenings']);
        $npd->load('details');
        $kodeRekenings = $subKegiatan->kodeRekenings()->orderBy('kode_rekening')->get();

        $akumulasiSebelumNpd = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id)->where('id', '!=', $npd->id))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');

        $pencairanNpdIni = $npd->details->pluck('jumlah', 'kode_rekening_id');

        $npdPerKodeRekening = $kodeRekenings->map(function ($kr) use ($akumulasiSebelumNpd, $pencairanNpdIni) {
            $anggaran = (float) ($kr->pivot->anggaran ?? 0);
            $akumulasi = (float) ($akumulasiSebelumNpd->get($kr->id, 0));
            $pencairanSaatIni = (float) ($pencairanNpdIni->get($kr->id, 0));
            $sisa = $anggaran - $akumulasi - $pencairanSaatIni;
            return [
                'kode_rekening' => $kr->kode_rekening,
                'nama_rekening' => $kr->nama_rekening,
                'anggaran' => $anggaran,
                'akumulasi' => $akumulasi,
                'pencairan_saat_ini' => $pencairanSaatIni,
                'sisa' => $sisa,
            ];
        });

        return view('sub-kegiatan.npd-show', compact('subKegiatan', 'npd', 'npdPerKodeRekening'));
    }

    public function printNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): View
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }
        if ($npd->sub_kegiatan_id !== $subKegiatan->id) {
            abort(404);
        }

        $subKegiatan->load(['year', 'kodeRekenings', 'pptk']);
        $npd->load('details');
        $kodeRekenings = $subKegiatan->kodeRekenings()->orderBy('kode_rekening')->get();

        $akumulasiSebelumNpd = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id)->where('id', '!=', $npd->id))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');

        $pencairanNpdIni = $npd->details->pluck('jumlah', 'kode_rekening_id');

        $npdPerKodeRekening = $kodeRekenings->map(function ($kr) use ($akumulasiSebelumNpd, $pencairanNpdIni) {
            $anggaran = (float) ($kr->pivot->anggaran ?? 0);
            $akumulasi = (float) ($akumulasiSebelumNpd->get($kr->id, 0));
            $pencairanSaatIni = (float) ($pencairanNpdIni->get($kr->id, 0));
            $sisa = $anggaran - $akumulasi - $pencairanSaatIni;
            return [
                'kode_rekening' => $kr->kode_rekening,
                'nama_rekening' => $kr->nama_rekening,
                'anggaran' => $anggaran,
                'akumulasi' => $akumulasi,
                'pencairan_saat_ini' => $pencairanSaatIni,
                'sisa' => $sisa,
            ];
        });

        return view('sub-kegiatan.npd-print', compact('subKegiatan', 'npd', 'npdPerKodeRekening'));
    }

    public function editNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): View
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }
        if ($npd->sub_kegiatan_id !== $subKegiatan->id) {
            abort(404);
        }

        $subKegiatan->load(['year', 'kodeRekenings']);
        $npd->load('details');
        $kodeRekenings = $subKegiatan->kodeRekenings()->orderBy('kode_rekening')->get();

        $akumulasiSebelumNpd = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id)->where('id', '!=', $npd->id))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');

        $totalAdministrasiPerKode = Administrasi::query()
            ->where('sub_kegiatan_id', $subKegiatan->id)
            ->selectRaw('kode_rekening_id, SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) as total_input')
            ->groupBy('kode_rekening_id')
            ->pluck('total_input', 'kode_rekening_id');

        $pencairanNpdIni = $npd->details->pluck('jumlah', 'kode_rekening_id');

        $npdPerKodeRekening = $kodeRekenings->map(function ($kr) use ($akumulasiSebelumNpd, $totalAdministrasiPerKode, $pencairanNpdIni, $request) {
            $anggaran = (float) ($kr->pivot->anggaran ?? 0);
            $akumulasi = (float) ($akumulasiSebelumNpd->get($kr->id, 0));
            $totalAdministrasi = (float) ($totalAdministrasiPerKode->get($kr->id, 0));
            $maxPencairan = $totalAdministrasi - $akumulasi;
            if ($maxPencairan < 0) {
                $maxPencairan = 0;
            }
            $pencairanSaatIni = (float) ($pencairanNpdIni->get($kr->id, 0));
            if ($request->old("pencairan.{$kr->id}") !== null) {
                $pencairanSaatIni = (float) $request->old("pencairan.{$kr->id}");
            }
            $sisa = $anggaran - $akumulasi - $pencairanSaatIni;
            return [
                'kode_rekening' => $kr->kode_rekening,
                'nama_rekening' => $kr->nama_rekening,
                'kode_rekening_id' => $kr->id,
                'anggaran' => $anggaran,
                'akumulasi' => $akumulasi,
                'total_administrasi' => $totalAdministrasi,
                'max_pencairan' => $maxPencairan,
                'pencairan_saat_ini' => $pencairanSaatIni,
                'sisa' => $sisa,
            ];
        });

        return view('sub-kegiatan.npd-edit', compact('subKegiatan', 'npd', 'npdPerKodeRekening'));
    }

    public function updateNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }
        if ($npd->sub_kegiatan_id !== $subKegiatan->id) {
            abort(404);
        }

        $kodeRekenings = $subKegiatan->kodeRekenings()->pluck('id')->all();
        $request->validate([
            'pencairan' => 'nullable|array',
            'pencairan.*' => 'numeric|min:0',
        ]);

        $pencairan = $request->input('pencairan', []);
        foreach (array_keys($pencairan) as $kodeRekeningId) {
            if (! in_array((int) $kodeRekeningId, $kodeRekenings, true)) {
                abort(422, 'Invalid kode_rekening_id');
            }
        }

        $totalAdministrasiPerKode = Administrasi::query()
            ->where('sub_kegiatan_id', $subKegiatan->id)
            ->selectRaw('kode_rekening_id, SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) as total_input')
            ->groupBy('kode_rekening_id')
            ->pluck('total_input', 'kode_rekening_id');
        $akumulasiSebelumNpd = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id)->where('id', '!=', $npd->id))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');
        foreach ($pencairan as $kodeRekeningId => $jumlah) {
            $totalAdministrasi = (float) ($totalAdministrasiPerKode->get($kodeRekeningId, 0));
            $akumulasi = (float) ($akumulasiSebelumNpd->get($kodeRekeningId, 0));
            $maxPencairan = $totalAdministrasi - $akumulasi;
            if ($maxPencairan < 0) {
                $maxPencairan = 0;
            }
            if ((float) $jumlah > $maxPencairan) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['pencairan.' . $kodeRekeningId => 'Pencairan tidak boleh melebihi total realisasi administrasi (maks. Rp ' . number_format($maxPencairan, 0, ',', '.') . ').']);
            }
        }

        if ($request->filled('tanggal')) {
            $npd->update(['tanggal' => $request->input('tanggal')]);
        }

        $npd->details()->delete();
        foreach ($pencairan as $kodeRekeningId => $jumlah) {
            $jumlah = (float) $jumlah;
            if ($jumlah > 0 && in_array((int) $kodeRekeningId, $kodeRekenings, true)) {
                $npd->details()->create([
                    'kode_rekening_id' => $kodeRekeningId,
                    'jumlah' => $jumlah,
                ]);
            }
        }

        return redirect()->route('sub-kegiatan.npd.show', [$subKegiatan, $npd])
            ->with('success', 'NPD berhasil diubah.');
    }
}
