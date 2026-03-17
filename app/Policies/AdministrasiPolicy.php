<?php

namespace App\Policies;

use App\Models\Administrasi;
use App\Models\User;

class AdministrasiPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Administrasi $administrasi): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Administrasi $administrasi): bool
    {
        return $user->isAdmin() || $user->id === $administrasi->created_by;
    }

    public function delete(User $user, Administrasi $administrasi): bool
    {
        return $user->isAdmin();
    }
}
