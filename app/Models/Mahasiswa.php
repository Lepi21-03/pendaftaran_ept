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
        'password',              // Password login (hashed otomatis via cast)
        'email_verified_at',     // Timestamp verifikasi email
        'phone',
        'score',                 // Total score
        'score_listening',       // Listening score
        'score_structure',       // Structure and Writing Expression score
        'score_reading',         // Reading score
        'test_date',             // Tanggal ujian EPT
        'google_id',             // Google OAuth ID
        'avatar',                // URL foto profil Google
    ];

    /**
     * Sembunyikan password dari serialisasi (JSON/toArray).
     */
    protected $hidden = ['password'];

    /**
     * Cast password agar otomatis di-hash saat di-set.
     * Cast email_verified_at agar otomatis jadi Carbon datetime.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function daftars()
    {
        return $this->hasMany(Daftar::class, 'nim', 'nim');
    }
}
