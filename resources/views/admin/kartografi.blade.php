@extends('admin.partials.layout')

@section('title', 'Kartografi - ' . $kategori->name)
@section('page-title', $kategori->name)
@section('page-subtitle', 'Manajemen Dokumen Kartografi • ' . $kategori->desc)

@section('styles')
<style>
    .breadcrumb {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 24px; font-size: 13px; color: var(--gray); flex-wrap: wrap;
    }
    .breadcrumb a { color: var(--primary-light); text-decoration: none; transition: color 0.2s ease; }
    .breadcrumb a:hover { color: var(--primary); }
    .breadcrumb-separator { color: rgba(255,255,255,0.2); }
    .breadcrumb-current { color: white; font-weight: 500; }

    .page-header {
        background: var(--dark-light);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: var(--radius-lg);
        padding: 24px; margin-bottom: 32px;
        display: flex; align-items: center; gap: 20px;
    }
    .page-header-icon {
        width: 64px; height: 64px; border-radius: var(--radius-lg);
        background: linear-gradient(135deg, rgba(183,163,227,0.15) 0%, rgba(183,163,227,0.25) 100%);
        display: flex; align-items: center; justify-content: center;
        color: var(--primary-light); font-size: 28px;
    }
    .page-header-info h1 { font-size: 24px; font-weight: 700; color: white; margin-bottom: 6px; }
    .page-header-info p  { font-size: 14px; color: var(--gray); margin: 0; }

    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px; margin-bottom: 40px;
    }
    .stat-card {
        background: var(--dark-light); border: 1px solid rgba(255,255,255,0.05);
        border-radius: var(--radius-lg); padding: 22px; transition: all 0.2s ease;
    }
    .stat-card:hover { border-color: rgba(183,163,227,0.2); transform: translateY(-2px); box-shadow: var(--shadow-lg); }
    .stat-icon {
        width: 40px; height: 40px; border-radius: var(--radius-md);
        background: linear-gradient(135deg, rgba(183,163,227,0.1) 0%, rgba(183,163,227,0.2) 100%);
        display: flex; align-items: center; justify-content: center;
        color: var(--primary-light); font-size: 16px; margin-bottom: 16px;
    }
    .stat-value { font-size: 28px; font-weight: 700; color: white; margin-bottom: 6px; line-height: 1; }
    .stat-label { font-size: 13px; color: var(--gray); }

    .section-header {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;
    }
    .section-title {
        font-size: 18px; font-weight: 600; color: white;
        position: relative; padding-left: 12px;
    }
    .section-title::before {
        content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
        width: 3px; height: 16px;
        background: linear-gradient(to bottom, var(--primary), var(--primary-light));
        border-radius: var(--radius-full);
    }

    .search-bar { position: relative; margin-bottom: 20px; }
    .search-input {
        width: 100%; padding: 12px 16px 12px 44px;
        background: var(--dark-light); border: 1px solid rgba(255,255,255,0.08);
        border-radius: var(--radius-md); color: white; font-size: 14px; transition: all 0.2s ease;
    }
    .search-input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 2px rgba(183,163,227,0.2); }
    .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--gray); }

    .table-container {
        background: var(--dark-light); border: 1px solid rgba(255,255,255,0.05);
        border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 60px;
    }
    .table { width: 100%; border-collapse: collapse; }
    .table thead { background: rgba(255,255,255,0.02); border-bottom: 1px solid rgba(255,255,255,0.05); }
    .table th {
        padding: 16px 20px; text-align: left; font-size: 13px; font-weight: 600;
        color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px;
    }
    .table td { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 14px; color: white; }
    .table tbody tr { transition: all 0.2s ease; }
    .table tbody tr:hover { background: rgba(183,163,227,0.05); }
    .table tbody tr:last-child td { border-bottom: none; }

    .file-name { display: flex; align-items: center; gap: 12px; }
    .file-icon {
        width: 36px; height: 36px; border-radius: var(--radius-sm);
        background: rgba(183,163,227,0.1); display: flex; align-items: center;
        justify-content: center; color: var(--primary-light); font-size: 14px; flex-shrink: 0;
    }
    .file-title { font-weight: 500; color: white; margin-bottom: 2px; }
    .file-meta { font-size: 12px; color: var(--gray); }
    .file-desc {
        font-size: 12px; color: var(--gray); white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis; max-width: 200px;
    }

    .table-actions { display: flex; gap: 6px; justify-content: flex-end; }
    .btn-icon {
        width: 32px; height: 32px; border-radius: var(--radius-md);
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);
        color: var(--gray); cursor: pointer; transition: all 0.2s ease;
    }
    .btn-icon:hover { transform: scale(1.1); }
    .btn-icon.download:hover { color: var(--primary-light); background: rgba(183,163,227,0.08); }
    .btn-icon.edit:hover { color: var(--success); background: rgba(139,202,157,0.08); }
    .btn-icon.delete:hover { color: var(--danger); background: rgba(227,163,163,0.08); }

    .empty-state { text-align: center; padding: 60px 30px; }
    .empty-state i { font-size: 48px; color: var(--primary-light); margin-bottom: 20px; opacity: 0.7; }
    .empty-state h3 { font-size: 18px; font-weight: 600; color: white; margin-bottom: 10px; }
    .empty-state p { font-size: 14px; color: var(--gray); max-width: 400px; margin: 0 auto; line-height: 1.6; }

    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(42,27,74,0.9); backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center; z-index: 1000; padding: 20px;
    }
    .modal-content {
        background: var(--dark-light); border-radius: var(--radius-xl); padding: 28px;
        max-width: 500px; width: 100%; border: 1px solid rgba(183,163,227,0.15);
        box-shadow: var(--shadow-xl); max-height: 90vh; overflow-y: auto;
    }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .modal-header h3 { font-size: 18px; font-weight: 600; color: white; }
    .btn-close {
        width: 32px; height: 32px; border-radius: var(--radius-md);
        background: rgba(183,163,227,0.08); border: 1px solid rgba(183,163,227,0.15);
        color: var(--gray); display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s ease;
    }
    .btn-close:hover { color: white; background: rgba(183,163,227,0.15); }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 500; color: white; margin-bottom: 6px; }
    .form-input {
        width: 100%; padding: 10px 14px;
        background: rgba(183,163,227,0.05); border: 1px solid rgba(183,163,227,0.15);
        border-radius: var(--radius-md); color: white; font-size: 14px; transition: all 0.2s ease;
    }
    .form-input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 2px rgba(183,163,227,0.2); }
    textarea.form-input { resize: vertical; min-height: 80px; }
    .file-upload-area {
        border: 2px dashed rgba(183,163,227,0.2); border-radius: var(--radius-md);
        padding: 30px 20px; text-align: center; transition: all 0.2s ease;
        cursor: pointer; background: rgba(183,163,227,0.02);
    }
    .file-upload-area:hover, .file-upload-area.dragover {
        border-color: var(--primary); background: rgba(183,163,227,0.06);
    }
    .upload-icon { font-size: 36px; color: var(--primary-light); margin-bottom: 12px; }
    .upload-text { font-size: 14px; color: white; margin-bottom: 4px; }
    .upload-subtext { font-size: 12px; color: var(--gray); }
    .file-input { display: none; }
    .selected-file {
        margin-top: 12px; padding: 10px 14px;
        background: rgba(183,163,227,0.08); border: 1px solid rgba(183,163,227,0.2);
        border-radius: var(--radius-md); display: none; align-items: center; gap: 10px;
    }
    .selected-file.active { display: flex; }
    .selected-file-name { font-size: 13px; color: white; font-weight: 500; }
    .selected-file-size { font-size: 11px; color: var(--gray); }
    .remove-file { color: var(--danger); cursor: pointer; margin-left: auto; }
    .form-footer {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(183,163,227,0.15);
    }
    .invalid-feedback { display: none; color: var(--danger); font-size: 12px; margin-top: 4px; }
    .fab {
        position: fixed; bottom: 20px; right: 20px; width: 48px; height: 48px;
        border-radius: var(--radius-full);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white; border: none; font-size: 18px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 6px 20px rgba(183,163,227,0.4); transition: all 0.2s ease; z-index: 100;
    }
    .fab:hover { transform: translateY(-3px) rotate(90deg); box-shadow: 0 10px 25px rgba(183,163,227,0.5); }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .table { display: block; overflow-x: auto; }
        .page-header { flex-direction: column; text-align: center; }
    }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<nav class="breadcrumb">
    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-current">{{ $kategori->name }}</span>
