<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'npm',
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
