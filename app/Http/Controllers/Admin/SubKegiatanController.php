<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeRekening;
use App\Models\SubKegiatan;
use App\Models\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SubKegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $query = SubKegiatan::with(['year', 'kodeRekenings'])->orderBy('nama_sub_kegiatan');
        if ($request->filled('year_id')) {
            $query->where('year_id', $request->year_id);
        }
        $subKegiatans = $query->paginate(15);
        $years = Year::orderByDesc('tahun')->get();
        return view('admin.sub-kegiatans.index', compact('subKegiatans', 'years'));
    }

    public function create(): View
    {
        $years = Year::orderByDesc('tahun')->get();
        return view('admin.sub-kegiatans.create', compact('years'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'nama_sub_kegiatan' => 'required|string|max:255',
            'kode_sub' => [
                'nullable',
                'string',
                'max:100',
                Rule::when($request->filled('kode_sub'), Rule::unique('sub_kegiatans', 'kode_sub')),
            ],
            'anggaran' => 'nullable|numeric|min:0',
        ], [
            'kode_sub.unique' => 'Kode sub sudah digunakan oleh sub kegiatan lain.',
        ]);
        SubKegiatan::create([
            'year_id' => $request->year_id,
            'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
            'kode_sub' => $request->kode_sub ?? '',
            'anggaran' => $request->input('anggaran', 0),
        ]);
        return redirect()->route('admin.sub-kegiatans.index')->with('success', 'Sub Kegiatan berhasil ditambah.');
    }

    public function edit(SubKegiatan $subKegiatan): View
    {
        $subKegiatan->load(['year', 'kodeRekenings']);
        $years = Year::orderByDesc('tahun')->get();
        $kodeRekenings = KodeRekening::orderBy('kode_rekening')->get();
        return view('admin.sub-kegiatans.edit', compact('subKegiatan', 'years', 'kodeRekenings'));
    }

    public function update(Request $request, SubKegiatan $subKegiatan): RedirectResponse
    {
        $request->validate([
            'year_id' => 'required|exists:years,id',
            'nama_sub_kegiatan' => 'required|string|max:255',
            'kode_sub' => [
                'nullable',
                'string',
                'max:100',
                Rule::when($request->filled('kode_sub'), Rule::unique('sub_kegiatans', 'kode_sub')->ignore($subKegiatan->id)),
            ],
            'anggaran' => 'nullable|numeric|min:0',
        ], [
            'kode_sub.unique' => 'Kode sub sudah digunakan oleh sub kegiatan lain.',
        ]);
        $subKegiatan->update([
            'year_id' => $request->year_id,
            'nama_sub_kegiatan' => $request->nama_sub_kegiatan,
            'kode_sub' => $request->kode_sub ?? '',
            'anggaran' => $request->input('anggaran', 0),
        ]);
        $subKegiatan->kodeRekenings()->sync($request->input('kode_rekening_ids', []));
        return redirect()->route('admin.sub-kegiatans.index')->with('success', 'Sub Kegiatan berhasil diubah.');
    }

    public function destroy(SubKegiatan $subKegiatan): RedirectResponse
    {
        $subKegiatan->delete();
        return redirect()->route('admin.sub-kegiatans.index')->with('success', 'Sub Kegiatan berhasil dihapus.');
    }

    public function updateAnggaranKodeRekening(Request $request, SubKegiatan $subKegiatan): RedirectResponse
    {
        $anggaran = $request->input('anggaran', []);
        foreach ($anggaran as $kodeRekeningId => $nilai) {
            if (!is_numeric($kodeRekeningId)) {
                continue;
            }
            $subKegiatan->kodeRekenings()->updateExistingPivot($kodeRekeningId, [
                'anggaran' => (float) $nilai,
            ]);
        }
        return redirect()->route('admin.sub-kegiatans.index', $request->only('year_id'))
            ->with('success', 'Anggaran kode rekening berhasil disimpan.');
    }
}
