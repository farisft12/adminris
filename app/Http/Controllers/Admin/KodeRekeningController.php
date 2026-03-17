<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KodeRekening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KodeRekeningController extends Controller
{
    public function index(): View
    {
        $kodeRekenings = KodeRekening::withCount('etalases')->orderBy('kode_rekening')->paginate(15);
        return view('admin.kode-rekenings.index', compact('kodeRekenings'));
    }

    public function create(): View
    {
        return view('admin.kode-rekenings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kode_rekening' => 'required|string|max:100',
            'nama_rekening' => 'required|string|max:255',
        ]);
        $kodeRekening = KodeRekening::create($request->only('kode_rekening', 'nama_rekening'));
        return redirect()->route('admin.kode-rekenings.edit', $kodeRekening)
            ->with('success', 'Kode Rekening tersimpan. Silakan tambah etalase (opsional), lalu Simpan atau Simpan Semua.');
    }

    public function edit(KodeRekening $kodeRekening): View
    {
        $kodeRekening->load('etalases');
        return view('admin.kode-rekenings.edit', compact('kodeRekening'));
    }

    public function update(Request $request, KodeRekening $kodeRekening): RedirectResponse
    {
        $request->validate([
            'kode_rekening' => 'required|string|max:100',
            'nama_rekening' => 'required|string|max:255',
        ]);
        $kodeRekening->update($request->only('kode_rekening', 'nama_rekening'));
        return redirect()->route('admin.kode-rekenings.index')->with('success', 'Kode Rekening berhasil diubah.');
    }

    public function destroy(KodeRekening $kodeRekening): RedirectResponse
    {
        $kodeRekening->delete();
        return redirect()->route('admin.kode-rekenings.index')->with('success', 'Kode Rekening berhasil dihapus.');
    }
}
