<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ujian extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_ujian',
        'kuota',
        'lokasi',
        'harga_ujian',
    ];

    protected $attributes = [
        'status'      => 'open',
        'kuota'       => 40,
        'harga_ujian' => 100000,
    ];

    /**
     * Relasi: 1 ujian punya banyak pendaftaran
     */
    public function daftars()
    {
        return $this->hasMany(Daftar::class);
    }

    public function pengawas()
    {
        return $this->belongsToMany(Pengawas::class, 'pengawas_ujians');
    }

    /**
     * Helper: cek apakah ujian masih bisa didaftari
     */
    public function isOpen(): bool
    {
        return $this->status === 'open' && $this->sisaKuota() > 0;
    }

    /**
     * Helper: hitung sisa kuota (aman)
     */
    public function sisaKuota(): int
    {
        return max(0, $this->kuota - $this->daftars()->count());
    }
}
