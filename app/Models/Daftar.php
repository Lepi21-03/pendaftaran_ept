<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Daftar extends Model
{
    use HasFactory;

    protected $table = 'daftar';

    protected $fillable = [
        'nim',
        'nama_lengkap',
        'bod',
        'prodi',
        'no_telp',
        'email',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'id_ujian');
    }
}
