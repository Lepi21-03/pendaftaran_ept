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
        'score',            // Total score
        'score_listening',   // Listening score
        'score_structure',   // Structure and Writing Expression score
        'score_reading',     // Reading score
        'test_date',         // Tanggal ujian EPT
        'google_id',        // Google OAuth ID
        'avatar',           // URL foto profil Google
    ];

    public function daftars()
    {
        return $this->hasMany(Daftar::class, 'nim', 'nim');
    }
}