</nav>

<div class="page-header">
    <div class="page-header-icon">
        <i class="{{ $kategori->icon ?? 'fas fa-map' }}"></i>
    </div>
    <div class="page-header-info">
        <h1>{{ $kategori->name }}</h1>
        <p>{{ $kategori->desc }}</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
        <div class="stat-value" id="totalDokumen">{{ $totalDokumen }}</div>
        <div class="stat-label">Total Dokumen</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-database"></i></div>
        <div class="stat-value" id="totalSize">{{ number_format($totalSize / (1024*1024), 2) }} MB</div>
        <div class="stat-label">Total Penyimpanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value" id="latestUpload">-</div>
        <div class="stat-label">Upload Terakhir</div>
    </div>
</div>

<div class="section-header">
    <h2 class="section-title">Daftar Dokumen Kartografi</h2>
    <div style="display:flex; gap:10px;">
        <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
        <button class="btn btn-primary" id="addBtn"><i class="fas fa-cloud-upload-alt"></i> Upload Dokumen</button>
    </div>
</div>

<div class="search-bar">
    <i class="fas fa-search search-icon"></i>
    <input type="text" class="search-input" id="searchInput" placeholder="Cari dokumen...">
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th style="width:40%">Nama Dokumen</th>
                <th style="width:20%">Deskripsi</th>
                <th style="width:12%">Ukuran</th>
                <th style="width:13%">Tanggal</th>
                <th style="width:15%; text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody id="tableBody"></tbody>
    </table>
