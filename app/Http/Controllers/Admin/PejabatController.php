<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PejabatController extends Controller
{
    public function index(): View
    {
        $settings = [
            'bendahara_nama' => Setting::get('bendahara_nama', ''),
            'bendahara_nip'  => Setting::get('bendahara_nip', ''),
            'kabag_nama'     => Setting::get('kabag_nama', ''),
            'kabag_nip'      => Setting::get('kabag_nip', ''),
        ];

        return view('admin.pejabat.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'bendahara_nama' => 'required|string|max:255',
            'bendahara_nip'  => 'required|string|max:100',
            'kabag_nama'     => 'required|string|max:255',
            'kabag_nip'      => 'required|string|max:100',
        ]);

        Setting::set('bendahara_nama', $request->bendahara_nama);
        Setting::set('bendahara_nip', $request->bendahara_nip);
        Setting::set('kabag_nama', $request->kabag_nama);
        Setting::set('kabag_nip', $request->kabag_nip);

        return back()->with('success', 'Data pejabat berhasil diperbarui.');
    }
}
