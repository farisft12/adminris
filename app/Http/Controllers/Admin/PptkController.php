<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pptk;
use App\Models\SubKegiatan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PptkController extends Controller
{
    public function index(): View
    {
        $pptks = Pptk::withCount('subKegiatans')->orderBy('nama_pptk')->paginate(15);
        return view('admin.pptks.index', compact('pptks'));
    }

    public function create(): View
    {
        return view('admin.pptks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_pptk' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
        ]);
        Pptk::create($request->only('nama_pptk', 'nip'));
        return redirect()->route('admin.pptks.index')->with('success', 'PPTK berhasil ditambah.');
    }

    public function edit(Pptk $pptk): View
    {
        return view('admin.pptks.edit', compact('pptk'));
    }

    public function update(Request $request, Pptk $pptk): RedirectResponse
    {
        $request->validate([
            'nama_pptk' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
        ]);
        $pptk->update($request->only('nama_pptk', 'nip'));
        return redirect()->route('admin.pptks.index')->with('success', 'PPTK berhasil diubah.');
    }

    public function destroy(Pptk $pptk): RedirectResponse
    {
        $pptk->subKegiatans()->update(['pptk_id' => null]);
        $pptk->delete();
        return redirect()->route('admin.pptks.index')->with('success', 'PPTK berhasil dihapus.');
    }

    public function assignIndex(): View
    {
        $subKegiatans = SubKegiatan::with(['year', 'pptk'])->orderBy('nama_sub_kegiatan')->get();
        $pptks = Pptk::orderBy('nama_pptk')->get();
        return view('admin.pptks.assign', compact('subKegiatans', 'pptks'));
    }

    public function assignStore(Request $request): RedirectResponse
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.sub_kegiatan_id' => 'required|exists:sub_kegiatans,id',
            'assignments.*.pptk_id' => 'nullable|exists:pptks,id',
        ]);
        foreach ($request->assignments as $a) {
            $pptkId = ! empty($a['pptk_id']) ? $a['pptk_id'] : null;
            SubKegiatan::where('id', $a['sub_kegiatan_id'])->update(['pptk_id' => $pptkId]);
        }
        return redirect()->route('admin.pptk.assign')->with('success', 'Penugasan PPTK berhasil disimpan.');
    }
}
