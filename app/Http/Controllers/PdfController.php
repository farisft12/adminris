<?php

namespace App\Http\Controllers;

use App\Models\Administrasi;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function kwitansi(Administrasi $administrasi)
    {
        Gate::authorize('view', $administrasi);
        $administrasi->load(['subKegiatan.year', 'kodeRekening', 'etalase', 'createdBy']);
        $pdf = Pdf::loadView('pdf.kwitansi', compact('administrasi'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('kwitansi-'.$administrasi->id.'.pdf');
    }

    public function notaPersetujuan(Administrasi $administrasi)
    {
        Gate::authorize('view', $administrasi);
        $administrasi->load(['subKegiatan.year', 'subKegiatan.pptk', 'kodeRekening', 'etalase', 'createdBy']);
        $pdf = Pdf::loadView('pdf.nota-persetujuan', compact('administrasi'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('nota-persetujuan-'.$administrasi->id.'.pdf');
    }
}
