<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Daftar;
use App\Services\PendaftaranService;

class MahasiswaController extends Controller
{
    public function index()
    {
        $ujian = Ujian::where('status', 'open')->get();
        return view('mahasiswa.ujian.index', compact('ujian'));
    }

    public function create($id)
    {
        $ujian = Ujian::findOrFail($id);
        return view('mahasiswa.daftar.index', compact('ujian'));
    }

    public function store(Request $request, PendaftaranService $service)
    {
        $validated = $request->validate([
            'ujian_id'      => 'required|exists:ujians,id',
            'nim'           => 'required',
            'nama_lengkap'  => 'required',
            'bod'           => 'required|date',
            'prodi'         => 'required',
            'no_telp'       => 'required',
            'email'         => 'required|email',
        ]);

        try {
            $service->daftar($validated);
            return redirect()->route('mahasiswa.ujian.index')
                ->with('success', 'Pendaftaran berhasil');
        } catch (\Throwable $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}

