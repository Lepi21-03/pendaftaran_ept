<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'prodi',
        'email',
        'phone',
        'score', // For certificate
    ];

    public function daftars()
    {
        return $this->hasMany(Daftar::class, 'nim', 'nim');
    }
}
