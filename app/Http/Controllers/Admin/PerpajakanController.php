<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perpajakan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerpajakanController extends Controller
{
    public function edit(): View
    {
        $perpajakan = Perpajakan::settings();
        return view('admin.perpajakan.edit', compact('perpajakan'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'ppn_rate' => 'required|numeric|min:0|max:1',
            'pph23_rate' => 'required|numeric|min:0|max:1',
            'pph21_rate' => 'required|numeric|min:0|max:1',
        ]);
        $s = Perpajakan::settings();
        $s->update([
            'ppn_rate' => $request->ppn_rate,
            'pph23_rate' => $request->pph23_rate,
            'pph21_rate' => $request->pph21_rate,
        ]);
        return redirect()->route('admin.perpajakan.edit')->with('success', 'Pengaturan perpajakan berhasil disimpan.');
    }
}
