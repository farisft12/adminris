<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'bendahara_nama' => 'required|string|max:255',
            'bendahara_nip'  => 'required|string|max:255',
            'kabag_nama'     => 'required|string|max:255',
            'kabag_nip'      => 'required|string|max:255',
        ]);

        foreach ($data as $key => $value) {
            DB::table('settings')
                ->updateOrInsert(['key' => $key], ['value' => $value, 'updated_at' => now()]);
        }

        return back()->with('success', 'Data pejabat berhasil diperbarui.');
    }
}
