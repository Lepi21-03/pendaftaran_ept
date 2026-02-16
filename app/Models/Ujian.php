<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ujian extends Model
{
    use HasFactory;

    protected $table = 'ujian';

    protected $fillable = [
        'tanggal_ujian',
        'kuota',
    ];

    public function daftar()
    {
        return $this->hasMany(Daftar::class, 'id_ujian');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_ujian');
    }

    public function kartu_ujian()
    {
        return $this->hasMany(KartuUjian::class, 'id_ujian');
    }
}
