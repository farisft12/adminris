<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $email = strtolower((string) $googleUser->getEmail());

            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

            if (! $user && ! $this->isAllowedDomain($email)) {
                return redirect()->route('login')->with('error', 'Email ini tidak diizinkan mendaftar. Hubungi admin.');
            }

            if ($user) {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                if (! $user->is_active) {
                    return redirect()->route('login')->withErrors(['email' => 'Akun Anda sedang diblokir oleh admin.']);
                }

                if (! $user->is_approved) {
                    return redirect()->route('login')->with('status', 'Akun Anda masih menunggu persetujuan admin.');
                }

                Auth::login($user);
            } else {
                // forceCreate: email_verified_at tidak ada di $fillable.
                User::forceCreate([
                    'name' => $googleUser->getName(),
                    'email' => $email,
                    'google_id' => $googleUser->getId(),
                    'role' => User::ROLE_STAFF,
                    'email_verified_at' => now(),
                    'is_approved' => false,
                ]);

                return redirect()->route('login')->with('status', 'Pendaftaran berhasil. Akun Anda menunggu persetujuan admin sebelum dapat digunakan.');
            }

            return redirect()->intended(route('dashboard', absolute: false));

        } catch (\Exception $e) {
            report($e);

            return redirect()->route('login')->with('error', 'Gagal masuk dengan Google. Silakan coba lagi.');
        }
    }

    private function isAllowedDomain(string $email): bool
    {
        $allowed = config('services.google.allowed_domains', []);

        return $allowed === [] || in_array(substr(strrchr($email, '@') ?: '', 1), $allowed, true);
    }
}
