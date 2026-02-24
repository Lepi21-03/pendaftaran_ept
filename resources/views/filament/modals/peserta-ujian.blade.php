<div class="space-y-4">

    {{-- Info Ujian --}}
    <div class="flex flex-wrap gap-4 rounded-xl bg-gray-100 dark:bg-gray-800 p-4 text-sm">
        <div>
            <span class="font-semibold text-gray-600 dark:text-gray-400">Tanggal:</span>
            <span class="ml-1 text-gray-900 dark:text-white">
                {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->translatedFormat('d F Y') }}
            </span>
        </div>
        <div>
            <span class="font-semibold text-gray-600 dark:text-gray-400">Lokasi:</span>
            <span class="ml-1 text-gray-900 dark:text-white">{{ $ujian->lokasi ?? '-' }}</span>
        </div>
        <div>
            <span class="font-semibold text-gray-600 dark:text-gray-400">Kuota:</span>
            <span class="ml-1 text-gray-900 dark:text-white">{{ $daftars->count() }} / {{ $ujian->kuota }}</span>
        </div>
    </div>

    {{-- Tabel Peserta --}}
    @if($daftars->isEmpty())
        <div class="flex flex-col items-center justify-center py-10 text-gray-400 dark:text-gray-500">
            <x-filament::icon icon="heroicon-o-users" class="w-12 h-12 mb-3 opacity-50" />
            <p class="text-sm font-medium">Belum ada peserta yang mendaftar</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 w-10">No</th>
                        <th class="px-4 py-3">Nama Lengkap</th>
                        <th class="px-4 py-3">NIM</th>
                        <th class="px-4 py-3">Prodi</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($daftars as $i => $daftar)
                        <tr class="bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-4 py-3 text-gray-400 font-mono">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                {{ $daftar->nama_lengkap }}
                            </td>
                            <td class="px-4 py-3 font-mono text-gray-700 dark:text-gray-300">
                                {{ $daftar->nim }}
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                {{ $daftar->prodi ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @php
                                    $statusPembayaran = $daftar->pembayaran?->status ?? $daftar->status ?? 'pending';
                                    $badge = match($statusPembayaran) {
                                        'paid', 'lunas'   => ['bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300', 'Lunas'],
                                        'pending'         => ['bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300', 'Pending'],
                                        'cancelled', 'batal' => ['bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300', 'Batal'],
                                        default           => ['bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400', ucfirst($statusPembayaran)],
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badge[0] }}">
                                    {{ $badge[1] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="text-xs text-right text-gray-400 dark:text-gray-500">
            Total {{ $daftars->count() }} peserta terdaftar
        </p>
    @endif

</div>
