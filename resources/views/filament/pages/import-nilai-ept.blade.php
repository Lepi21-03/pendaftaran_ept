<x-filament-panels::page>

{{-- SheetJS: membaca Excel di sisi browser --}}
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<style>
/* ══════════════════════════════════════════
   DROP ZONE
══════════════════════════════════════════ */
.ept-dropzone-wrap {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 1rem;
    padding: 2.75rem 1.5rem 2rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .25s ease, background .25s ease, transform .2s ease;
    overflow: hidden;
    background: transparent;
}
.ept-dropzone-wrap:hover,
.ept-dropzone-wrap.drag-over {
    border-color: #6366f1;
    background: rgba(99,102,241,.05);
    transform: scale(1.008);
}
.ept-dropzone-wrap .dz-icon {
    display: block;
    font-size: 3.25rem;
    line-height: 1;
    margin-bottom: .85rem;
    transition: transform .3s ease;
}
.ept-dropzone-wrap:hover .dz-icon,
.ept-dropzone-wrap.drag-over .dz-icon {
    transform: translateY(-6px) scale(1.15);
}
.drag-over-label {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    font-weight: 700;
    color: #6366f1;
    background: rgba(99,102,241,.08);
    border-radius: 1rem;
    letter-spacing: .02em;
    pointer-events: none;
    backdrop-filter: blur(2px);
}
.ept-dropzone-wrap.drag-over .drag-over-label { display: flex; }

/* ══════════════════════════════════════════
   FILE INFO BAR
══════════════════════════════════════════ */
#ept-file-info {
    display: none;
    align-items: center;
    gap: .85rem;
    margin-top: .85rem;
    padding: .8rem 1rem;
    border-radius: .75rem;
    border: 1px solid rgba(99,102,241,.3);
    background: rgba(99,102,241,.07);
}
#ept-file-info .fi-icon { font-size: 1.6rem; flex-shrink: 0; }
#ept-file-info .fi-name {
    font-size: .88rem; font-weight: 600;
    color: #4f46e5;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 280px;
}
.dark #ept-file-info .fi-name { color: #a5b4fc; }
#ept-file-info .fi-meta { font-size: .75rem; color: #94a3b8; margin-top: .1rem; }
#ept-file-info .fi-clear {
    margin-left: auto; flex-shrink: 0;
    cursor: pointer; font-size: 1.1rem;
    color: #94a3b8;
    width: 2rem; height: 2rem;
    display: flex; align-items: center; justify-content: center;
    border-radius: .4rem;
    transition: background .15s, color .15s;
}
#ept-file-info .fi-clear:hover { background: rgba(239,68,68,.1); color: #ef4444; }

/* ══════════════════════════════════════════
   TOMBOL SUBMIT
══════════════════════════════════════════ */
#ept-submit-area {
    display: none;
    margin-top: 1.25rem;
}
.ept-btn-import {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .65rem 1.4rem;
    border-radius: .65rem;
    font-size: .875rem; font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    box-shadow: 0 4px 14px rgba(99,102,241,.38);
    border: none; cursor: pointer;
    transition: transform .2s ease, box-shadow .2s ease;
}
.ept-btn-import:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(99,102,241,.48);
}
.ept-btn-import:active { transform: translateY(0); }

