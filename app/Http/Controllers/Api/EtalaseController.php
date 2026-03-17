<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etalase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EtalaseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate(['kode_rekening_id' => 'required|integer|exists:kode_rekenings,id']);
        $etalases = Etalase::where('kode_rekening_id', $request->kode_rekening_id)
            ->orderBy('nama_etalase')
            ->get(['id', 'nama_etalase', 'kode_rekening_id']);
        return response()->json($etalases);
    }
}
