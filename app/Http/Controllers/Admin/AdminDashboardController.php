<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'users_total' => \App\Models\User::count(),
            'sub_kegiatan_total' => \App\Models\SubKegiatan::count(),
            // You could add more financial stats here if needed, but these fulfill the "User Card" and "Data Card" requirement
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
