<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Daftar extends Model
{
    use HasFactory;

    protected $table = 'daftar';

 //field yang boleh di isi user 
    protected $fillable = [
        'nim',
        'nama_lengkap',
        'bod',
        'prodi',
        'no_telp',
        'email',
    ];

    //field yang tidak boleh di isi user 
    protected $attributes= [
       'status' => 'pending',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'id_ujian');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function kartu_ujian()
    {
        return $this->hasOne(KartuUjian::class);
    }
}
