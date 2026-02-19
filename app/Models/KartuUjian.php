<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KartuUjian extends Model
{
    use HasFactory;

    protected $fillable = [
        'daftar_id',
        'nomor_peserta',
        'generated_at',
    ];

    public $timestamps = true;

    /**
     * Relasi: kartu ujian milik satu pendaftaran
     */
    public function daftar()
    {
        return $this->belongsTo(Daftar::class);
    }
}
