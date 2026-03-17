<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etalase;
use App\Models\KodeRekening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EtalaseController extends Controller
{
    public function store(Request $request, KodeRekening $kodeRekening): RedirectResponse
    {
        $request->validate(['nama_etalase' => 'required|string|max:255']);
        $kodeRekening->etalases()->create(['nama_etalase' => $request->nama_etalase]);
        return redirect()->route('admin.kode-rekenings.edit', $kodeRekening)->with('success', 'Etalase berhasil ditambah.');
    }

    public function destroy(Etalase $etalase): RedirectResponse
    {
        $kodeRekeningId = $etalase->kode_rekening_id;
        $etalase->delete();
        return redirect()->route('admin.kode-rekenings.edit', $kodeRekeningId)->with('success', 'Etalase berhasil dihapus.');
    }
}
