<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->paginate(15);
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $staffCount = User::where('role', 'staff')->count();

        return view('admin.users.index', compact('users', 'totalUsers', 'adminCount', 'staffCount'));
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1 && $user->is_active) {
            return back()->with('error', 'Tidak dapat memblokir satu-satunya admin sistem.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'diblokir';
        return back()->with('success', "User {$user->name} berhasil {$status}.");
    }
}
