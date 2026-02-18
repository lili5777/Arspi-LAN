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
    .table { width: 100%; border-collapse: collapse; min-width: 900px; }
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
    .td-kode { width: 110px; }
    .td-uraian { min-width: 200px; }
    .uraian-text { line-height: 1.5; }
    .td-waktu, .td-jumlah, .td-kondisi { width: 90px; }
    .td-extra { width: 120px; }
    .td-ket { width: 140px; color: var(--gray); font-size: 12px; }
    .td-aksi { width: 80px; }

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
        max-width: 680px; width: 100%; border: 1px solid rgba(183,163,227,0.15);
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
                <tr>
                    <th class="td-no">No</th>
                    <th class="td-kode">Kode Klasifikasi</th>
                    <th class="td-uraian">Uraian Informasi</th>
                    <th class="td-waktu">Kurun Waktu</th>
                    <th class="td-jumlah">Jumlah</th>
                    <th class="td-kondisi">Kondisi</th>
                    {{-- Kolom dinamis sesuai type --}}
                    @if($kategori->name === 'Daftar Arsip Usul Musnah')
                        <th class="td-extra">Jangka Simpan</th>
                        <th class="td-extra">Nasib Akhir</th>
                    @else
                        <th class="td-extra">Lokasi Simpan</th>
                        <th class="td-extra">No. Boks</th>
                    @endif
                    <th class="td-ket">Keterangan</th>
                    @if($userRole === 'admin')
                    <th class="td-aksi">Aksi</th>
                    @endif
                </tr>
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
            <div class="form-grid">

                {{-- Baris 1: No Urut & Kode Klasifikasi --}}
                <div class="form-group">
                    <label class="form-label">No. Urut <span>*</span></label>
                    <input type="number" class="form-input" id="fNoUrut" name="no_urut" min="1" required>
                    <div class="invalid-feedback" id="no_urutError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Klasifikasi <span>*</span></label>
                    <input type="text" class="form-input" id="fKode" name="kode_klasifikasi" required placeholder="Contoh: 600.1">
                    <div class="invalid-feedback" id="kode_klasifikasiError"></div>
                </div>

                {{-- Uraian Informasi --}}
                <div class="form-group span-2">
                    <label class="form-label">Uraian Informasi <span>*</span></label>
                    <textarea class="form-input" id="fUraian" name="uraian_informasi" required placeholder="Deskripsi arsip..."></textarea>
                    <div class="invalid-feedback" id="uraian_informasiError"></div>
                </div>

                {{-- Kurun Waktu & Jumlah --}}
                <div class="form-group">
                    <label class="form-label">Kurun Waktu <span>*</span></label>
                    <input type="text" class="form-input" id="fKurun" name="kurun_waktu" required placeholder="Contoh: 2020 - 2024">
                    <div class="invalid-feedback" id="kurun_waktuError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Jumlah <span>*</span></label>
                    <input type="text" class="form-input" id="fJumlah" name="jumlah" required placeholder="Contoh: 5 Berkas">
                    <div class="invalid-feedback" id="jumlahError"></div>
                </div>

                {{-- Tingkat Perkembangan & Media Simpan --}}
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
                <div class="form-group">
                    <label class="form-label">Media Simpan</label>
                    <select class="form-input" id="fMedia" name="media_simpan">
                        <option value="">-- Pilih --</option>
                        <option value="Kertas">Kertas</option>
                        <option value="Digital">Digital</option>
                        <option value="Mikrofilm">Mikrofilm</option>
                    </select>
                </div>

                {{-- Kondisi --}}
                <div class="form-group">
                    <label class="form-label">Kondisi</label>
                    <select class="form-input" id="fKondisi" name="kondisi">
                        <option value="">-- Pilih --</option>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>

                {{-- Kolom khusus per type --}}
                @if($kategori->name === 'Daftar Arsip Usul Musnah')
                <hr class="section-divider">
                <p class="section-label"><i class="fas fa-trash-alt"></i> Informasi Pemusnahan</p>
                <div class="form-group">
                    <label class="form-label">Jangka Simpan <span>*</span></label>
                    <input type="text" class="form-input" id="fJangka" name="jangka_simpan" placeholder="Contoh: 5 Tahun">
                    <div class="invalid-feedback" id="jangka_simpanError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nasib Akhir <span>*</span></label>
                    <select class="form-input" id="fNasib" name="nasib_akhir">
                        <option value="">-- Pilih --</option>
                        <option value="Musnah">Musnah</option>
                        <option value="Permanen">Permanen</option>
                        <option value="Dinilai Kembali">Dinilai Kembali</option>
                    </select>
                    <div class="invalid-feedback" id="nasib_akhirError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Habis Retensi</label>
                    <input type="date" class="form-input" id="fRetensi" name="tanggal_habis_retensi">
                </div>
                @else
                <hr class="section-divider">
                <p class="section-label"><i class="fas fa-map-marker-alt"></i> Lokasi Penyimpanan</p>
                <div class="form-group">
                    <label class="form-label">Lokasi Simpan</label>
                    <input type="text" class="form-input" id="fLokasi" name="lokasi_simpan" placeholder="Contoh: Ruang Arsip Lantai 2">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Boks</label>
                    <input type="text" class="form-input" id="fBoks" name="nomor_boks" placeholder="Contoh: B-001">
                </div>
                @endif

                {{-- Keterangan --}}
                <div class="form-group span-2">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-input" id="fKet" name="keterangan" placeholder="Catatan tambahan..."></textarea>
                </div>

            </div>
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
    const kategoriId  = {{ $kategori->id }};
    const detailId    = {{ $kategoriDetail->id }};
    const tahunId     = {{ $tahunDetail->id }};
    const kategoriNama = '{{ $kategori->name }}';
    const userRole    = '{{ $userRole }}';
    const canEdit     = userRole === 'admin';
    const isMusnah    = kategoriNama === 'Daftar Arsip Usul Musnah';

    let allData   = [];
    let currentId = null;

    const el = {
        tableBody:   document.getElementById('tableBody'),
        searchInput: document.getElementById('searchInput'),
        mainModal:   document.getElementById('mainModal'),
        mainForm:    document.getElementById('mainForm'),
    };

    function clearErrors() {
        ['no_urutError','kode_klasifikasiError','uraian_informasiError','kurun_waktuError',
         'jumlahError','jangka_simpanError','nasib_akhirError'].forEach(id => {
            const e = document.getElementById(id);
            if (e) { e.style.display = 'none'; e.textContent = ''; }
        });
    }

    function resetForm() {
        el.mainForm.reset();
        document.getElementById('itemId').value = '';
        currentId = null;
        clearErrors();
    }

    function getKondisiBadge(kondisi) {
        if (!kondisi) return '-';
        if (kondisi === 'Baik') return `<span class="badge badge-good">${kondisi}</span>`;
        if (kondisi.includes('Rusak')) return `<span class="badge badge-rusak">${kondisi}</span>`;
        return `<span class="badge badge-default">${kondisi}</span>`;
    }

    // Load stats
    async function loadStats() {
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/stats`);
            if (res.data.success) {
                document.getElementById('totalInput').textContent  = res.data.data.total_input || 0;
                document.getElementById('latestUpdate').textContent = res.data.data.latest_update || '-';
            }
        } catch(e) { console.log('stats error', e); }
    }

    // Load data
    async function loadData() {
        showLoading();
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input`);
            if (res.data.success) {
                allData = res.data.data || [];
                renderTable(allData);
            } else renderEmpty();
        } catch(e) {
            showNotification('Gagal memuat data', 'error');
            renderEmpty();
        } finally { hideLoading(); }
    }

    function renderTable(data) {
        if (!data || data.length === 0) { renderEmpty(); return; }
        el.tableBody.innerHTML = '';
        data.forEach(item => el.tableBody.appendChild(createRow(item)));
    }

    function createRow(item) {
        const tr = document.createElement('tr');

        const extraCol1 = isMusnah
            ? (item.jangka_simpan || '-')
            : (item.lokasi_simpan || '-');
        const extraCol2 = isMusnah
            ? (item.nasib_akhir ? `<span class="badge badge-default">${item.nasib_akhir}</span>` : '-')
            : (item.nomor_boks || '-');

        tr.innerHTML = `
            <td class="td-no">${item.no_urut || '-'}</td>
            <td class="td-kode"><code style="color:var(--primary-light);font-size:12px">${item.kode_klasifikasi || '-'}</code></td>
            <td class="td-uraian"><div class="uraian-text">${item.uraian_informasi || '-'}</div></td>
            <td class="td-waktu">${item.kurun_waktu || '-'}</td>
            <td class="td-jumlah">${item.jumlah || '-'}</td>
            <td class="td-kondisi">${getKondisiBadge(item.kondisi)}</td>
            <td class="td-extra">${extraCol1}</td>
            <td class="td-extra">${extraCol2}</td>
            <td class="td-ket">${item.keterangan || '-'}</td>
            ${canEdit ? `
            <td class="td-aksi">
                <div class="row-actions">
                    <button class="btn-icon edit" title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>
            </td>` : ''}
        `;

        if (canEdit) {
            tr.querySelector('.edit').addEventListener('click', () => openEdit(item.id));
            tr.querySelector('.delete').addEventListener('click', () => deleteItem(item.id));
        }

        return tr;
    }

    function renderEmpty() {
        const colspan = canEdit ? 10 : 9;
        el.tableBody.innerHTML = `
            <tr><td colspan="${colspan}">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum Ada Data Arsip</h3>
                    <p>Tambahkan data arsip untuk tahun ${tahunId}.</p>
                </div>
            </td></tr>`;
    }

    // Search
    el.searchInput.addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        renderTable(allData.filter(d =>
            (d.uraian_informasi || '').toLowerCase().includes(q) ||
            (d.kode_klasifikasi || '').toLowerCase().includes(q)
        ));
    });

    // Modal
    function openAdd() {
        resetForm();
        document.getElementById('modalTitle').textContent = 'Tambah Data Arsip';
        document.getElementById('submitText').textContent = 'Simpan';
        // Auto isi no urut berikutnya
        const nextNo = allData.length > 0 ? Math.max(...allData.map(d => d.no_urut || 0)) + 1 : 1;
        document.getElementById('fNoUrut').value = nextNo;
        el.mainModal.style.display = 'flex';
    }

    async function openEdit(id) {
        showLoading();
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${id}/edit`);
            if (res.data.success) {
                const d = res.data.data;
                resetForm();
                currentId = d.id;
                document.getElementById('modalTitle').textContent = 'Edit Data Arsip';
                document.getElementById('submitText').textContent = 'Update';
                document.getElementById('itemId').value  = d.id;
                document.getElementById('fNoUrut').value = d.no_urut || '';
                document.getElementById('fKode').value   = d.kode_klasifikasi || '';
                document.getElementById('fUraian').value = d.uraian_informasi || '';
                document.getElementById('fKurun').value  = d.kurun_waktu || '';
                document.getElementById('fJumlah').value = d.jumlah || '';
                document.getElementById('fTingkat').value = d.tingkat_perkembangan || '';
                document.getElementById('fMedia').value   = d.media_simpan || '';
                document.getElementById('fKondisi').value = d.kondisi || '';
                document.getElementById('fKet').value     = d.keterangan || '';
                // Kolom khusus
                if (isMusnah) {
                    document.getElementById('fJangka').value  = d.jangka_simpan || '';
                    document.getElementById('fNasib').value   = d.nasib_akhir || '';
                    document.getElementById('fRetensi').value = d.tanggal_habis_retensi || '';
                } else {
                    document.getElementById('fLokasi').value = d.lokasi_simpan || '';
                    document.getElementById('fBoks').value   = d.nomor_boks || '';
                }
                el.mainModal.style.display = 'flex';
            }
        } catch(e) { showNotification('Gagal memuat data', 'error'); }
        finally { hideLoading(); }
    }

    function closeModal() {
        el.mainModal.style.display = 'none';
        resetForm();
    }

    // Submit
    el.mainForm.addEventListener('submit', async e => {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(el.mainForm);
        const data = Object.fromEntries(formData);

        const url = currentId
            ? `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${currentId}`
            : `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input`;
        const method = currentId ? 'put' : 'post';

        showLoading();
        try {
            const res = await axios({ method, url, data, headers: { 'X-CSRF-TOKEN': csrfToken } });
            if (res.data.success) {
                showNotification(res.data.message, 'success');
                loadStats(); loadData(); closeModal();
            }
        } catch(e) {
            if (e.response?.status === 422) {
                const errors = e.response.data.errors;
                Object.keys(errors).forEach(key => {
                    const el = document.getElementById(`${key}Error`);
                    if (el) { el.textContent = errors[key][0]; el.style.display = 'block'; }
                });
                showNotification('Periksa kembali form Anda', 'error');
            } else {
                showNotification(e.response?.data?.message || 'Terjadi kesalahan', 'error');
            }
        } finally { hideLoading(); }
    });

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
                loadStats(); loadData();
            }
        } catch(e) { showNotification('Gagal menghapus data', 'error'); }
        finally { hideLoading(); }
    }

    // Init
    if (canEdit) {
        document.getElementById('addBtn')?.addEventListener('click', openAdd);
        document.getElementById('fabBtn')?.addEventListener('click', openAdd);
    }
    document.getElementById('refreshBtn').addEventListener('click', () => { loadStats(); loadData(); });
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelBtn').addEventListener('click', closeModal);
    el.mainModal.addEventListener('click', e => { if (e.target === el.mainModal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    document.addEventListener('DOMContentLoaded', () => { loadStats(); loadData(); });
</script>
@endsection