</div>

<button class="fab" id="fabBtn"><i class="fas fa-cloud-upload-alt"></i></button>

<!-- Modal -->
<div class="modal-overlay" id="mainModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Upload Dokumen Kartografi</h3>
            <button class="btn-close" id="closeModalBtn"><i class="fas fa-times"></i></button>
        </div>
        <form id="mainForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="itemId">
            <input type="hidden" id="isEdit" value="0">

            <div class="form-group">
                <label class="form-label">Nama Dokumen</label>
                <input type="text" class="form-input" id="fieldName" name="name" required placeholder="Masukkan nama dokumen">
                <div class="invalid-feedback" id="nameError"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi <span style="color:var(--gray)">(opsional)</span></label>
                <textarea class="form-input" id="fieldDesc" name="desc" placeholder="Masukkan deskripsi dokumen"></textarea>
                <div class="invalid-feedback" id="descError"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-input" id="fieldDate" name="date" required>
                <div class="invalid-feedback" id="dateError"></div>
            </div>
            <div class="form-group">
                <label class="form-label">
                    File <span id="fileOptional" style="display:none; color:var(--gray)">(opsional — kosongkan jika tidak ingin mengganti)</span>
                </label>
                <div class="file-upload-area" id="fileUploadArea">
                    <div class="upload-icon"><i class="fas fa-map"></i></div>
                    <div class="upload-text">Klik atau drag & drop file di sini</div>
                    <div class="upload-subtext">Maksimal 50MB</div>
                </div>
                <input type="file" class="file-input" id="fileInput" name="file">
                <div class="selected-file" id="selectedFileDiv">
                    <i class="fas fa-file" style="color:var(--primary-light)"></i>
                    <div>
                        <div class="selected-file-name" id="selectedFileName"></div>
                        <div class="selected-file-size" id="selectedFileSize"></div>
                    </div>
                    <i class="fas fa-times remove-file" id="removeFile"></i>
                </div>
                <div class="invalid-feedback" id="fileError"></div>
            </div>
            <div class="form-footer">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <span id="submitText">Upload</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const kategoriId = {{ $kategori->id }};
    const userRole   = '{{ $userRole }}';
    const canEdit    = userRole === 'admin';
    let allData      = [];
    let selectedFile = null;
    let currentId    = null;

    const el = {
        tableBody:       document.getElementById('tableBody'),
        searchInput:     document.getElementById('searchInput'),
        mainModal:       document.getElementById('mainModal'),
        mainForm:        document.getElementById('mainForm'),
        modalTitle:      document.getElementById('modalTitle'),
        fileUploadArea:  document.getElementById('fileUploadArea'),
        fileInput:       document.getElementById('fileInput'),
        selectedFileDiv: document.getElementById('selectedFileDiv'),
        removeFile:      document.getElementById('removeFile'),
        fileOptional:    document.getElementById('fileOptional'),
        isEdit:          document.getElementById('isEdit'),
        submitText:      document.getElementById('submitText'),
    };

    function formatSize(bytes) {
        if (bytes >= 1073741824) return (bytes/1073741824).toFixed(2) + ' GB';
        if (bytes >= 1048576)    return (bytes/1048576).toFixed(2) + ' MB';
        if (bytes >= 1024)       return (bytes/1024).toFixed(2) + ' KB';
        return bytes + ' bytes';
    }

    function getFileIcon(filename) {
        if (!filename) return 'fa-file';
        const ext = filename.split('.').pop().toLowerCase();
        const map = { pdf:'fa-file-pdf', doc:'fa-file-word', docx:'fa-file-word',
            xls:'fa-file-excel', xlsx:'fa-file-excel', jpg:'fa-file-image',
            jpeg:'fa-file-image', png:'fa-file-image', zip:'fa-file-archive',
            rar:'fa-file-archive', dwg:'fa-drafting-compass', shp:'fa-map' };
        return map[ext] || 'fa-file';
    }

    function clearErrors() {
        ['nameError','descError','dateError','fileError'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.style.display = 'none'; el.textContent = ''; }
        });
    }

    function resetForm() {
        el.mainForm.reset();
        document.getElementById('itemId').value = '';
        el.isEdit.value = '0';
        selectedFile = null;
        el.selectedFileDiv.classList.remove('active');
        el.fileOptional.style.display = 'none';
        clearErrors();
    }

    // File upload handling
    el.fileUploadArea.addEventListener('click', () => el.fileInput.click());
    el.fileInput.addEventListener('change', e => handleFile(e.target.files[0]));
    el.removeFile.addEventListener('click', e => {
        e.stopPropagation();
        selectedFile = null;
        el.fileInput.value = '';
        el.selectedFileDiv.classList.remove('active');
    });
    el.fileUploadArea.addEventListener('dragover', e => { e.preventDefault(); el.fileUploadArea.classList.add('dragover'); });
    el.fileUploadArea.addEventListener('dragleave', () => el.fileUploadArea.classList.remove('dragover'));
    el.fileUploadArea.addEventListener('drop', e => {
        e.preventDefault();
        el.fileUploadArea.classList.remove('dragover');
        if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
    });

    function handleFile(file) {
        if (!file) return;
        if (file.size > 52428800) { showNotification('Ukuran file maksimal 50MB', 'error'); return; }
        selectedFile = file;
        document.getElementById('selectedFileName').textContent = file.name;
        document.getElementById('selectedFileSize').textContent = formatSize(file.size);
        el.selectedFileDiv.classList.add('active');
    }

    // Load stats
    async function loadStats() {
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/kartografi/stats`);
            if (res.data.success) {
                document.getElementById('totalDokumen').textContent = res.data.data.total_dokumen || 0;
                document.getElementById('totalSize').textContent    = res.data.data.total_size || '0 MB';
                document.getElementById('latestUpload').textContent = res.data.data.latest_upload || '-';
            }
        } catch(e) { console.log('Stats error', e); }
    }

    // Load data
    async function loadData() {
        showLoading();
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/kartografi`);
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
        const icon = getFileIcon(item.original_name || item.name);
        tr.innerHTML = `
            <td>
                <div class="file-name">
                    <div class="file-icon"><i class="fas ${icon}"></i></div>
                    <div>
                        <div class="file-title">${item.name}</div>
                        <div class="file-meta">Diupload: ${item.created_at}</div>
                    </div>
                </div>
            </td>
            <td><span class="file-desc">${item.desc || '-'}</span></td>
            <td>${item.size_formatted}</td>
            <td>${item.date_formatted}</td>
            <td>
                <div class="table-actions">
                    <button class="btn-icon download" title="Download"><i class="fas fa-download"></i></button>
                    ${canEdit ? `<button class="btn-icon edit" title="Edit"><i class="fas fa-edit"></i></button>` : ''}
                    ${canEdit ? `<button class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>` : ''}
                </div>
            </td>
        `;
        tr.querySelector('.download').addEventListener('click', () => download(item.id));
        if (canEdit) {
            tr.querySelector('.edit').addEventListener('click', () => openEdit(item.id));
            tr.querySelector('.delete').addEventListener('click', () => deleteItem(item.id));
        }
        return tr;
    }

    function renderEmpty() {
        el.tableBody.innerHTML = `
            <tr><td colspan="5">
                <div class="empty-state">
                    <i class="fas fa-map"></i>
                    <h3>Belum Ada Dokumen Kartografi</h3>
                    <p>Mulai dengan mengupload dokumen kartografi pertama.</p>
                </div>
            </td></tr>`;
    }

    // Search
    el.searchInput.addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        renderTable(allData.filter(d => d.name.toLowerCase().includes(q) || (d.desc || '').toLowerCase().includes(q)));
    });

    // Modal
    function openAdd() {
        resetForm();
        currentId = null;
        el.modalTitle.textContent = 'Upload Dokumen Kartografi';
        el.submitText.textContent = 'Upload';
        document.getElementById('fieldDate').value = new Date().toISOString().split('T')[0];
        el.mainModal.style.display = 'flex';
    }

    async function openEdit(id) {
        showLoading();
        try {
            const res = await axios.get(`/api/kategori/${kategoriId}/kartografi/${id}/edit`);
            if (res.data.success) {
                const d = res.data.data;
                resetForm();
                currentId = d.id;
                el.modalTitle.textContent = 'Edit Dokumen Kartografi';
                el.submitText.textContent = 'Update';
                document.getElementById('itemId').value  = d.id;
                document.getElementById('fieldName').value = d.name;
                document.getElementById('fieldDesc').value = d.desc || '';
                document.getElementById('fieldDate').value = d.date;
                el.isEdit.value = '1';
                el.fileOptional.style.display = 'inline';
                el.mainModal.style.display = 'flex';
            }
        } catch(e) { showNotification('Gagal memuat data', 'error'); }
        finally { hideLoading(); }
    }

    function closeModal() {
        el.mainModal.style.display = 'none';
        resetForm();
        currentId = null;
    }

    // Submit
    el.mainForm.addEventListener('submit', async e => {
        e.preventDefault();
        const isEdit = el.isEdit.value === '1';
        if (!isEdit && !selectedFile) {
            document.getElementById('fileError').textContent = 'File wajib diupload';
            document.getElementById('fileError').style.display = 'block';
            return;
        }
        const formData = new FormData(el.mainForm);
        const url = currentId
            ? `/api/kategori/${kategoriId}/kartografi/${currentId}`
            : `/api/kategori/${kategoriId}/kartografi`;
        showLoading();
        try {
            const res = await axios.post(url, formData, {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'multipart/form-data' }
            });
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
            } else {
                showNotification(e.response?.data?.message || 'Terjadi kesalahan', 'error');
            }
        } finally { hideLoading(); }
    });

    function download(id) {
        window.location.href = `/api/kategori/${kategoriId}/kartografi/${id}/download`;
    }

    async function deleteItem(id) {
        if (!confirm('Yakin ingin menghapus dokumen ini?')) return;
        showLoading();
        try {
            const res = await axios.delete(`/api/kategori/${kategoriId}/kartografi/${id}`, {
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.data.success) {
                showNotification(res.data.message, 'success');
                loadStats(); loadData();
            }
        } catch(e) { showNotification('Gagal menghapus dokumen', 'error'); }
        finally { hideLoading(); }
    }

    // Init
    document.getElementById('addBtn').addEventListener('click', openAdd);
    document.getElementById('fabBtn').addEventListener('click', openAdd);
    document.getElementById('refreshBtn').addEventListener('click', () => { loadStats(); loadData(); });
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelBtn').addEventListener('click', closeModal);
    el.mainModal.addEventListener('click', e => { if (e.target === el.mainModal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    document.addEventListener('DOMContentLoaded', () => { loadStats(); loadData(); });
</script>
@endsection