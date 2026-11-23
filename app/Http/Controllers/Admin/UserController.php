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

    public function approve(User $user): RedirectResponse
    {
        if ($user->is_approved) {
            return back()->with('error', "User {$user->name} sudah disetujui.");
        }

        // Admin sudah memeriksa akun ini, jadi email dianggap terverifikasi.
        $user->forceFill([
            'is_approved' => true,
            'email_verified_at' => $user->email_verified_at ?? now(),
        ])->save();

        return back()->with('success', "Pendaftaran {$user->name} berhasil disetujui.");
    }

    public function updateRole(User $user, \Illuminate\Http\Request $request): RedirectResponse
    {
        $request->validate(['role' => ['required', \Illuminate\Validation\Rule::in([User::ROLE_STAFF, User::ROLE_ADMIN])]]);

        // Cegah menurunkan role admin terakhir menjadi staff
        if ($user->isAdmin() && $request->role !== User::ROLE_ADMIN && User::where('role', User::ROLE_ADMIN)->count() <= 1) {
            return back()->with('error', 'Tidak dapat mengubah role satu-satunya admin sistem.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if ($user->isAdmin() && User::where('role', User::ROLE_ADMIN)->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus satu-satunya admin sistem.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "User {$name} telah dihapus permanen.");
    }
}
