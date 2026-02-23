<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Daftar extends Model
{
    use HasFactory;

    protected $table = 'daftars';

 //field yang boleh di isi user 
    protected $fillable = [
        'ujian_id',
        'nim',
        'nama_lengkap',
        'bod',
        'prodi',
        'no_telp',
        'email',
        'xendit_invoice_id',
    ];

    //field yang tidak boleh di isi user 
    protected $attributes= [
       'status' => 'pending',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function kartuUjian()
    {
        return $this->hasOne(KartuUjian::class);
    }
}
