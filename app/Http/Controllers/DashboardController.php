<?php

namespace App\Http\Controllers;

use App\Models\SubKegiatan;
use App\Models\Year;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $years = Year::orderByDesc('tahun')->get();
        $yearId = $request->integer('year_id');
        $search = $request->filled('search') ? trim($request->get('search')) : '';

        $subKegiatans = collect();
        if ($yearId) {
            $query = SubKegiatan::where('year_id', $yearId);
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_sub_kegiatan', 'like', '%' . $search . '%')
                        ->orWhere('kode_sub', 'like', '%' . $search . '%');
                });
            }
            $subKegiatans = $query->orderBy('nama_sub_kegiatan')->get();
        }
        $selectedYear = $yearId ? $years->firstWhere('id', $yearId) : null;

        return view('dashboard', compact('years', 'subKegiatans', 'selectedYear', 'yearId', 'search'));
    }
}
