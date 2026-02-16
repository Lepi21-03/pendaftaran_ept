<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController
{
    //tampilan awal 
    public function index()
    {
        $ujian = Ujian::all();
        return view('mahasiswa.ujian.index', compact ('ujian'));
    }

    //form pendaftaran
    public function create($id)
    {
        $ujian = Ujian::findOrFail($id);
        return view('mahasiswa.daftar.index', compact ('ujian'));
    }

    //simpan data 
    public function store(Request $request)
    {
        $request->validate([
            'id_ujian' => 'required|exists:ujian,id',
            'nim' => 'required',
            'nama_lengkap' => 'required',
            'bod' => 'required|date',
            'prodi' => 'required',
            'no_telp' => 'required',
            'email' => 'required|email',
        ]);

        Daftar::create($request->all());

        return redirect()->route('mahasiswa.ujian.index');
    }
}
