<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Daftar;

class BersihkanPendingDuplikat extends Command
{
    protected $signature   = 'ept:bersihkan-pending {--hapus : Hapus data pending yang statusnya masih pending}';
    protected $description = 'Tampilkan (dan opsional hapus) data pendaftaran yang statusnya masih pending';

    public function handle(): int
    {
        $rows = Daftar::where('status', 'pending')->get();

        if ($rows->isEmpty()) {
            $this->info('✅ Tidak ada data pending di tabel daftars.');
            return 0;
        }

        $this->table(
            ['ID', 'ujian_id', 'NIM', 'Nama', 'Email', 'Invoice Xendit', 'Status', 'Dibuat'],
            $rows->map(fn($r) => [
                $r->id,
                $r->ujian_id,
                $r->nim,
                $r->nama_lengkap,
                $r->email,
                $r->xendit_invoice_id ?? '-',
                $r->status,
                $r->created_at,
            ])
        );

        if ($this->option('hapus')) {
            if ($this->confirm('⚠️  Yakin ingin HAPUS semua data pending di atas?')) {
                $jumlah = Daftar::where('status', 'pending')->delete();
                $this->info("🗑️  {$jumlah} data pending berhasil dihapus.");
            } else {
                $this->warn('Dibatalkan. Tidak ada data yang dihapus.');
            }
        } else {
            $this->comment('💡 Jalankan dengan --hapus untuk menghapus data di atas.');
        }

        return 0;
    }
}
