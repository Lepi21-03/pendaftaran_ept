<?php

namespace App\Filament\Resources\Mahasiswas\Pages;

use App\Filament\Resources\Mahasiswas\MahasiswaResource;
use App\Imports\NilaiEptImport;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Halaman custom Filament v5 untuk import nilai EPT dari Excel.
 *
 * Pola Filament v5:
 *  - form(Schema $schema): Schema  → mendefinisikan form
 *  - public ?array $data = [];     → state form disimpan di sini (->statePath('data'))
 *  - $this->form->fill() / getState() → bekerja normal
 */
class ImportNilaiEpt extends Page
{
    protected static string $resource = MahasiswaResource::class;

    protected static ?string $title = 'Import Nilai EPT dari Excel';

    public function getView(): string
    {
        return 'filament.pages.import-nilai-ept';
    }

    // ─── State Form (wajib array, dipakai statePath) ───────
    /** @var array<string, mixed>|null */
    public ?array $data = [];

    // ─── State Hasil ───────────────────────────────────────
    public array $hasil       = [];
    public bool  $sudahProses = false;

    // ─── Inisialisasi ──────────────────────────────────────
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Definisi form – Filament v5 pakai Schema bukan Form.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('fileExcel')
                    ->label('File Excel (.xlsx / .xls)')
                    ->acceptedFileTypes([
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.ms-excel',
                    ])
                    ->required()
                    ->disk('local')
                    ->directory('excel-imports')
                    ->helperText('Format kolom Excel: nama | nim | nilai'),
            ])
            ->statePath('data');   // ← $this->data['fileExcel']
    }

    // ─── Aksi ──────────────────────────────────────────────
    public function prosesImport(): void
    {
        $formData = $this->form->getState();

        if (empty($formData['fileExcel'])) {
            Notification::make()
                ->title('File belum dipilih!')
                ->danger()
                ->send();
            return;
        }

        $relativePath = $formData['fileExcel'];

        // Coba path private (Laravel 11+)
        $fullPath = storage_path('app/private/' . $relativePath);

        if (! file_exists($fullPath)) {
            $fullPath = storage_path('app/' . $relativePath);
        }

        if (! file_exists($fullPath)) {
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
