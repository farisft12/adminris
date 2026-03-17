<?php

namespace App\Http\Controllers;

use App\Models\Administrasi;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubKegiatanKodeRekeningController extends Controller
{
    public function index(Request $request, SubKegiatan $subKegiatan): View
    {
        if ($request->user()->isAdmin()) {
            abort(404);
        }
        $subKegiatan->load(['year', 'kodeRekenings']);
        $kodeRekenings = $subKegiatan->kodeRekenings()->orderBy('kode_rekening')->get();

        $subKegiatanId = $subKegiatan->id;
        $totalInputPerKode = Administrasi::query()
            ->where('sub_kegiatan_id', $subKegiatanId)
            ->selectRaw('kode_rekening_id, SUM(tagihan + COALESCE(ppn, 0) + COALESCE(pph23, 0) + COALESCE(pph21, 0)) as total_input')
            ->groupBy('kode_rekening_id')
            ->pluck('total_input', 'kode_rekening_id');

        $kodeRekenings->each(function ($kr) use ($totalInputPerKode) {
            $anggaran = (float) ($kr->pivot->anggaran ?? 0);
            $totalInput = (float) ($totalInputPerKode->get($kr->id, 0));
            $kr->anggaran = $anggaran;
            $kr->total_input = $totalInput;
            $kr->selisih = $anggaran - $totalInput;
        });

        return view('sub-kegiatan.kode-rekenings.index', compact('subKegiatan', 'kodeRekenings'));
    }
}
