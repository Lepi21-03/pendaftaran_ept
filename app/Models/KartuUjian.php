<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KartuUjian extends Model
{
    use HasFactory;

    protected $table = 'kartu_ujian';

    protected $fillable = [
        'nim',
        'nama_lengkap',
        'bod',
        'prodi',
    ];
}
