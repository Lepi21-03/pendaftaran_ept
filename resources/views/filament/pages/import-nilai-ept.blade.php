<x-filament-panels::page>

{{-- SheetJS: membaca Excel di sisi browser untuk preview --}}
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
    pointer-events: none;
    backdrop-filter: blur(2px);
}
.ept-dropzone-wrap.drag-over .drag-over-label { display: flex; }

/* FILE INFO BAR */
.ept-file-info {
    display: none;
    align-items: center;
    gap: .85rem;
    margin-top: .85rem;
    padding: .8rem 1rem;
    border-radius: .75rem;
    border: 1px solid rgba(99,102,241,.3);
    background: rgba(99,102,241,.07);
}
.ept-fi-name {
    font-size: .88rem; font-weight: 600; color: #4f46e5;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px;
}
.dark .ept-fi-name { color: #a5b4fc; }
.ept-fi-meta { font-size: .75rem; color: #94a3b8; margin-top: .1rem; }
.ept-fi-clear {
    margin-left: auto; cursor: pointer; font-size: 1.1rem; color: #94a3b8;
    width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center;
    border-radius: .4rem; transition: background .15s, color .15s;
    border: none; background: transparent;
}
.ept-fi-clear:hover { background: rgba(239,68,68,.1); color: #ef4444; }

/* PROGRESS BAR */
.ept-progress-wrap {
    display: none;
    margin-top: .85rem;
    padding: .8rem 1rem;
    border-radius: .75rem;
    border: 1px solid rgba(99,102,241,.3);
    background: rgba(99,102,241,.07);
}
.ept-progress-track {
    width: 100%; background: #e2e8f0; border-radius: 9999px;
    height: 6px; margin-top: .5rem; overflow: hidden;
}
.ept-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #6366f1, #4f46e5);
    border-radius: 9999px; transition: width .3s ease; width: 0%;
}
.ept-progress-label {
    font-size: .8rem; color: #64748b;
    display: flex; justify-content: space-between;
}
.ept-progress-label b { color: #4f46e5; }

/* SUBMIT BUTTON */
.ept-submit-area { display: none; margin-top: 1.25rem; align-items: center; gap: 1rem; }
.ept-btn-import {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .65rem 1.4rem; border-radius: .65rem;
    font-size: .875rem; font-weight: 700; color: #fff;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    box-shadow: 0 4px 14px rgba(99,102,241,.38);
    border: none; cursor: pointer;
    transition: transform .2s ease, box-shadow .2s ease;
}
.ept-btn-import:hover  { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(99,102,241,.48); }
.ept-btn-import:active { transform: translateY(0); }
.ept-btn-import:disabled { opacity: .55; cursor: not-allowed; transform: none; box-shadow: none; }

/* PREVIEW */
.ept-preview-section { display: none; animation: eptFadeUp .35s ease both; }
@keyframes eptFadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.ept-preview-badge {
    display: inline-flex; padding: .18rem .65rem; border-radius: 9999px;
    font-size: .72rem; font-weight: 700; background: #e0e7ff; color: #4338ca;
    vertical-align: middle; margin-left: .4rem;
}
.dark .ept-preview-badge { background: #312e81; color: #a5b4fc; }
.ept-preview-table { width: 100%; text-align: left; font-size: .875rem; border-collapse: collapse; }
.ept-preview-table thead th {
    background: #f8fafc; font-size: .7rem; letter-spacing: .07em;
    text-transform: uppercase; color: #64748b; font-weight: 700;
    padding: .65rem 1rem; position: sticky; top: 0; z-index: 1;
}
.dark .ept-preview-table thead th { background: #1e293b; color: #94a3b8; }
.ept-preview-table tbody td { padding: .6rem 1rem; border-bottom: 1px solid #f1f5f9; }
.dark .ept-preview-table tbody td { border-bottom-color: #1e293b; color: #cbd5e1; }
.ept-preview-table tbody tr:hover td { background: rgba(99,102,241,.04); }
.badge-nilai {
    display: inline-flex; padding: .18rem .65rem; border-radius: 9999px;
    font-size: .75rem; font-weight: 700; background: #e0e7ff; color: #4338ca;
}
.dark .badge-nilai { background: #312e81; color: #a5b4fc; }
.ept-td-no   { color: #94a3b8; font-size: .75rem; font-weight: 500; }
.ept-td-nama { font-weight: 600; color: #1e293b; }
.ept-td-nim  { font-family: monospace; color: #64748b; }
.dark .ept-td-nama { color: #e2e8f0; }
.dark .ept-td-nim  { color: #94a3b8; }
</style>

{{-- ═══════════════════════════════════════════════════
     SECTION UPLOAD  ← wire:ignore agar Livewire tidak
     perlu morphing DOM bagian ini setiap update state
═══════════════════════════════════════════════════ --}}
<x-filament::section>
    <x-slot name="heading">📂 Import Nilai EPT dari Excel</x-slot>
    <x-slot name="description">
        Mendukung format file Excel. Kolom bisa menggunakan nama relevan:<br>
        <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 py-0.5 rounded">
            Nama | NIM/Barcode | Tanggal (testDate) | Listening | Structure | Reading | Total
        </code><br>
        *Tidak harus persis dan tidak sensitif huruf besar/kecil.
    </x-slot>

    {{-- wire:ignore mencegah Livewire me-morph bagian ini saat re-render --}}
    <div wire:ignore>

        {{-- Input file native, tersembunyi --}}
        <input type="file" id="ept-file-input" accept=".xlsx,.xls,.csv" style="display:none;">

        {{-- Drop Zone --}}
        <div class="ept-dropzone-wrap" id="ept-dropzone">
            <div class="drag-over-label">⬇️ Lepaskan file di sini…</div>
            <span class="dz-icon">📊</span>
            <p style="font-size:1.05rem;font-weight:700;color:#374151;margin:0;">
                Drag &amp; drop file Excel di sini
            </p>
            <p style="font-size:.88rem;color:#94a3b8;margin:.35rem 0 0;">
                atau <span style="color:#6366f1;font-weight:600;text-decoration:underline;text-underline-offset:3px;">klik untuk memilih file</span>
            </p>
            <p style="font-size:.75rem;color:#cbd5e1;margin:.65rem 0 0;">
                Mendukung: <code>.xlsx</code> · <code>.xls</code> · <code>.csv</code>
            </p>
        </div>

        {{-- Info file setelah dipilih --}}
        <div class="ept-file-info" id="ept-file-info">
            <span style="font-size:1.6rem;flex-shrink:0;">📄</span>
            <div style="min-width:0">
                <div class="ept-fi-name" id="ept-fi-name"></div>
                <div class="ept-fi-meta" id="ept-fi-meta"></div>
            </div>
            <button type="button" class="ept-fi-clear" id="ept-fi-clear" title="Hapus">✕</button>
        </div>

        {{-- Progress upload (muncul saat tombol diklik) --}}
        <div class="ept-progress-wrap" id="ept-progress-wrap">
            <div class="ept-progress-label">
                <span id="ept-progress-text">Mengupload ke server…</span>
                <b id="ept-progress-pct">0%</b>
            </div>
            <div class="ept-progress-track">
                <div class="ept-progress-fill" id="ept-progress-fill"></div>
            </div>
        </div>

        {{-- Tombol submit (muncul setelah file dipilih & preview siap) --}}
        <div class="ept-submit-area" id="ept-submit-area">
            <button type="button" class="ept-btn-import" id="ept-submit-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                Proses Import &amp; Cocokkan Data
            </button>
            <span id="ept-processing-text" style="display:none;font-size:.85rem;color:#64748b;">
                ⏳ Sedang memproses…
            </span>
        </div>

        {{-- Preview Excel --}}
        <div class="ept-preview-section" id="ept-preview-section" style="margin-top:1.5rem;">
            <div style="font-size:.8rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">
                👁️ Preview File Excel
                <span class="ept-preview-badge" id="ept-preview-badge"></span>
            </div>
            <div style="overflow-x:auto;border-radius:.75rem;border:1px solid #e2e8f0;max-height:350px;overflow-y:auto;">
                <table class="ept-preview-table">
                    <thead>
                        <tr>
                            <th style="width:40px">#</th>
                            <th>Nama</th>
                            <th>NIM / Barcode</th>
                            <th>Test Date</th>
                            <th>Listening</th>
                            <th>Structure</th>
                            <th>Reading</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="ept-preview-body"></tbody>
                </table>
            </div>
        </div>

    </div>{{-- end wire:ignore --}}

</x-filament::section>

{{-- ═══════════════════════════════════════════════════
     HASIL PROSES IMPORT
═══════════════════════════════════════════════════ --}}
@if ($sudahProses)
    @php
        $berhasil       = collect($hasil)->where('status', 'berhasil');
        $tidakDitemukan = collect($hasil)->where('status', 'tidak_ditemukan');
    @endphp

    <div class="mt-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
        <div class="flex items-center justify-between px-5 py-4">
            <span class="text-sm text-gray-600 dark:text-gray-400">✅ Data Berhasil Diperbarui</span>
            <span class="text-sm font-bold text-success-600 dark:text-success-400">{{ $berhasil->count() }} data</span>
        </div>
        <div class="flex items-center justify-between px-5 py-4">
            <span class="text-sm text-gray-600 dark:text-gray-400">❌ Nama Tidak Ditemukan di Database</span>
            <span class="text-sm font-bold text-danger-600 dark:text-danger-400">{{ $tidakDitemukan->count() }} data</span>
        </div>
    </div>

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
                            <th class="px-3 py-3">Tgl Ujian</th>
                            <th class="px-3 py-3">List</th>
                            <th class="px-3 py-3">Struc</th>
                            <th class="px-3 py-3">Read</th>
                            <th class="px-4 py-3">Total</th>
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
                                <td class="px-3 py-3 text-gray-500 text-xs">{{ $row['test_date'] }}</td>
                                <td class="px-3 py-3">{{ $row['listening'] }}</td>
                                <td class="px-3 py-3">{{ $row['structure'] }}</td>
                                <td class="px-3 py-3">{{ $row['reading'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full bg-success-100 text-success-800 dark:bg-success-900 dark:text-success-200">
                                        {{ $row['total'] }}
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

    @if ($tidakDitemukan->count() > 0)
        <x-filament::section>
            <x-slot name="heading">❌ Nama Tidak Ditemukan — {{ $tidakDitemukan->count() }} data</x-slot>
            <x-slot name="description">
                Nama berikut ada di Excel tapi <strong>tidak terdaftar</strong> di database.
            </x-slot>
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">NIM</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($tidakDitemukan->values() as $i => $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-mono font-semibold text-danger-600">{{ $row['nim'] }}</td>
                                <td class="px-4 py-3">{{ $row['nama'] }}</td>
                                <td class="px-4 py-3">{{ $row['total'] }}</td>
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
    'use strict';

    /* ── Utility ── */
    const esc = s => String(s ?? '')
        .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    const fmtSize = b => b < 1024 ? b+' B' : b < 1048576
        ? (b/1024).toFixed(1)+' KB' : (b/1048576).toFixed(1)+' MB';

    /* ── DOM refs ── */
    const dz          = document.getElementById('ept-dropzone');
    const fileInfo    = document.getElementById('ept-file-info');
    const fiName      = document.getElementById('ept-fi-name');
    const fiMeta      = document.getElementById('ept-fi-meta');
    const fiClear     = document.getElementById('ept-fi-clear');
    const submitArea  = document.getElementById('ept-submit-area');
    const submitBtn   = document.getElementById('ept-submit-btn');
    const procText    = document.getElementById('ept-processing-text');
    const previewSec  = document.getElementById('ept-preview-section');
    const previewBody = document.getElementById('ept-preview-body');
    const previewBadge= document.getElementById('ept-preview-badge');
    const progWrap    = document.getElementById('ept-progress-wrap');
    const progFill    = document.getElementById('ept-progress-fill');
    const progPct     = document.getElementById('ept-progress-pct');
    const progText    = document.getElementById('ept-progress-text');

    /* ── State ── */
    let currentFile = null;   // file yang dipilih user (belum tentu di-upload)

    /* ════════════════════════════════
       FUNGSI UTAMA: BUKA FILE PICKER
    ════════════════════════════════ */
    function openFilePicker() {
        // Buat input baru setiap kali klik supaya browser tidak block
        const inp = document.createElement('input');
        inp.type   = 'file';
        inp.accept = '.xlsx,.xls,.csv';
        inp.style.display = 'none';
        inp.addEventListener('change', function () {
            if (this.files?.[0]) {
                handleFile(this.files[0]);
            }
            // Hapus dari DOM setelah selesai
            inp.remove();
        });
        document.body.appendChild(inp);
        inp.click();
    }

    /* ════════════════════════════════
       HANDLE FILE: preview lokal saja
       TIDAK upload ke server di sini!
    ════════════════════════════════ */
    function handleFile(file) {
        const ext = file.name.split('.').pop().toLowerCase();
        if (!['xlsx','xls','csv'].includes(ext)) {
            alert('Format tidak didukung. Gunakan .xlsx, .xls, atau .csv');
            return;
        }

        currentFile = file;

        // Tampilkan info file
        fiName.textContent = file.name;
        fiMeta.textContent = fmtSize(file.size) + ' · ' + new Date().toLocaleTimeString('id-ID');
        fileInfo.style.display = 'flex';

        // Preview pakai SheetJS (baca di browser, tidak menyentuh server)
        const reader  = new FileReader();
        reader.onload = function (ev) {
            try {
                const wb   = XLSX.read(new Uint8Array(ev.target.result), { type: 'array' });
                const ws   = wb.Sheets[wb.SheetNames[0]];
                const rows = XLSX.utils.sheet_to_json(ws, { defval: '' });

                if (!rows.length) { alert('File Excel kosong.'); resetUI(); return; }

                // Fungsi cari nilai dari header yang fleksibel
                const findVal = (row, candidates) => {
                    const keys = Object.keys(row);
                    for (const c of candidates) {
                        const norm = s => s.toLowerCase().replace(/[^a-z0-9]/g,'');
                        const k = keys.find(k => norm(k) === norm(c));
                        if (k !== undefined && row[k] !== undefined) return row[k];
                    }
                    return '';
                };

                previewBody.innerHTML = '';
                rows.forEach((row, i) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML =
                        `<td class="ept-td-no">${i+1}</td>` +
                        // Nama: kolom "name" di Excel
                        `<td class="ept-td-nama">${esc(findVal(row,['name','nama','fullname']))}</td>` +
                        // NIM: kolom "RegNumber" ATAU "Barcode" di Excel
                        `<td class="ept-td-nim">${esc(findVal(row,['RegNumber','regnumber','Barcode','barcode','nim']))}</td>` +
                        // Tanggal: kolom "testDate" di Excel
                        `<td style="font-size:.8rem;color:#64748b">${esc(findVal(row,['testDate','testdate','test_date','date']))}</td>` +
                        // Listening: kolom "Listening" di Excel
                        `<td><span class="badge-nilai">${esc(findVal(row,['Listening','listening','Listening Comprehension','listening_comprehension']))}</span></td>` +
                        // Structure: kolom "structure and written expression" di Excel
                        `<td><span class="badge-nilai">${esc(findVal(row,['structure and written expression','Structure','structure','structureandwrittenexpression']))}</span></td>` +
                        // Reading: kolom "reading" di Excel
                        `<td><span class="badge-nilai">${esc(findVal(row,['reading','Reading','Reading Comprehension']))}</span></td>` +
                        // Total: kolom "Total" di Excel
                        `<td><span class="badge-nilai" style="background:#dcfce7;color:#166534">${esc(findVal(row,['Total','total','Total Score']))}</span></td>`;
                    previewBody.appendChild(tr);
                });

                previewBadge.textContent = rows.length + ' baris';
                previewSec.style.display  = 'block';
                submitArea.style.display  = 'flex';

                setTimeout(() => previewSec.scrollIntoView({ behavior:'smooth', block:'nearest' }), 150);

            } catch (err) {
                console.error(err);
                alert('Gagal membaca file. Pastikan file Excel tidak rusak.');
                resetUI();
            }
        };

        reader.onerror = () => { alert('Gagal membaca file.'); resetUI(); };
        reader.readAsArrayBuffer(file);
    }

    /* ════════════════════════════════
       RESET UI (tanpa ganggu Livewire)
    ════════════════════════════════ */
    function resetUI() {
        currentFile = null;
        fileInfo.style.display   = 'none';
        submitArea.style.display = 'none';
        progWrap.style.display   = 'none';
        previewSec.style.display = 'none';
        previewBody.innerHTML    = '';
        progFill.style.width     = '0%';
        progPct.textContent      = '0%';
        submitBtn.disabled       = false;
        procText.style.display   = 'none';
    }

    /* ════════════════════════════════
       EVENT: klik dropzone
    ════════════════════════════════ */
    dz.addEventListener('click', openFilePicker);

    /* ════════════════════════════════
       EVENT: drag & drop
    ════════════════════════════════ */
    ['dragenter','dragover'].forEach(e => dz.addEventListener(e, ev => {
        ev.preventDefault(); ev.stopPropagation(); dz.classList.add('drag-over');
    }));
    ['dragleave','dragend'].forEach(e => dz.addEventListener(e, ev => {
        ev.preventDefault(); ev.stopPropagation(); dz.classList.remove('drag-over');
    }));
    dz.addEventListener('drop', ev => {
        ev.preventDefault(); ev.stopPropagation();
        dz.classList.remove('drag-over');
        const f = ev.dataTransfer?.files?.[0];
        if (f) handleFile(f);
    });

    /* ════════════════════════════════
       EVENT: hapus file
    ════════════════════════════════ */
    fiClear.addEventListener('click', resetUI);

    /* ════════════════════════════════
       EVENT: tombol "Proses Import"
       Upload ke server BARU di sini,
       setelah user yakin dengan data.
    ════════════════════════════════ */
    submitBtn.addEventListener('click', function () {
        if (!currentFile) { alert('Pilih file terlebih dahulu!'); return; }

        // Tampilkan progress, sembunyikan tombol
        submitBtn.disabled       = true;
        procText.style.display   = 'inline';
        progWrap.style.display   = 'block';
        progFill.style.width     = '0%';
        progPct.textContent      = '0%';
        progText.textContent     = 'Mengupload file ke server…';

        // ── upload via Livewire wire.upload ────────────────────
        @this.upload(
            'fileExcel',
            currentFile,

            // ✅ Upload selesai → panggil prosesImport di PHP
            function () {
                progText.textContent = 'Memproses data Excel…';
                progFill.style.width = '100%';
                progPct.textContent  = '100%';

                @this.call('prosesImport').then(function () {
                    // Setelah Livewire selesai re-render, reset UI
                    setTimeout(resetUI, 400);
                }).catch(function (err) {
                    console.error('prosesImport error:', err);
                    alert('Terjadi kesalahan saat memproses. Coba lagi.');
                    resetUI();
                });
            },

            // ❌ Upload gagal
            function (error) {
                console.error('Upload gagal:', error);
                alert('Gagal mengupload file ke server. Pastikan ukuran file tidak terlalu besar.');
                resetUI();
            },

            // ⏳ Progress upload
            function (event) {
                const pct = Math.round(event.detail.progress ?? 0);
                progFill.style.width = pct + '%';
                progPct.textContent  = pct + '%';
            }
        );
    });

})();
</script>

</x-filament-panels::page>