/* ══════════════════════════════════════════
   PREVIEW SECTION
══════════════════════════════════════════ */
#ept-preview-section {
    display: none;
    animation: eptFadeUp .35s ease both;
}
@keyframes eptFadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.ept-preview-badge {
    display: inline-flex; align-items: center;
    padding: .18rem .65rem;
    border-radius: 9999px;
    font-size: .72rem; font-weight: 700;
    background: #e0e7ff; color: #4338ca;
    vertical-align: middle;
    margin-left: .4rem;
}
.dark .ept-preview-badge { background: #312e81; color: #a5b4fc; }

#ept-preview-table {
    width: 100%; text-align: left; font-size: .875rem;
    border-collapse: collapse;
}
#ept-preview-table thead th {
    background: #f8fafc;
    font-size: .7rem; letter-spacing: .07em;
    text-transform: uppercase;
    color: #64748b; font-weight: 700;
    padding: .65rem 1rem;
    position: sticky; top: 0; z-index: 1;
}
.dark #ept-preview-table thead th {
    background: #1e293b; color: #94a3b8;
}
#ept-preview-table tbody td {
    padding: .6rem 1rem;
    border-bottom: 1px solid #f1f5f9;
}
.dark #ept-preview-table tbody td {
    border-bottom-color: #1e293b;
    color: #cbd5e1;
}
#ept-preview-table tbody tr:hover td { background: rgba(99,102,241,.04); }
.badge-nilai {
    display: inline-flex; align-items: center;
    padding: .18rem .65rem;
    border-radius: 9999px;
    font-size: .75rem; font-weight: 700;
    background: #e0e7ff; color: #4338ca;
}
.dark .badge-nilai { background: #312e81; color: #a5b4fc; }

/* Kelas untuk sel hasil render JS — mendukung dark mode */
.ept-td-no    { color: #94a3b8; font-size: .75rem; font-weight: 500; }
.ept-td-nama  { font-weight: 600; color: #1e293b; }
.ept-td-nim   { font-family: monospace; color: #64748b; }
.dark .ept-td-nama { color: #e2e8f0; }
.dark .ept-td-nim  { color: #94a3b8; }

/* ══════════════════════════════════════════
   FORM FILAMENT (disembunyikan tapi aktif)
══════════════════════════════════════════ */
#ept-filament-form-wrap { display: none !important; }
</style>

{{-- ═══════════════════════════════════════════════════
     SECTION UPLOAD
═══════════════════════════════════════════════════ --}}
<x-filament::section>
    <x-slot name="heading">📂 Import Nilai EPT dari Excel</x-slot>
    <x-slot name="description">
        Kolom Excel harus berurutan: <strong>nama</strong> | <strong>nim</strong> | <strong>nilai</strong>.
        Baris pertama adalah <strong>header</strong>.
    </x-slot>

    {{-- Form Filament (tetap aktif agar upload ke server jalan, tapi disembunyikan visual) --}}
    <div id="ept-filament-form-wrap">
        <form wire:submit="prosesImport" id="ept-native-form">
            {{ $this->form }}
        </form>
    </div>

    {{-- Drop Zone kustom --}}
    <div class="ept-dropzone-wrap" id="ept-dropzone">
        <input type="file" id="ept-custom-input"
            accept=".xlsx,.xls,.csv"
            style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;z-index:2;">
        <div class="drag-over-label">⬇️ Lepaskan file di sini…</div>
        <span class="dz-icon">📊</span>
        <p style="font-size:1.05rem;font-weight:700;color:#374151;margin:0;">
            Drag &amp; drop file Excel di sini
        </p>
        <p style="font-size:.88rem;color:#94a3b8;margin:.35rem 0 0;">
            atau <span style="color:#6366f1;font-weight:600;text-decoration:underline;text-underline-offset:3px;">klik untuk memilih file</span>
        </p>
        <p style="font-size:.75rem;color:#cbd5e1;margin:.65rem 0 0;">Mendukung: <code>.xlsx</code> · <code>.xls</code> · <code>.csv</code></p>
    </div>

    {{-- Info file yang dipilih --}}
    <div id="ept-file-info">
        <span class="fi-icon">📄</span>
        <div style="min-width:0">
            <div class="fi-name" id="ept-fi-name"></div>
            <div class="fi-meta" id="ept-fi-meta"></div>
        </div>
        <span class="fi-clear" id="ept-fi-clear" title="Hapus">✕</span>
    </div>

    {{-- Tombol submit muncul setelah file dipilih --}}
    <div id="ept-submit-area">
        <button type="button" class="ept-btn-import" id="ept-submit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/>
                <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            Proses Import &amp; Cocokkan Data
        </button>
    </div>
</x-filament::section>

{{-- ═══════════════════════════════════════════════════
     PREVIEW EXCEL
═══════════════════════════════════════════════════ --}}
<div id="ept-preview-section">
    <x-filament::section>
        <x-slot name="heading">
            👁️ Preview Isi File Excel
            <span class="ept-preview-badge" id="ept-preview-badge"></span>
        </x-slot>
        <x-slot name="description">
            Periksa data sebelum menekan <strong>Proses Import</strong>.
            Pastikan kolom <strong>Nama</strong>, <strong>NIM</strong>, dan <strong>Nilai</strong> sudah sesuai.
        </x-slot>

        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700"
             style="max-height: 400px; overflow-y: auto;">
            <table id="ept-preview-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody id="ept-preview-body"></tbody>
            </table>
        </div>
    </x-filament::section>
</div>

{{-- ═══════════════════════════════════════════════════
     HASIL PROSES IMPORT
═══════════════════════════════════════════════════ --}}
@if ($sudahProses)
    @php
        $berhasil       = collect($hasil)->where('status', 'berhasil');
        $tidakDitemukan = collect($hasil)->where('status', 'tidak_ditemukan');
    @endphp

    {{-- Ringkasan --}}
    <div class="mt-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
        <div class="flex items-center justify-between px-5 py-4">
            <span class="text-sm text-gray-600 dark:text-gray-400">✅ Data Berhasil Diperbarui</span>
            <span class="text-sm font-bold text-success-600 dark:text-success-400">{{ $berhasil->count() }} data</span>
        </div>
        <div class="flex items-center justify-between px-5 py-4">
            <span class="text-sm text-gray-600 dark:text-gray-400">❌ NIM Tidak Ditemukan di Database</span>
            <span class="text-sm font-bold text-danger-600 dark:text-danger-400">{{ $tidakDitemukan->count() }} data</span>
        </div>
    </div>

    {{-- Tabel Berhasil --}}
    @if ($berhasil->count() > 0)
        <x-filament::section>
            <x-slot name="heading">✅ Data Berhasil — {{ $berhasil->count() }} mahasiswa</x-slot>
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
                            @php $mhs = \App\Models\Mahasiswa::where('nim', $row['nim'])->first(); @endphp
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
                                    @if ($mhs)
                                        <a href="{{ route('sertifikat.download', $mhs->id) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-white rounded-lg bg-success-600 hover:bg-success-700 transition-colors">
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

    {{-- Tabel Tidak Ditemukan --}}
    @if ($tidakDitemukan->count() > 0)
        <x-filament::section>
            <x-slot name="heading">❌ NIM Tidak Ditemukan — {{ $tidakDitemukan->count() }} data</x-slot>
            <x-slot name="description">
                NIM berikut ada di Excel tapi <strong>tidak terdaftar</strong> di database.
            </x-slot>
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">NIM</th>
                            <th class="px-4 py-3">Nama</th>
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

{{-- ═══════════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════════ --}}
<script>
(function () {
    /* ── utils ─────────────────────────────────────── */
    const esc = s => String(s ?? '')
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');

    const fmtSize = b => b < 1024 ? b+' B' : b < 1048576
        ? (b/1024).toFixed(1)+' KB' : (b/1048576).toFixed(1)+' MB';

    const findKey = (keys, candidates) =>
        keys.find(k => candidates.includes(k.toLowerCase())) ?? keys[0] ?? '';

    /* ── elemen ────────────────────────────────────── */
    const dz          = document.getElementById('ept-dropzone');
    const customInput = document.getElementById('ept-custom-input');
    const fileInfo    = document.getElementById('ept-file-info');
    const fiName      = document.getElementById('ept-fi-name');
    const fiMeta      = document.getElementById('ept-fi-meta');
    const fiClear     = document.getElementById('ept-fi-clear');
    const submitArea  = document.getElementById('ept-submit-area');
    const submitBtn   = document.getElementById('ept-submit-btn');
    const previewSec  = document.getElementById('ept-preview-section');
    const previewBody = document.getElementById('ept-preview-body');
    const previewBadge= document.getElementById('ept-preview-badge');

    let currentFile = null;

    /* ── reset ─────────────────────────────────────── */
    function reset() {
        currentFile = null;
        customInput.value = '';
        fileInfo.style.display = 'none';
        submitArea.style.display = 'none';
        previewSec.style.display = 'none';
        previewBody.innerHTML = '';
    }

    /* ── baca Excel & render preview ───────────────── */
    function processFile(file) {
        if (!file) return;
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['xlsx','xls','csv'].includes(ext)) {
            alert('Format tidak didukung. Gunakan .xlsx, .xls, atau .csv');
            return;
        }
        currentFile = file;

        // tampilkan info file
        fiName.textContent = file.name;
        fiMeta.textContent = fmtSize(file.size) + ' · ' + new Date().toLocaleTimeString('id-ID');
        fileInfo.style.display = 'flex';

        // baca dengan SheetJS
        const reader = new FileReader();
        reader.onload = function (ev) {
            try {
                const wb   = XLSX.read(new Uint8Array(ev.target.result), { type: 'array' });
                const ws   = wb.Sheets[wb.SheetNames[0]];
                const rows = XLSX.utils.sheet_to_json(ws, { defval: '' });

                if (!rows.length) {
                    alert('File Excel kosong atau tidak ada data.');
                    reset(); return;
                }

                const keys    = Object.keys(rows[0]);
                const keyNama = findKey(keys, ['nama','name']);
                const keyNim  = findKey(keys, ['nim']);
                const keyVal  = findKey(keys, ['nilai','value','score','skor']);

                previewBody.innerHTML = '';
                rows.forEach((row, i) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML =
                        `<td class="ept-td-no">${i+1}</td>` +
                        `<td class="ept-td-nama">${esc(row[keyNama])}</td>` +
                        `<td class="ept-td-nim">${esc(row[keyNim])}</td>` +
                        `<td><span class="badge-nilai">${esc(row[keyVal])}</span></td>`;
                    previewBody.appendChild(tr);
                });

                previewBadge.textContent = rows.length + ' baris';
                previewSec.style.display = 'block';
                submitArea.style.display = 'block';

                // inject file ke Filament FileUpload (input[type=file] asli)
                injectToFilamentInput(file);

                // scroll halus ke preview
                setTimeout(() => previewSec.scrollIntoView({ behavior:'smooth', block:'nearest' }), 150);

            } catch (err) {
                console.error(err);
                alert('Gagal membaca file Excel. Pastikan file tidak rusak.');
                reset();
            }
        };
        reader.readAsArrayBuffer(file);
    }

    /* ── inject file ke input Filament yang tersembunyi ── */
    function injectToFilamentInput(file) {
        // Filament FileUpload menggunakan Filepond di dalam form tersembunyi
        // Kita cukup pastikan pengiriman lewat tombol submit custom kita
        // yang akan trigger prosesImport() Livewire secara manual
    }

    /* ── event: pilih file via klik ────────────────── */
    customInput.addEventListener('change', function () {
        if (this.files?.[0]) processFile(this.files[0]);
    });

    /* ── event: drag ───────────────────────────────── */
    ['dragenter','dragover'].forEach(ev => dz.addEventListener(ev, e => {
        e.preventDefault(); e.stopPropagation();
        dz.classList.add('drag-over');
    }));
    ['dragleave','dragend'].forEach(ev => dz.addEventListener(ev, e => {
        e.preventDefault(); e.stopPropagation();
        dz.classList.remove('drag-over');
    }));
    dz.addEventListener('drop', function (e) {
        e.preventDefault(); e.stopPropagation();
        dz.classList.remove('drag-over');
        const file = e.dataTransfer?.files?.[0];
        if (file) processFile(file);
    });

    /* ── hapus file ─────────────────────────────────── */
    fiClear.addEventListener('click', reset);

    /* ── submit: upload via Filament FileUpload asli ── */
    submitBtn.addEventListener('click', function () {
        if (!currentFile) { alert('Pilih file terlebih dahulu!'); return; }

        // Temukan input[type=file] milik Filament
        const filamentInput = document.querySelector('#ept-filament-form-wrap input[type="file"]');
        if (filamentInput) {
            const dt = new DataTransfer();
            dt.items.add(currentFile);
            filamentInput.files = dt.files;
            filamentInput.dispatchEvent(new Event('change', { bubbles: true }));

            // Tunggu Livewire upload selesai, lalu submit
            setTimeout(() => {
                document.getElementById('ept-native-form').dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
            }, 800);
        } else {
            // Fallback: langsung submit
            @this.call('prosesImport');
        }
    });

})();
</script>

</x-filament-panels::page>
