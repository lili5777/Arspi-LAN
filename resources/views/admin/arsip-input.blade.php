@extends('admin.partials.layout')

@section('title', $kategori->name . ' - ' . $tahunDetail->name)
@section('page-title', $kategori->name)
@section('page-subtitle', 'Manajemen Data Arsip • ' . $kategoriDetail->name . ' • ' . $tahunDetail->name)

@section('styles')
<style>
    .breadcrumb {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 24px; font-size: 13px; color: var(--gray); flex-wrap: wrap;
    }
    .breadcrumb a { color: var(--primary-light); text-decoration: none; }
    .breadcrumb a:hover { color: var(--primary); }
    .breadcrumb-separator { color: rgba(255,255,255,0.2); }
    .breadcrumb-current { color: white; font-weight: 500; }

    .page-header {
        background: var(--dark-light); border: 1px solid rgba(255,255,255,0.05);
        border-radius: var(--radius-lg); padding: 24px; margin-bottom: 32px;
        display: flex; align-items: center; gap: 20px;
    }
    .page-header-icon {
        width: 64px; height: 64px; border-radius: var(--radius-lg);
        background: linear-gradient(135deg, rgba(183,163,227,0.15) 0%, rgba(183,163,227,0.25) 100%);
        display: flex; align-items: center; justify-content: center;
        color: var(--primary-light); font-size: 28px;
    }
    .page-header-info h1 { font-size: 22px; font-weight: 700; color: white; margin-bottom: 4px; }
    .page-header-info p  { font-size: 13px; color: var(--gray); margin: 0; }

    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px; margin-bottom: 32px;
    }
    .stat-card {
        background: var(--dark-light); border: 1px solid rgba(255,255,255,0.05);
        border-radius: var(--radius-lg); padding: 20px; transition: all 0.2s ease;
    }
    .stat-card:hover { border-color: rgba(183,163,227,0.2); transform: translateY(-2px); }
    .stat-icon {
        width: 38px; height: 38px; border-radius: var(--radius-md);
        background: linear-gradient(135deg, rgba(183,163,227,0.1) 0%, rgba(183,163,227,0.2) 100%);
        display: flex; align-items: center; justify-content: center;
        color: var(--primary-light); font-size: 15px; margin-bottom: 14px;
    }
    .stat-value { font-size: 26px; font-weight: 700; color: white; margin-bottom: 4px; }
    .stat-label { font-size: 12px; color: var(--gray); }

    .section-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
    }
    .section-title {
        font-size: 17px; font-weight: 600; color: white; position: relative; padding-left: 12px;
    }
    .section-title::before {
        content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
        width: 3px; height: 16px;
        background: linear-gradient(to bottom, var(--primary), var(--primary-light));
        border-radius: var(--radius-full);
    }

    .search-bar { position: relative; margin-bottom: 16px; }
    .search-input {
        width: 100%; padding: 10px 16px 10px 42px;
        background: var(--dark-light); border: 1px solid rgba(255,255,255,0.08);
        border-radius: var(--radius-md); color: white; font-size: 13px;
    }
    .search-input:focus { border-color: var(--primary); outline: none; }
    .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--gray); font-size: 13px; }

    /* Table scroll wrapper */
    .table-wrapper {
        background: var(--dark-light); border: 1px solid rgba(255,255,255,0.05);
        border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 60px;
    }
    .table-scroll { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; min-width: 1400px; }
    .table thead { background: rgba(255,255,255,0.02); border-bottom: 1px solid rgba(255,255,255,0.05); }
    .table th {
        padding: 13px 14px; text-align: left; font-size: 11px; font-weight: 600;
        color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;
    }
    .table td {
        padding: 13px 14px; border-bottom: 1px solid rgba(255,255,255,0.04);
        font-size: 13px; color: white; vertical-align: top;
    }
    .table tbody tr:hover { background: rgba(183,163,227,0.04); }
    .table tbody tr:last-child td { border-bottom: none; }

    .td-no { width: 50px; text-align: center; color: var(--gray); }
    .td-kode { width: 120px; }
    .td-uraian { min-width: 250px; }
    .uraian-text { line-height: 1.5; }
    .td-waktu { width: 120px; }
    .td-jumlah { width: 80px; }
    .td-jenis { width: 100px; }
    .td-tingkat { width: 120px; }
    .td-tanggal { width: 110px; }
    .td-extra { min-width: 120px; }
    .td-ket { min-width: 150px; color: var(--gray); font-size: 12px; }
    .td-aksi { width: 90px; }

    .badge {
        display: inline-block; padding: 3px 8px; border-radius: var(--radius-full);
        font-size: 11px; font-weight: 500;
    }
    .badge-good  { background: rgba(139,202,157,0.15); color: var(--success); }
    .badge-rusak { background: rgba(227,163,163,0.15); color: var(--danger); }
    .badge-default { background: rgba(183,163,227,0.1); color: var(--primary-light); }

    .row-actions { display: flex; gap: 5px; }
    .btn-icon {
        width: 30px; height: 30px; border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);
        color: var(--gray); cursor: pointer; transition: all 0.2s ease; font-size: 12px;
    }
    .btn-icon:hover { transform: scale(1.1); }
    .btn-icon.edit:hover   { color: var(--success); background: rgba(139,202,157,0.08); }
    .btn-icon.delete:hover { color: var(--danger);  background: rgba(227,163,163,0.08); }

    .empty-state { text-align: center; padding: 60px 30px; }
    .empty-state i { font-size: 44px; color: var(--primary-light); margin-bottom: 16px; opacity: 0.6; }
    .empty-state h3 { font-size: 17px; font-weight: 600; color: white; margin-bottom: 8px; }
    .empty-state p  { font-size: 13px; color: var(--gray); }

    /* Modal — lebar lebih besar untuk banyak field */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(42,27,74,0.9); backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center; z-index: 1000; padding: 20px;
    }
    .modal-content {
        background: var(--dark-light); border-radius: var(--radius-xl); padding: 28px;
        max-width: 900px; width: 100%; border: 1px solid rgba(183,163,227,0.15);
        box-shadow: var(--shadow-xl); max-height: 90vh; overflow-y: auto;
    }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-header h3 { font-size: 17px; font-weight: 600; color: white; }
    .btn-close {
        width: 30px; height: 30px; border-radius: var(--radius-md);
        background: rgba(183,163,227,0.08); border: 1px solid rgba(183,163,227,0.15);
        color: var(--gray); display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s ease;
    }
    .btn-close:hover { color: white; }

    /* Grid 2 kolom untuk form */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-grid .span-2 { grid-column: 1 / -1; }
    .form-group { margin-bottom: 0; }
    .form-label { display: block; font-size: 12px; font-weight: 500; color: rgba(255,255,255,0.7); margin-bottom: 5px; }
    .form-label span { color: var(--danger); }
    .form-input {
        width: 100%; padding: 9px 12px;
        background: rgba(183,163,227,0.05); border: 1px solid rgba(183,163,227,0.15);
        border-radius: var(--radius-md); color: white; font-size: 13px; transition: all 0.2s ease;
    }
    .form-input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 2px rgba(183,163,227,0.15); }
    textarea.form-input { resize: vertical; min-height: 75px; }
    select.form-input option { background: #1e1040; }
    .invalid-feedback { display: none; color: var(--danger); font-size: 11px; margin-top: 3px; }

    .section-divider {
        grid-column: 1 / -1; border: none;
        border-top: 1px solid rgba(183,163,227,0.1); margin: 4px 0;
    }
    .section-label {
        grid-column: 1 / -1; font-size: 11px; font-weight: 600;
        color: var(--primary-light); text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: -4px;
    }

    .form-footer {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 20px; padding-top: 18px; border-top: 1px solid rgba(183,163,227,0.1);
    }

    .fab {
        position: fixed; bottom: 20px; right: 20px; width: 48px; height: 48px;
        border-radius: var(--radius-full);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white; border: none; font-size: 18px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 20px rgba(183,163,227,0.4); transition: all 0.2s ease; z-index: 100;
    }
    .fab:hover { transform: translateY(-3px) rotate(90deg); }

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .span-2 { grid-column: 1; }
        .page-header { flex-direction: column; text-align: center; }
        .section-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<nav class="breadcrumb">
    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('kategori.detail.index', $kategori->id) }}">{{ $kategori->name }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('kategori.detail.tahun.index', [$kategori->id, $kategoriDetail->id]) }}">{{ $kategoriDetail->name }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-current">{{ $tahunDetail->name }}</span>
</nav>

<!-- Header -->
<div class="page-header">
    <div class="page-header-icon">
        <i class="{{ $kategori->icon ?? 'fas fa-list-alt' }}"></i>
    </div>
    <div class="page-header-info">
        <h1>{{ $kategori->name }} — {{ $tahunDetail->name }}</h1>
        <p>{{ $kategoriDetail->name }} • {{ $kategori->desc }}</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-list"></i></div>
        <div class="stat-value" id="totalInput">{{ $totalInput }}</div>
        <div class="stat-label">Total Data Arsip</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value" id="latestUpdate">-</div>
        <div class="stat-label">Update Terakhir</div>
    </div>
</div>

<!-- Section -->
<div class="section-header">
    <h2 class="section-title">Daftar Arsip</h2>
    <div style="display:flex; gap:10px;">
        <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
        @if($userRole === 'admin')
        <button class="btn btn-primary" id="addBtn"><i class="fas fa-plus"></i> Tambah Data</button>
        @endif
    </div>
</div>

<div class="search-bar">
    <i class="fas fa-search search-icon"></i>
    <input type="text" class="search-input" id="searchInput" placeholder="Cari uraian, kode klasifikasi...">
</div>

<div class="table-wrapper">
    <div class="table-scroll">
        <table class="table">
            <thead>
                @if($kategori->name === 'Daftar Arsip Usul Musnah')
                <tr>
                    <th class="td-no">No</th>
                    <th class="td-kode">Kode Klasifikasi</th>
                    <th class="td-uraian">Uraian Informasi</th>
                    <th class="td-waktu">Kurun Waktu</th>
                    <th class="td-tingkat">Tingkat Perkembangan</th>
                    <th class="td-jumlah">Jumlah</th>
                    <th class="td-extra">No. Box</th>
                    <th class="td-extra">Media Simpan</th>
                    <th class="td-extra">Kondisi Fisik</th>
                    <th class="td-extra">Nomor Folder</th>
                    <th class="td-extra">Jangka Simpan</th>
                    <th class="td-extra">Nasib Akhir Arsip</th>
                    <th class="td-extra">Lbr</th>
                    <th class="td-ket">Ket</th>
                    @if($userRole === 'admin')
                    <th class="td-aksi">Aksi</th>
                    @endif
                </tr>
                @else
                <tr>
                    <th class="td-no">No.</th>
                    <th class="td-jenis">Jenis Arsip</th>
                    <th class="td-extra">No Box</th>
                    <th class="td-extra">No Berkas</th>
                    <th class="td-extra">No. Perjanjian Kerjasama</th>
                    <th class="td-extra">Pihak I</th>
                    <th class="td-extra">Pihak II</th>
                    <th class="td-tingkat">Tingkat Perkembangan</th>
                    <th class="td-tanggal">Tanggal Berlaku</th>
                    <th class="td-tanggal">Tanggal Berakhir</th>
                    <th class="td-extra">Media</th>
                    <th class="td-jumlah">Jumlah</th>
                    <th class="td-extra">Jangka Simpan</th>
                    <th class="td-extra">Lokasi Simpan</th>
                    <th class="td-extra">Metode Perlindungan</th>
                    <th class="td-ket">Ket</th>
                    @if($userRole === 'admin')
                    <th class="td-aksi">Aksi</th>
                    @endif
                </tr>
                @endif
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>
</div>

@if($userRole === 'admin')
<button class="fab" id="fabBtn"><i class="fas fa-plus"></i></button>
@endif

<!-- Modal -->
<div class="modal-overlay" id="mainModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Data Arsip</h3>
            <button class="btn-close" id="closeModalBtn"><i class="fas fa-times"></i></button>
        </div>
        <form id="mainForm">
            @csrf
            <input type="hidden" id="itemId">
            
            @if($kategori->name === 'Daftar Arsip Usul Musnah')
            <div class="form-grid">
                {{-- Baris 1: No & Kode Klasifikasi --}}
                <div class="form-group">
                    <label class="form-label">No <span>*</span></label>
                    <input type="number" class="form-input" id="fNo" name="no" min="1" required>
                    <div class="invalid-feedback" id="noError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Klasifikasi</label>
                    <input type="text" class="form-input" id="fKodeKlasifikasi" name="kode_klasifikasi" placeholder="Contoh: 600.1">
                    <div class="invalid-feedback" id="kode_klasifikasiError"></div>
                </div>

                {{-- Uraian Informasi --}}
                <div class="form-group span-2">
                    <label class="form-label">Uraian Informasi <span>*</span></label>
                    <textarea class="form-input" id="fUraian" name="uraian_informasi" required placeholder="Deskripsi arsip..."></textarea>
                    <div class="invalid-feedback" id="uraian_informasiError"></div>
                </div>

                {{-- Kurun Waktu & Tingkat Perkembangan --}}
                <div class="form-group">
                    <label class="form-label">Kurun Waktu</label>
                    <input type="text" class="form-input" id="fKurun" name="kurun_waktu" placeholder="Contoh: 2020 - 2024">
                    <div class="invalid-feedback" id="kurun_waktuError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat Perkembangan</label>
                    <select class="form-input" id="fTingkat" name="tingkat_perkembangan">
                        <option value="">-- Pilih --</option>
                        <option value="Asli">Asli</option>
                        <option value="Fotokopi">Fotokopi</option>
                        <option value="Salinan">Salinan</option>
                        <option value="Tembusan">Tembusan</option>
                    </select>
                </div>

                {{-- Jumlah & No. Box --}}
                <div class="form-group">
                    <label class="form-label">Jumlah <span>*</span></label>
                    <input type="text" class="form-input" id="fJumlah" name="jumlah" required placeholder="Contoh: 5 Berkas">
                    <div class="invalid-feedback" id="jumlahError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">No. Box</label>
                    <input type="text" class="form-input" id="fNoBox" name="no_box" placeholder="Contoh: B-001">
                </div>

                {{-- Media Simpan & Kondisi Fisik --}}
                <div class="form-group">
                    <label class="form-label">Media Simpan</label>
                    <select class="form-input" id="fMediaSimpan" name="media_simpan">
                        <option value="">-- Pilih --</option>
                        <option value="Kertas">Kertas</option>
                        <option value="Digital">Digital</option>
                        <option value="Mikrofilm">Mikrofilm</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Kondisi Fisik</label>
                    <select class="form-input" id="fKondisi" name="kondisi_fisik">
                        <option value="">-- Pilih --</option>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>

                {{-- Nomor Folder & Jangka Simpan --}}
                <div class="form-group">
                    <label class="form-label">Nomor Folder</label>
                    <input type="text" class="form-input" id="fNomorFolder" name="nomor_folder" placeholder="Contoh: F-001">
                </div>
                <div class="form-group">
                    <label class="form-label">Jangka Simpan <span>*</span></label>
                    <input type="text" class="form-input" id="fJangka" name="jangka_simpan" required placeholder="Contoh: 5 Tahun">
                    <div class="invalid-feedback" id="jangka_simpanError"></div>
                </div>

                {{-- Nasib Akhir Arsip & Lbr --}}
                <div class="form-group">
                    <label class="form-label">Nasib Akhir Arsip <span>*</span></label>
                    <select class="form-input" id="fNasib" name="nasib_akhir_arsip" required>
                        <option value="">-- Pilih --</option>
                        <option value="Musnah">Musnah</option>
                        <option value="Permanen">Permanen</option>
                        <option value="Dinilai Kembali">Dinilai Kembali</option>
                    </select>
                    <div class="invalid-feedback" id="nasib_akhir_arsipError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Lbr</label>
                    <input type="number" class="form-input" id="fLembar" name="lembar" placeholder="Jumlah lembar">
                </div>

                {{-- Keterangan --}}
                <div class="form-group span-2">
                    <label class="form-label">Ket</label>
                    <textarea class="form-input" id="fKet" name="keterangan" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>

            @else {{-- Vital & Permanen --}}
            <div class="form-grid">
                {{-- No. & Jenis Arsip --}}
                <div class="form-group">
                    <label class="form-label">No. <span>*</span></label>
                    <input type="number" class="form-input" id="fNo" name="no" min="1" required>
                    <div class="invalid-feedback" id="noError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Arsip <span>*</span></label>
                    <select class="form-input" id="fJenisArsip" name="jenis_arsip" required>
                        <option value="">-- Pilih --</option>
                        <option value="Vital">Vital</option>
                        <option value="Permanen">Permanen</option>
                    </select>
                    <div class="invalid-feedback" id="jenis_arsipError"></div>
                </div>

                {{-- No Box & No Berkas --}}
                <div class="form-group">
                    <label class="form-label">No Box</label>
                    <input type="text" class="form-input" id="fNoBox" name="no_box" placeholder="Contoh: B-001">
                </div>
                <div class="form-group">
                    <label class="form-label">No Berkas</label>
                    <input type="text" class="form-input" id="fNoBerkas" name="no_berkas" placeholder="Contoh: BRK-001">
                </div>

                {{-- No. Perjanjian Kerjasama & Pihak I --}}
                <div class="form-group">
                    <label class="form-label">No. Perjanjian Kerjasama</label>
                    <input type="text" class="form-input" id="fNoPerjanjian" name="no_perjanjian_kerjasama" placeholder="Contoh: PKS-001">
                </div>
                <div class="form-group">
                    <label class="form-label">Pihak I</label>
                    <input type="text" class="form-input" id="fPihakI" name="pihak_i" placeholder="Nama pihak pertama">
                </div>

                {{-- Pihak II & Tingkat Perkembangan --}}
                <div class="form-group">
                    <label class="form-label">Pihak II</label>
                    <input type="text" class="form-input" id="fPihakII" name="pihak_ii" placeholder="Nama pihak kedua">
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat Perkembangan</label>
                    <select class="form-input" id="fTingkat" name="tingkat_perkembangan">
                        <option value="">-- Pilih --</option>
                        <option value="Asli">Asli</option>
                        <option value="Fotokopi">Fotokopi</option>
                        <option value="Salinan">Salinan</option>
                        <option value="Tembusan">Tembusan</option>
                    </select>
                </div>

                {{-- Tanggal Berlaku & Tanggal Berakhir --}}
                <div class="form-group">
                    <label class="form-label">Tanggal Berlaku</label>
                    <input type="date" class="form-input" id="fTanggalBerlaku" name="tanggal_berlaku">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Berakhir</label>
                    <input type="date" class="form-input" id="fTanggalBerakhir" name="tanggal_berakhir">
                </div>

                {{-- Media & Jumlah --}}
                <div class="form-group">
                    <label class="form-label">Media</label>
                    <input type="text" class="form-input" id="fMedia" name="media" placeholder="Jenis media">
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah <span>*</span></label>
                    <input type="text" class="form-input" id="fJumlah" name="jumlah" required placeholder="Contoh: 5 Berkas">
                    <div class="invalid-feedback" id="jumlahError"></div>
                </div>

                {{-- Jangka Simpan & Lokasi Simpan --}}
                <div class="form-group">
                    <label class="form-label">Jangka Simpan</label>
                    <input type="text" class="form-input" id="fJangka" name="jangka_simpan" placeholder="Contoh: 10 Tahun">
                </div>
                <div class="form-group">
                    <label class="form-label">Lokasi Simpan</label>
                    <input type="text" class="form-input" id="fLokasi" name="lokasi_simpan" placeholder="Contoh: Ruang Arsip Lantai 2">
                </div>

                {{-- Metode Perlindungan --}}
                <div class="form-group">
                    <label class="form-label">Metode Perlindungan</label>
                    <input type="text" class="form-input" id="fMetode" name="metode_perlindungan" placeholder="Contoh: Brankas, Digital">
                </div>

                {{-- Keterangan --}}
                <div class="form-group span-2">
                    <label class="form-label">Ket</label>
                    <textarea class="form-input" id="fKet" name="keterangan" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>
            @endif

            <div class="form-footer">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <span id="submitText">Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const kategoriId   = {{ $kategori->id }};
    const detailId     = {{ $kategoriDetail->id }};
    const tahunId      = {{ $tahunDetail->id }};
    const kategoriNama = '{{ $kategori->name }}';
    const userRole     = '{{ $userRole }}';
    const canEdit      = userRole === 'admin';
    const isMusnah     = kategoriNama === 'Daftar Arsip Usul Musnah';

    let allData   = [];
    let currentId = null;

    const elForm = {
        tableBody:   document.getElementById('tableBody'),
        searchInput: document.getElementById('searchInput'),
        mainModal:   document.getElementById('mainModal'),
        mainForm:    document.getElementById('mainForm'),
    };

    // =====================
    // UTILITY
    // =====================
    function clearErrors() {
        [
            'noError', 'kode_klasifikasiError', 'uraian_informasiError',
            'kurun_waktuError', 'jumlahError', 'jangka_simpanError',
            'nasib_akhir_arsipError', 'jenis_arsipError'
        ].forEach(id => {
            const e = document.getElementById(id);
            if (e) { e.style.display = 'none'; e.textContent = ''; }
        });
    }

    function resetForm() {
        elForm.mainForm.reset();
        document.getElementById('itemId').value = '';
        currentId = null;
        clearErrors();
    }

    function setField(id, val) {
        const e = document.getElementById(id);
        if (e) e.value = val || '';
    }

    function getKondisiBadge(kondisi) {
        if (!kondisi) return '-';
        if (kondisi === 'Baik') return `<span class="badge badge-good">${kondisi}</span>`;
        if (kondisi.includes('Rusak')) return `<span class="badge badge-rusak">${kondisi}</span>`;
        return `<span class="badge badge-default">${kondisi}</span>`;
    }

    // =====================
    // LOAD STATS
    // =====================
    async function loadStats() {
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/stats`);
            if (res.data.success) {
                document.getElementById('totalInput').textContent   = res.data.data.total_input || 0;
                document.getElementById('latestUpdate').textContent = res.data.data.latest_update || '-';
            }
        } catch (e) { console.log('stats error', e); }
    }

    // =====================
    // LOAD DATA
    // =====================
    async function loadData() {
        showLoading();
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input`);
            if (res.data.success) {
                allData = res.data.data || [];
                renderTable(allData);
            } else {
                renderEmpty();
            }
        } catch (e) {
            showNotification('Gagal memuat data', 'error');
            renderEmpty();
        } finally {
            hideLoading();
        }
    }

    // =====================
    // RENDER TABLE
    // =====================
    function renderTable(data) {
        if (!data || data.length === 0) { renderEmpty(); return; }
        elForm.tableBody.innerHTML = '';
        data.forEach(item => elForm.tableBody.appendChild(createRow(item)));
    }

    function createRow(item) {
        const tr = document.createElement('tr');

        if (isMusnah) {
            tr.innerHTML = `
                <td class="td-no">${item.no || '-'}</td>
                <td class="td-kode">
                    <code style="color:var(--primary-light);font-size:12px">
                        ${item.kode_klasifikasi || '-'}
                    </code>
                </td>
                <td class="td-uraian">
                    <div class="uraian-text">${item.uraian_informasi || '-'}</div>
                </td>
                <td class="td-waktu">${item.kurun_waktu || '-'}</td>
                <td class="td-tingkat">${item.tingkat_perkembangan || '-'}</td>
                <td class="td-jumlah">${item.jumlah || '-'}</td>
                <td class="td-extra">${item.no_box || '-'}</td>
                <td class="td-extra">${item.media_simpan || '-'}</td>
                <td class="td-extra">${getKondisiBadge(item.kondisi_fisik)}</td>
                <td class="td-extra">${item.nomor_folder || '-'}</td>
                <td class="td-extra">${item.jangka_simpan || '-'}</td>
                <td class="td-extra">
                    ${item.nasib_akhir_arsip
                        ? `<span class="badge badge-default">${item.nasib_akhir_arsip}</span>`
                        : '-'}
                </td>
                <td class="td-extra">${item.lembar || '-'}</td>
                <td class="td-ket">${item.keterangan || '-'}</td>
                ${canEdit ? `
                <td class="td-aksi">
                    <div class="row-actions">
                        <button class="btn-icon edit" title="Edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </td>` : ''}
            `;
        } else {
            tr.innerHTML = `
                <td class="td-no">${item.no || '-'}</td>
                <td class="td-jenis">${item.jenis_arsip || '-'}</td>
                <td class="td-extra">${item.no_box || '-'}</td>
                <td class="td-extra">${item.no_berkas || '-'}</td>
                <td class="td-extra">${item.no_perjanjian_kerjasama || '-'}</td>
                <td class="td-extra">${item.pihak_i || '-'}</td>
                <td class="td-extra">${item.pihak_ii || '-'}</td>
                <td class="td-tingkat">${item.tingkat_perkembangan || '-'}</td>
                <td class="td-tanggal">
                    ${item.tanggal_berlaku
                        ? new Date(item.tanggal_berlaku).toLocaleDateString('id-ID')
                        : '-'}
                </td>
                <td class="td-tanggal">
                    ${item.tanggal_berakhir
                        ? new Date(item.tanggal_berakhir).toLocaleDateString('id-ID')
                        : '-'}
                </td>
                <td class="td-extra">${item.media || '-'}</td>
                <td class="td-jumlah">${item.jumlah || '-'}</td>
                <td class="td-extra">${item.jangka_simpan || '-'}</td>
                <td class="td-extra">${item.lokasi_simpan || '-'}</td>
                <td class="td-extra">${item.metode_perlindungan || '-'}</td>
                <td class="td-ket">${item.keterangan || '-'}</td>
                ${canEdit ? `
                <td class="td-aksi">
                    <div class="row-actions">
                        <button class="btn-icon edit" title="Edit"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </td>` : ''}
            `;
        }

        if (canEdit) {
            tr.querySelector('.edit')?.addEventListener('click', () => openEdit(item.id));
            tr.querySelector('.delete')?.addEventListener('click', () => deleteItem(item.id));
        }

        return tr;
    }

    function renderEmpty() {
        const colspan = isMusnah ? (canEdit ? 15 : 14) : (canEdit ? 17 : 16);
        elForm.tableBody.innerHTML = `
            <tr><td colspan="${colspan}">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum Ada Data Arsip</h3>
                    <p>Tambahkan data arsip untuk tahun ini.</p>
                </div>
            </td></tr>`;
    }

    // =====================
    // SEARCH
    // =====================
    elForm.searchInput?.addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        renderTable(allData.filter(d => {
            if (isMusnah) {
                return (d.uraian_informasi || '').toLowerCase().includes(q)
                    || (d.kode_klasifikasi || '').toLowerCase().includes(q);
            }
            return (d.jenis_arsip || '').toLowerCase().includes(q)
                || (d.pihak_i || '').toLowerCase().includes(q)
                || (d.pihak_ii || '').toLowerCase().includes(q);
        }));
    });

    // =====================
    // MODAL OPEN ADD
    // =====================
    function openAdd() {
        resetForm();
        document.getElementById('modalTitle').textContent = 'Tambah Data Arsip';
        document.getElementById('submitText').textContent = 'Simpan';
        const nextNo = allData.length > 0
            ? Math.max(...allData.map(d => d.no || 0)) + 1
            : 1;
        setField('fNo', nextNo);
        elForm.mainModal.style.display = 'flex';
    }

    // =====================
    // MODAL OPEN EDIT
    // =====================
    async function openEdit(id) {
        showLoading();
        try {
            const res = await axios.get(
                `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${id}/edit`
            );
            if (res.data.success) {
                const d = res.data.data;
                resetForm();
                currentId = d.id;

                document.getElementById('modalTitle').textContent = 'Edit Data Arsip';
                document.getElementById('submitText').textContent = 'Update';
                document.getElementById('itemId').value = d.id;

                setField('fNo', d.no);

                if (isMusnah) {
                    setField('fKodeKlasifikasi', d.kode_klasifikasi);
                    setField('fUraian',          d.uraian_informasi);
                    setField('fKurun',           d.kurun_waktu);
                    setField('fTingkat',         d.tingkat_perkembangan);
                    setField('fJumlah',          d.jumlah);
                    setField('fNoBox',           d.no_box);
                    setField('fMediaSimpan',     d.media_simpan);
                    setField('fKondisi',         d.kondisi_fisik);
                    setField('fNomorFolder',     d.nomor_folder);
                    setField('fJangka',          d.jangka_simpan);
                    setField('fNasib',           d.nasib_akhir_arsip);
                    setField('fLembar',          d.lembar);
                    setField('fKet',             d.keterangan);
                } else {
                    setField('fJenisArsip',      d.jenis_arsip);
                    setField('fNoBox',           d.no_box);
                    setField('fNoBerkas',        d.no_berkas);
                    setField('fNoPerjanjian',    d.no_perjanjian_kerjasama);
                    setField('fPihakI',          d.pihak_i);
                    setField('fPihakII',         d.pihak_ii);
                    setField('fTingkat',         d.tingkat_perkembangan);
                    setField('fTanggalBerlaku',  d.tanggal_berlaku);
                    setField('fTanggalBerakhir', d.tanggal_berakhir);
                    setField('fMedia',           d.media);
                    setField('fJumlah',          d.jumlah);
                    setField('fJangka',          d.jangka_simpan);
                    setField('fLokasi',          d.lokasi_simpan);
                    setField('fMetode',          d.metode_perlindungan);
                    setField('fKet',             d.keterangan);
                }

                elForm.mainModal.style.display = 'flex';
            }
        } catch (e) {
            showNotification('Gagal memuat data', 'error');
        } finally {
            hideLoading();
        }
    }

    // =====================
    // MODAL CLOSE
    // =====================
    function closeModal() {
        elForm.mainModal.style.display = 'none';
        resetForm();
    }

    // =====================
    // FORM SUBMIT
    // =====================
    elForm.mainForm?.addEventListener('submit', async e => {
        e.preventDefault();
        clearErrors();

        // Validasi client-side: No wajib
        const noVal = document.getElementById('fNo')?.value;
        if (!noVal) {
            const err = document.getElementById('noError');
            if (err) { err.textContent = 'No harus diisi'; err.style.display = 'block'; }
            showNotification('No harus diisi', 'error');
            return;
        }

        // Validasi Vital & Permanen: Jenis Arsip wajib
        if (!isMusnah) {
            const jenisVal = document.getElementById('fJenisArsip')?.value;
            if (!jenisVal) {
                const err = document.getElementById('jenis_arsipError');
                if (err) { err.textContent = 'Jenis Arsip harus dipilih'; err.style.display = 'block'; }
                showNotification('Jenis Arsip harus dipilih', 'error');
                return;
            }
        }

        const formData = new FormData(elForm.mainForm);
        if (currentId) formData.append('_method', 'PUT');

        const url = currentId
            ? `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${currentId}`
            : `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input`;

        showLoading();
        try {
            const res = await axios.post(url, formData, {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.data.success) {
                showNotification(res.data.message, 'success');
                await loadStats();
                await loadData();
                closeModal();
            }
        } catch (e) {
            if (e.response?.status === 422) {
                const errors = e.response.data.errors;
                Object.keys(errors).forEach(key => {
                    const err = document.getElementById(`${key}Error`);
                    if (err) { err.textContent = errors[key][0]; err.style.display = 'block'; }
                });
                showNotification('Periksa kembali form Anda', 'error');
                console.log('Validation errors:', errors);
            } else {
                console.error('Submit error:', e);
                showNotification(e.response?.data?.message || 'Terjadi kesalahan', 'error');
            }
        } finally {
            hideLoading();
        }
    });

    // =====================
    // DELETE
    // =====================
    async function deleteItem(id) {
        if (!confirm('Yakin ingin menghapus data arsip ini?')) return;
        showLoading();
        try {
            const res = await axios.delete(
                `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${id}`,
                { headers: { 'X-CSRF-TOKEN': csrfToken } }
            );
            if (res.data.success) {
                showNotification(res.data.message, 'success');
                await loadStats();
                await loadData();
            }
        } catch (e) {
            showNotification('Gagal menghapus data', 'error');
        } finally {
            hideLoading();
        }
    }

    // =====================
    // EVENT LISTENERS
    // =====================
    if (canEdit) {
        document.getElementById('addBtn')?.addEventListener('click', openAdd);
        document.getElementById('fabBtn')?.addEventListener('click', openAdd);
    }

    document.getElementById('refreshBtn')?.addEventListener('click', () => {
        loadStats();
        loadData();
    });

    document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
    document.getElementById('cancelBtn')?.addEventListener('click', closeModal);

    elForm.mainModal?.addEventListener('click', e => {
        if (e.target === elForm.mainModal) closeModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && elForm.mainModal?.style.display === 'flex') closeModal();
    });

    // =====================
    // INIT
    // =====================
    document.addEventListener('DOMContentLoaded', () => {
        loadStats();
        loadData();
    });
</script>
@endsection