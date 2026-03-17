<?php

namespace App\Http\Controllers;

use App\Models\Administrasi;
use App\Models\Etalase;
use App\Models\KodeRekening;
use App\Models\SubKegiatan;
use App\Models\Year;
use App\Repositories\AdministrasiRepository;
use App\Http\Requests\StoreAdministrasiRequest;
use App\Http\Requests\UpdateAdministrasiRequest;
use App\Services\PajakService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdministrasiController extends Controller
{
    public function __construct(
        protected AdministrasiRepository $repository,
        protected PajakService $pajakService
    ) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Administrasi::class);
        $yearId = $request->integer('year_id') ?: null;
        $subKegiatanId = $request->integer('sub_kegiatan_id') ?: null;
        $administrasis = $this->repository->paginateWithFilters(
            $yearId,
            $subKegiatanId,
            $request->integer('kode_rekening_id') ?: null,
            15
        );
        $rekap = $this->repository->getRekapForPaginator($administrasis);
        $years = Year::orderByDesc('tahun')->get();
        $subKegiatans = $yearId
            ? SubKegiatan::where('year_id', $yearId)->orderBy('nama_sub_kegiatan')->get()
            : collect();
        $kodeRekenings = KodeRekening::orderBy('kode_rekening')->get();
        $selectedSubKegiatan = $subKegiatanId ? SubKegiatan::find($subKegiatanId) : null;

        return view('administrasi.index', compact('administrasis', 'rekap', 'years', 'subKegiatans', 'kodeRekenings', 'selectedSubKegiatan'));
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', Administrasi::class);
        $years = Year::orderByDesc('tahun')->get();
        $yearId = $request->integer('year_id');
        $subKegiatans = $yearId
            ? SubKegiatan::with('year')->where('year_id', $yearId)->orderBy('nama_sub_kegiatan')->get()
            : SubKegiatan::with('year')->orderBy('nama_sub_kegiatan')->get();
        $kodeRekenings = KodeRekening::orderBy('kode_rekening')->get();
        $etalases = collect();
        $nextNo = 1;
        $selectedSubKegiatanId = $request->integer('sub_kegiatan_id');
        $selectedKodeRekeningId = $request->integer('kode_rekening_id') ?: null;
        if ($selectedSubKegiatanId) {
            $nextNo = $this->repository->getNextNoForSubKegiatan($selectedSubKegiatanId);
        }
        return view('administrasi.create', compact('years', 'subKegiatans', 'kodeRekenings', 'etalases', 'nextNo', 'selectedSubKegiatanId', 'selectedKodeRekeningId', 'yearId'));
    }

    public function store(StoreAdministrasiRequest $request): RedirectResponse
    {
        Gate::authorize('create', Administrasi::class);
        $no = $this->repository->getNextNoForSubKegiatan($request->sub_kegiatan_id);
        Administrasi::create([
            'sub_kegiatan_id' => $request->sub_kegiatan_id,
            'no' => $no,
            'uraian_belanja' => $request->uraian_belanja,
            'tagihan' => $request->tagihan,
            'tanggal_nota_persetujuan' => $request->tanggal_nota_persetujuan,
            'kode_rekening_id' => $request->kode_rekening_id,
            'etalase_id' => $request->etalase_id,
            'ppn' => $request->ppn,
            'pph23' => $request->pph23,
            'pph21' => $request->pph21,
            'keterangan' => $request->keterangan,
            'penerima' => $request->penerima,
            'created_by' => $request->user()->id,
        ]);
        $subKegiatan = SubKegiatan::find($request->sub_kegiatan_id);
        $yearId = $subKegiatan ? $subKegiatan->year_id : null;
        return redirect()->route('administrasi.index', array_filter([
            'sub_kegiatan_id' => $request->sub_kegiatan_id,
            'year_id' => $yearId,
            'kode_rekening_id' => $request->kode_rekening_id,
        ]))->with('success', 'Data administrasi berhasil disimpan.');
    }

    public function show(Administrasi $administrasi): View
    {
        Gate::authorize('view', $administrasi);
        $administrasi->load(['subKegiatan.year', 'kodeRekening', 'etalase', 'createdBy']);
        return view('administrasi.show', compact('administrasi'));
    }

    public function edit(Administrasi $administrasi): View
    {
        Gate::authorize('update', $administrasi);
        $administrasi->load(['subKegiatan.year', 'kodeRekening', 'etalase']);
        $years = Year::orderByDesc('tahun')->get();
        $subKegiatans = SubKegiatan::with('year')->orderBy('nama_sub_kegiatan')->get();
        $kodeRekenings = KodeRekening::orderBy('kode_rekening')->get();
        $etalases = Etalase::where('kode_rekening_id', $administrasi->kode_rekening_id)->orderBy('nama_etalase')->get();
        return view('administrasi.edit', compact('administrasi', 'years', 'subKegiatans', 'kodeRekenings', 'etalases'));
    }

    public function update(UpdateAdministrasiRequest $request, Administrasi $administrasi): RedirectResponse
    {
        Gate::authorize('update', $administrasi);
        $administrasi->update($request->validated());
        $yearId = $administrasi->subKegiatan?->year_id;
        return redirect()->route('administrasi.index', array_filter([
            'sub_kegiatan_id' => $administrasi->sub_kegiatan_id,
            'year_id' => $yearId,
            'kode_rekening_id' => $administrasi->kode_rekening_id,
        ]))->with('success', 'Data administrasi berhasil diubah.');
    }

    public function destroy(Request $request, Administrasi $administrasi): RedirectResponse
    {
        Gate::authorize('delete', $administrasi);
        $subKegiatanId = $administrasi->sub_kegiatan_id;
        $kodeRekeningId = $administrasi->kode_rekening_id;
        $yearId = $administrasi->subKegiatan?->year_id;
        $administrasi->delete();
        return redirect()->route('administrasi.index', array_filter([
            'sub_kegiatan_id' => $subKegiatanId,
            'year_id' => $yearId,
            'kode_rekening_id' => $kodeRekeningId,
        ]))->with('success', 'Data administrasi berhasil dihapus.');
    }
}
