<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Daftar;
use App\Models\Prodi;
use App\Services\PendaftaranService;
use App\Services\PembayaranService;

class MahasiswaController extends Controller
{
    public function ujian()
    {
        $ujian = Ujian::with('pengawas')->where('status', 'open')->get();
        return view('mahasiswa.ujian.index', compact('ujian'));
    }

    public function login()
    {
        return view('mahasiswa.login.index');
    }

    public function daftar(Request $request)
    {
        $id = $request->query('ujian_id');
        $ujian = Ujian::findOrFail($id);
        $prodis = Prodi::all();
        return view('mahasiswa.daftar.index', compact('ujian', 'prodis'));
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

    public function bayar($daftarId, PembayaranService $service)
    {
        try {
            $kartu = $service->bayarDanGenerateKartu($daftarId);

            return redirect()->route('mahasiswa.ujian.index', $kartu->Id)
            ->with('success', 'Pembayaran berhasil, Kartu Ujian Dibuat');
        }  catch (\Throwable $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}

