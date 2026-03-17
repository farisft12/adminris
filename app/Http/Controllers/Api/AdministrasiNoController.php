<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AdministrasiRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdministrasiNoController extends Controller
{
    public function __construct(
        protected AdministrasiRepository $repository
    ) {}

    public function nextNo(Request $request): JsonResponse
    {
        $request->validate(['sub_kegiatan_id' => 'required|integer|exists:sub_kegiatans,id']);
        $nextNo = $this->repository->getNextNoForSubKegiatan($request->sub_kegiatan_id);
        return response()->json(['next_no' => $nextNo]);
    }
}
