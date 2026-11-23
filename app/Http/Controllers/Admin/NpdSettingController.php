<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Year;
use App\Services\NpdTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class NpdSettingController extends Controller
{
    public function index(Request $request): View
    {
        $years = Year::orderByDesc('tahun')->pluck('tahun');
        $tahun = (int) ($request->integer('tahun') ?: ($years->first() ?? date('Y')));

        return view('admin.npd-settings.index', [
            'years' => $years,
            'tahun' => $tahun,
            'texts' => NpdTemplate::forYear($tahun),
            'fields' => NpdTemplate::FIELDS,
            'kegiatans' => Kegiatan::orderBy('kode')->get(),
        ]);
    }

    public function updateTexts(Request $request): RedirectResponse
    {
        $rules = ['tahun' => ['required', 'integer', Rule::exists('years', 'tahun')]];
        foreach (array_keys(NpdTemplate::FIELDS) as $field) {
            $rules[$field] = ['nullable', 'string', 'max:5000'];
        }
        $data = $request->validate($rules);

        NpdTemplate::save((int) $data['tahun'], $data);

        return redirect()->route('admin.npd-settings.index', ['tahun' => $data['tahun']])
            ->with('success', "Teks NPD tahun {$data['tahun']} disimpan.");
    }

    public function storeKegiatan(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kode' => ['required', 'string', 'max:50', 'regex:/^[0-9.]+$/', 'unique:kegiatans,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
        ]);

        Kegiatan::create($data);

        return back()->with('success', "Kegiatan {$data['kode']} ditambahkan.");
    }

    public function updateKegiatan(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
        ]);

        $kegiatan->update($data);

        return back()->with('success', "Kegiatan {$kegiatan->kode} diperbarui.");
    }
}
