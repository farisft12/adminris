<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PurgeUnapprovedUsers extends Command
{
    protected $signature = 'users:purge-unapproved
        {--include-google : Ikut hapus akun Google yang belum disetujui}
        {--force : Benar-benar menghapus (tanpa ini hanya menampilkan jumlah)}';

    protected $description = 'Hapus permanen akun staff yang belum disetujui admin (akun spam dari form register).';

    public function handle(): int
    {
        $query = $this->candidates();
        $total = (clone $query)->count();

        $this->info("Akun yang cocok: {$total}");

        if ($total === 0) {
            return self::SUCCESS;
        }

        $this->table(['id', 'nama', 'email', 'daftar'], (clone $query)->orderBy('id')->limit(10)
            ->get(['id', 'name', 'email', 'created_at'])
            ->map(fn (User $u) => [$u->id, $u->name, $u->email, $u->created_at?->toDateString()]));

        if (! $this->option('force')) {
            $this->warn('Mode lihat saja. Jalankan ulang dengan --force untuk menghapus permanen.');

            return self::SUCCESS;
        }

        $deleted = 0;

        (clone $query)->select(['id', 'email'])->chunkById(500, function ($users) use (&$deleted) {
            DB::transaction(function () use ($users, &$deleted) {
                DB::table('password_reset_tokens')->whereIn('email', $users->pluck('email'))->delete();
                DB::table('sessions')->whereIn('user_id', $users->pluck('id'))->delete();
                $deleted += User::whereIn('id', $users->pluck('id'))->delete();
            });
        });

        $this->info("Terhapus permanen: {$deleted} akun.");

        return self::SUCCESS;
    }

    private function candidates(): Builder
    {
        return User::query()
            ->where('role', User::ROLE_STAFF)
            ->where('is_approved', false)
            ->when(! $this->option('include-google'), fn (Builder $q) => $q->whereNull('google_id'))
            // Jangan sentuh akun yang sudah punya data apa pun.
            ->whereNotExists(fn ($q) => $q->from('administrasis')->whereColumn('administrasis.created_by', 'users.id'))
            ->when(DB::getSchemaBuilder()->hasTable('pembayaran_di_muka'), fn (Builder $q) => $q
                ->whereNotExists(fn ($s) => $s->from('pembayaran_di_muka')->whereColumn('pembayaran_di_muka.paid_by', 'users.id')))
            ->when(DB::getSchemaBuilder()->hasTable('sppds'), fn (Builder $q) => $q
                ->whereNotExists(fn ($s) => $s->from('sppds')->where(fn ($w) => $w
                    ->whereColumn('sppds.user_id', 'users.id')
                    ->orWhereColumn('sppds.approver_id', 'users.id')
                    ->orWhereColumn('sppds.payer_id', 'users.id'))));
    }
}
