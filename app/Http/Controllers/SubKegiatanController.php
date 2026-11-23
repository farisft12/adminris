<?php

namespace App\Http\Controllers;

use App\Models\Npd;
use App\Models\NpdDetail;
use App\Models\SubKegiatan;
use App\Services\NpdService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SubKegiatanController extends Controller
{
    public function __construct(private readonly NpdService $npdService)
    {
    }

    public function show(Request $request, SubKegiatan $subKegiatan): View
    {
        $subKegiatan->load('year');
        return view('sub-kegiatan.show', compact('subKegiatan'));
    }

    public function npd(Request $request, SubKegiatan $subKegiatan): View
    {
        $subKegiatan->load('year');

        return view('sub-kegiatan.npd', [
            'subKegiatan' => $subKegiatan,
            'npdPerKodeRekening' => $this->rekeningSummary($subKegiatan),
            'administrasis' => $this->npdService->availableAdministrasis($subKegiatan),
            'selectedIds' => array_map('intval', (array) $request->old('administrasi_ids', [])),
            'npds' => $subKegiatan->npds()->orderByDesc('tanggal')->orderByDesc('id')->get(),
        ]);
    }

    public function storeNpd(Request $request, SubKegiatan $subKegiatan): RedirectResponse
    {
        $data = $this->validateNpd($request);

        $npd = DB::transaction(function () use ($subKegiatan, $data) {
            $tahun = $subKegiatan->year?->tahun ?? date('Y');
            $urutan = $subKegiatan->npds()->whereYear('tanggal', $tahun)->count() + 1;

            $npd = $subKegiatan->npds()->create([
                'nomor' => ($subKegiatan->kode_sub ?: 'SK') . '-' . $tahun . '-' . str_pad((string) $urutan, 3, '0', STR_PAD_LEFT),
                'tanggal' => $data['tanggal'],
            ]);
            $this->npdService->sync($npd, $data['administrasi_ids']);

            return $npd;
        });

        return redirect()->route('sub-kegiatan.npd.show', [$subKegiatan, $npd])
            ->with('success', 'NPD berhasil disimpan.');
    }

    public function showNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): View
    {
        $this->ensureBelongs($subKegiatan, $npd);
        $document = $this->npdService->document($npd);

        return view('sub-kegiatan.npd-show', [
            'subKegiatan' => $subKegiatan,
            'npd' => $npd,
            'npdPerKodeRekening' => $document['rows']->map(fn ($row) => $row + ['pencairan_saat_ini' => $row['pencairan']]),
            'administrasis' => $npd->administrasis,
        ]);
    }

    public function printNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): View
    {
        $this->ensureBelongs($subKegiatan, $npd);

        return view('sub-kegiatan.npd-print', $this->npdService->document($npd));
    }

    public function editNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): View
    {
        $this->ensureBelongs($subKegiatan, $npd);
        $subKegiatan->load('year');

        $selected = $request->old('administrasi_ids') !== null
            ? array_map('intval', (array) $request->old('administrasi_ids'))
            : $npd->administrasis()->pluck('id')->all();

        return view('sub-kegiatan.npd-edit', [
            'subKegiatan' => $subKegiatan,
            'npd' => $npd,
            'npdPerKodeRekening' => $this->rekeningSummary($subKegiatan, $npd),
            'administrasis' => $this->npdService->availableAdministrasis($subKegiatan, $npd),
            'selectedIds' => $selected,
        ]);
    }

    public function updateNpd(Request $request, SubKegiatan $subKegiatan, Npd $npd): RedirectResponse
    {
        $this->ensureBelongs($subKegiatan, $npd);
        $data = $this->validateNpd($request);

        DB::transaction(function () use ($npd, $data) {
            $npd->update(['tanggal' => $data['tanggal']]);
            $this->npdService->sync($npd, $data['administrasi_ids']);
        });

        return redirect()->route('sub-kegiatan.npd.show', [$subKegiatan, $npd])
            ->with('success', 'NPD berhasil diubah.');
    }

    private function validateNpd(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],
            'administrasi_ids' => ['required', 'array', 'min:1'],
            'administrasi_ids.*' => ['integer'],
        ], [
            'administrasi_ids.required' => 'Pilih minimal satu administrasi yang akan dicairkan.',
        ]);
    }

    private function ensureBelongs(SubKegiatan $subKegiatan, Npd $npd): void
    {
        if ($npd->sub_kegiatan_id !== $subKegiatan->id) {
            abort(404);
        }
    }

    /** Anggaran & akumulasi NPD lain per kode rekening, untuk ringkasan di form. */
    private function rekeningSummary(SubKegiatan $subKegiatan, ?Npd $except = null): Collection
    {
        $akumulasi = NpdDetail::query()
            ->whereHas('npd', fn ($q) => $q->where('sub_kegiatan_id', $subKegiatan->id)
                ->when($except, fn ($q) => $q->where('id', '!=', $except->id)))
            ->selectRaw('kode_rekening_id, SUM(jumlah) as total')
            ->groupBy('kode_rekening_id')
            ->pluck('total', 'kode_rekening_id');

        return $subKegiatan->kodeRekenings()->orderBy('kode_rekening')->get()
            ->map(fn ($kr) => [
                'kode_rekening_id' => $kr->id,
                'kode_rekening' => $kr->kode_rekening,
                'nama_rekening' => $kr->nama_rekening,
                'anggaran' => (float) ($kr->pivot->anggaran ?? 0),
                'akumulasi' => (float) $akumulasi->get($kr->id, 0),
            ]);
    }
}
