<?php

namespace App\Filament\Resources\Mahasiswas\Pages;

use App\Filament\Resources\Mahasiswas\MahasiswaResource;
use App\Imports\NilaiEptImport;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

/**
 * Halaman custom Filament v5 untuk import nilai EPT dari Excel.
 *
 * PENDEKATAN BARU:
 * Menggunakan Livewire WithFileUploads trait langsung (tanpa Filament FileUpload),
 * sehingga file bisa di-upload via $wire.upload() dari JavaScript dan
 * tidak ada masalah input hilang / tidak bisa di-isi ulang.
 */
class ImportNilaiEpt extends Page
{
    use WithFileUploads;

    protected static string $resource = MahasiswaResource::class;

    protected static ?string $title = 'Import Nilai EPT dari Excel';

    public function getView(): string
    {
        return 'filament.pages.import-nilai-ept';
    }

    // ─── State Upload ──────────────────────────────────────
    /** File sementara dari Livewire (TemporaryUploadedFile) */
    public $fileExcel = null;

    // ─── State Hasil ───────────────────────────────────────
    public array $hasil       = [];
    public bool  $sudahProses = false;

    // ─── Validasi ──────────────────────────────────────────
    protected array $rules = [
        'fileExcel' => 'required|file|mimes:xlsx,xls,csv|max:10240',
    ];

    // ─── Aksi ──────────────────────────────────────────────
    public function prosesImport(): void
    {
        $this->validate();

        if (!$this->fileExcel) {
            Notification::make()
                ->title('File belum dipilih!')
                ->danger()
                ->send();
            return;
        }

        // Dapatkan path absolut dari TemporaryUploadedFile Livewire
        $fullPath = $this->fileExcel->getRealPath();

        if (!$fullPath || !file_exists($fullPath)) {
            Notification::make()
                ->title('File tidak ditemukan di server. Coba upload ulang.')
                ->danger()
                ->send();
            return;
        }

        $import = new NilaiEptImport();
        Excel::import($import, $fullPath);

        $this->hasil       = $import->hasil;
        $this->sudahProses = true;

        // Reset file setelah proses selesai
        $this->fileExcel = null;

        $berhasil       = collect($this->hasil)->where('status', 'berhasil')->count();
        $tidakDitemukan = collect($this->hasil)->where('status', 'tidak_ditemukan')->count();

        Notification::make()
            ->title("Import selesai: {$berhasil} berhasil, {$tidakDitemukan} tidak ditemukan")
            ->success()
            ->send();
    }

    // ─── Header Actions ────────────────────────────────────
    protected function getHeaderActions(): array
    {
        return [
            Action::make('kembali')
                ->label('← Kembali ke Data Mahasiswa')
                ->url(MahasiswaResource::getUrl('index'))
                ->color('gray'),
        ];
    }
}
