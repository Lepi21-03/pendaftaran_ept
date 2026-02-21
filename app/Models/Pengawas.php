<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengawas extends Model
{
    protected $table = 'pengawas';

    protected $fillable = [
        'nama',
    ];

    public function ujians()
    {
        return $this->belongsToMany(Ujian::class, 'pengawas_ujians');
    }

   
    public function getInisialAttribute(): string
    {
        return collect(explode(' ', $this->nama))
            ->filter()
            ->map(fn ($kata) => strtoupper(substr($kata, 0, 1)))
            ->join('');
    }
}
