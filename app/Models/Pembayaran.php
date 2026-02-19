<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table ='pembayaran';

    protected $fillable = [
        'id_user',
        'id_ujian',
        'status',
        'id_ujian',
    ];

    public function daftar()
    {
        return $this->belongsTo(Daftar::class);
    }
}
