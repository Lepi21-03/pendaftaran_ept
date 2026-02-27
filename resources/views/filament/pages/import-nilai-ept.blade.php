<x-filament-panels::page>
    {{-- =============================================
         FORM UPLOAD FILE EXCEL
    ============================================= --}}
    <x-filament::section>
        <x-slot name="heading">
            📂 Upload File Excel Nilai EPT
        </x-slot>
        <x-slot name="description">
            Pastikan kolom Excel berurutan: <strong>nama</strong> | <strong>nim</strong> | <strong>nilai</strong><br>
            Baris pertama harus berupa <strong>header</strong>. NIM akan dicocokkan dengan mahasiswa yang sudah terdaftar.
        </x-slot>

        <form wire:submit="prosesImport">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button
                    type="submit"
                    icon="heroicon-o-arrow-up-tray"
                    color="primary"
                >
                    Proses Import &amp; Cocokkan Data
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    {{-- =============================================
         HASIL PROSES IMPORT
    ============================================= --}}
    @if ($sudahProses)
        @php
            $berhasil       = collect($hasil)->where('status', 'berhasil');
            $tidakDitemukan = collect($hasil)->where('status', 'tidak_ditemukan');
        @endphp

        {{-- Ringkasan Statistik --}}
        <div class="grid grid-cols-2 gap-4 mt-2">
            <x-filament::section>
                <div class="text-center py-2">
                    <p class="text-4xl font-bold text-success-600">{{ $berhasil->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">✅ Data Cocok & Nilai Diperbarui</p>
                </div>
            </x-filament::section>
            <x-filament::section>
                <div class="text-center py-2">
                    <p class="text-4xl font-bold text-danger-600">{{ $tidakDitemukan->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">❌ NIM Tidak Ditemukan di Database</p>
                </div>
            </x-filament::section>
        </div>

        {{-- Tabel Data Berhasil --}}
        @if ($berhasil->count() > 0)
            <x-filament::section>
                <x-slot name="heading">
                    ✅ Data Berhasil — {{ $berhasil->count() }} mahasiswa
                </x-slot>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">NIM</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Nilai EPT</th>
                                <th class="px-4 py-3">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($berhasil->values() as $i => $row)
                                @php
                                    $mahasiswa = \App\Models\Mahasiswa::where('nim', $row['nim'])->first();
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-700 dark:text-gray-300">{{ $row['nim'] }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $row['nama'] }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-200">
                                            {{ $row['nilai'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($mahasiswa)
                                            <a
                                                href="{{ route('sertifikat.download', $mahasiswa->id) }}"
                                                target="_blank"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white rounded-lg bg-success-600 hover:bg-success-700 transition-colors"
                                            >
                                                🎓 Download PDF
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-filament::section>
        @endif

        {{-- Tabel Data Tidak Ditemukan --}}
        @if ($tidakDitemukan->count() > 0)
            <x-filament::section>
                <x-slot name="heading">
                    ❌ NIM Tidak Ditemukan — {{ $tidakDitemukan->count() }} data
                </x-slot>
                <x-slot name="description">
                    NIM berikut ada di Excel tapi <strong>tidak terdaftar</strong> di database. Pastikan mahasiswa sudah mendaftar sebelum di-import.
                </x-slot>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">NIM (dari Excel)</th>
                                <th class="px-4 py-3">Nama (dari Excel)</th>
                                <th class="px-4 py-3">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($tidakDitemukan->values() as $i => $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 font-mono font-semibold text-danger-600">{{ $row['nim'] }}</td>
                                    <td class="px-4 py-3">{{ $row['nama'] }}</td>
                                    <td class="px-4 py-3">{{ $row['nilai'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-filament::section>
        @endif
    @endif
</x-filament-panels::page>
