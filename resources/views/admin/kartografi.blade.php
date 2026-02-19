@extends('admin.partials.layout')

@section('title', 'Kartografi - ' . $kategori->name)
@section('page-title', $kategori->name)
@section('page-subtitle', 'Manajemen Dokumen Kartografi • ' . $kategori->desc)

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════
   DESIGN TOKENS — LIGHT PURPLE/WHITE THEME
═══════════════════════════════════════════════ */
:root {
    --p0:#F8F5FF; --p1:#EEE8FF; --p2:#DDD5FF; --p3:#C4B0FF;
    --p4:#6B46C1; --p5:#7C5FD4; --p6:#9B7FE8; --p7:#B794F4;
    --accent:#A78BFA;
    --emerald:#059669; --rose:#DC2626; --amber:#D97706;
    --s1:rgba(255,255,255,0.65); --s2:rgba(255,255,255,0.82); --s3:rgba(255,255,255,0.96);
    --b1:rgba(107,70,193,0.10); --b2:rgba(107,70,193,0.20); --b3:rgba(107,70,193,0.36);
    --txt:#2D1F5E; --txt2:#5540A0; --muted:#9080C0;
    --ff-d:'Cormorant Garamond',Georgia,serif;
    --ff-b:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r-md:14px; --r-lg:20px; --r-xl:28px; --r-full:9999px;
    --sh-md:0 4px 20px rgba(107,70,193,0.12);
    --sh-lg:0 8px 36px rgba(107,70,193,0.16);
    --sh-xl:0 20px 56px rgba(107,70,193,0.20);
}

*,*::before,*::after{box-sizing:border-box;}

body{
    font-family:var(--ff-b);
    background:#F3EEFF;
    color:var(--txt);
    min-height:100vh;
    position:relative;
    overflow-x:hidden;
}
body::before{
    content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
    background:
        radial-gradient(ellipse 80% 60% at -5% -10%,rgba(196,176,255,0.55) 0%,transparent 55%),
        radial-gradient(ellipse 60% 50% at 105% 105%,rgba(167,139,250,0.35) 0%,transparent 50%),
        radial-gradient(ellipse 50% 40% at 50% 110%,rgba(221,213,255,0.4) 0%,transparent 50%),
        linear-gradient(160deg,#EDE8FF 0%,#F8F5FF 50%,#EEE8FF 100%);
}
body::after{
    content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
    background-image:radial-gradient(circle,rgba(107,70,193,0.08) 1px,transparent 1px);
    background-size:36px 36px;
}

/* ── Breadcrumb ── */
.breadcrumb{
    position:relative;z-index:1;
    display:flex;align-items:center;gap:8px;
    margin-bottom:24px;font-size:13px;
    color:var(--muted);flex-wrap:wrap;
}
.breadcrumb a{color:var(--p5);text-decoration:none;font-weight:500;transition:color .2s ease;}
.breadcrumb a:hover{color:var(--p4);}
.breadcrumb-separator{color:var(--b3);}
.breadcrumb-current{color:var(--txt);font-weight:600;}

/* ── Page Header ── */
.page-header{
    position:relative;z-index:1;
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:24px;margin-bottom:32px;
    display:flex;align-items:center;gap:20px;
    backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
    box-shadow:var(--sh-md);
}
.page-header-icon{
    width:64px;height:64px;border-radius:var(--r-lg);
    background:linear-gradient(135deg,rgba(107,70,193,.15),rgba(124,95,212,.25));
    border:1px solid var(--b2);
    display:flex;align-items:center;justify-content:center;
    color:var(--p5);font-size:28px;
}
.page-header-info h1{
    font-family:var(--ff-d);font-size:24px;font-weight:700;
    color:var(--txt);margin-bottom:6px;letter-spacing:-.02em;
}
.page-header-info p{font-size:14px;color:var(--muted);margin:0;}

/* ── Stats ── */
.stats-grid{
    position:relative;z-index:1;
    display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;margin-bottom:40px;
}
.stat-card{
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:22px;transition:all .3s cubic-bezier(.22,1,.36,1);
    backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
    position:relative;overflow:hidden;
    animation:fadeUp .6s cubic-bezier(.22,1,.36,1) both;
}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
.stat-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:1px;
    background:linear-gradient(90deg,transparent,rgba(200,184,255,.4),transparent);
    opacity:0;transition:opacity .3s;
}
.stat-card:hover{border-color:var(--b2);transform:translateY(-4px);box-shadow:var(--sh-md);}
.stat-card:hover::before{opacity:1;}
.stat-icon{
    width:40px;height:40px;border-radius:var(--r-sm);
    background:var(--s2);border:1px solid var(--b2);
    display:flex;align-items:center;justify-content:center;
    color:var(--p5);font-size:16px;margin-bottom:16px;
    transition:transform .3s,color .3s;
}
.stat-card:hover .stat-icon{transform:scale(1.1) rotate(-5deg);color:var(--p4);}
.stat-value{
    font-family:var(--ff-d);font-size:32px;font-weight:700;
    color:var(--txt);margin-bottom:6px;line-height:1;letter-spacing:-.02em;
    transition:color .3s;
}
.stat-card:hover .stat-value{color:var(--p4);}
.stat-label{font-size:11px;font-weight:500;color:var(--muted);letter-spacing:.04em;text-transform:uppercase;}

/* ── Section Header ── */
.section-header{
    position:relative;z-index:1;
    display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;
}
.section-title{
    font-family:var(--ff-d);font-size:22px;font-weight:700;
    color:var(--txt);position:relative;padding-left:16px;letter-spacing:-.02em;
}
.section-title::before{
    content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);
    width:3px;height:18px;
    background:linear-gradient(to bottom,var(--p4),var(--p7));
    border-radius:var(--r-full);
}

/* ── Buttons ── */
.btn{
    display:inline-flex;align-items:center;gap:8px;
    padding:10px 20px;border-radius:var(--r-md);
    font-family:var(--ff-b);font-size:13px;font-weight:600;
    cursor:pointer;border:none;
    transition:all .25s cubic-bezier(.22,1,.36,1);
    letter-spacing:.01em;text-decoration:none;
    position:relative;overflow:hidden;white-space:nowrap;
}
.btn-primary{
    background:linear-gradient(135deg,var(--p4) 0%,var(--p5) 100%);color:#fff;
    box-shadow:0 4px 16px rgba(91,63,181,.4),inset 0 1px 0 rgba(255,255,255,.15);
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(91,63,181,.55);}
.btn-secondary{
    background:var(--s2);color:var(--txt2);
    border:1px solid var(--b2);backdrop-filter:blur(8px);
}
.btn-secondary:hover{background:var(--s3);color:var(--txt);border-color:var(--b3);transform:translateY(-1px);}

/* ── Search Bar ── */
.search-bar{position:relative;z-index:1;margin-bottom:20px;}
.search-input{
    width:100%;padding:12px 16px 12px 44px;
    background:var(--s2);border:1.5px solid var(--b1);
    border-radius:var(--r-md);color:var(--txt);
    font-family:var(--ff-b);font-size:14px;
    transition:all .25s ease;backdrop-filter:blur(8px);
}
.search-input::placeholder{color:rgba(144,128,192,.5);}
.search-input:focus{
    border-color:var(--p5);outline:none;
    background:rgba(91,63,181,.06);
    box-shadow:0 0 0 4px rgba(91,63,181,.12);
}
.search-icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--muted);}

/* ── Table ── */
.table-container{
    position:relative;z-index:1;
    background:var(--s2);border:1px solid var(--b1);
    border-radius:var(--r-lg);overflow:hidden;margin-bottom:60px;
    backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
    box-shadow:var(--sh-md);
}
.table{width:100%;border-collapse:collapse;}
.table thead{
    background:linear-gradient(90deg,rgba(107,70,193,.06),rgba(107,70,193,.03));
    border-bottom:1px solid var(--b2);
}
.table th{
    padding:16px 20px;text-align:left;
    font-family:var(--ff-b);font-size:10px;font-weight:700;
    color:var(--muted);text-transform:uppercase;letter-spacing:.12em;
}
.table td{
    padding:16px 20px;border-bottom:1px solid var(--b1);
    font-family:var(--ff-b);font-size:14px;color:var(--txt);
}
.table tbody tr{transition:all .2s ease;}
.table tbody tr:hover{background:rgba(107,70,193,.04);}
.table tbody tr:last-child td{border-bottom:none;}

.file-name{display:flex;align-items:center;gap:12px;}
.file-icon{
    width:36px;height:36px;border-radius:var(--r-sm);
    background:linear-gradient(135deg,rgba(107,70,193,.12),rgba(124,95,212,.08));
    border:1px solid var(--b1);
    display:flex;align-items:center;justify-content:center;
    color:var(--p5);font-size:14px;flex-shrink:0;
}
.file-title{font-weight:600;color:var(--txt);margin-bottom:2px;}
.file-meta{font-size:12px;color:var(--muted);}
.file-desc{
    font-size:12px;color:var(--muted);white-space:nowrap;
    overflow:hidden;text-overflow:ellipsis;max-width:200px;
}

.table-actions{display:flex;gap:6px;justify-content:flex-end;}
.btn-icon{
    width:32px;height:32px;border-radius:var(--r-sm);
    display:flex;align-items:center;justify-content:center;
    background:var(--s2);border:1px solid var(--b1);
    color:var(--muted);cursor:pointer;font-size:13px;
    transition:all .2s cubic-bezier(.34,1.56,.64,1);
}
.btn-icon:hover{transform:scale(1.12);}
.btn-icon.download:hover{color:var(--p5);border-color:var(--b3);background:rgba(107,70,193,.1);box-shadow:0 0 10px rgba(107,70,193,.15);}
.btn-icon.edit:hover{color:var(--emerald);border-color:rgba(5,150,105,.3);background:rgba(5,150,105,.1);box-shadow:0 0 10px rgba(5,150,105,.15);}
.btn-icon.delete:hover{color:var(--rose);border-color:rgba(220,38,38,.3);background:rgba(220,38,38,.1);box-shadow:0 0 10px rgba(220,38,38,.15);}

/* ── Empty State ── */
.empty-state{text-align:center;padding:60px 30px;}
.empty-state i{font-size:48px;color:var(--p6);margin-bottom:20px;opacity:.7;display:block;}
.empty-state h3{
    font-family:var(--ff-d);font-size:22px;font-weight:700;
    color:var(--txt);margin-bottom:10px;letter-spacing:-.02em;
}
.empty-state p{font-size:14px;font-weight:300;color:var(--muted);max-width:400px;margin:0 auto;line-height:1.65;}

/* ── FAB ── */
.fab{
    position:fixed;bottom:32px;right:32px;
    width:56px;height:56px;border-radius:var(--r-full);
    background:linear-gradient(135deg,var(--p4),var(--p5));
    color:#fff;border:none;font-size:20px;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 8px 32px rgba(91,63,181,.55),0 0 0 1px rgba(200,184,255,.2);
    transition:all .35s cubic-bezier(.34,1.56,.64,1);z-index:100;
}
.fab:hover{transform:translateY(-4px) rotate(90deg) scale(1.08);box-shadow:0 16px 48px rgba(91,63,181,.7);}

/* ── Modal ── */
.modal-overlay{
    position:fixed;inset:0;
    background:rgba(8,4,20,.88);
    backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);
    display:none;align-items:center;justify-content:center;
    z-index:2000;padding:20px;
}
.modal-content{
    background:linear-gradient(160deg,#FDFBFF 0%,#F5F0FF 50%,#FDFBFF 100%);
    border:1px solid var(--b2);border-radius:var(--r-xl);
    max-width:500px;width:100%;
    box-shadow:var(--sh-xl),0 0 0 1px rgba(200,184,255,.05);
    position:relative;overflow:hidden;
    max-height:90vh;overflow-y:auto;
    animation:modalIn .4s cubic-bezier(.22,1,.36,1) both;
}
@keyframes modalIn{from{opacity:0;transform:translateY(28px) scale(.95);}to{opacity:1;transform:translateY(0) scale(1);}}
.modal-content::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--p5),var(--p7),transparent);
}
.modal-header{
    display:flex;justify-content:space-between;align-items:center;
    padding:28px 28px 0;margin-bottom:24px;
}
.modal-header h3{
    font-family:var(--ff-d);font-size:20px;font-weight:700;
    color:var(--txt);letter-spacing:-.02em;
}
.btn-close{
    width:34px;height:34px;border-radius:var(--r-sm);
    background:var(--s2);border:1px solid var(--b2);
    color:var(--muted);display:flex;align-items:center;justify-content:center;
    cursor:pointer;font-size:13px;transition:all .22s;
}
.btn-close:hover{background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.25);color:var(--rose);transform:rotate(90deg);}

.form-group{margin-bottom:18px;padding:0 28px;}
.form-label{
    display:block;font-size:10px;font-weight:700;color:var(--muted);
    margin-bottom:8px;letter-spacing:.14em;text-transform:uppercase;
}
.form-input{
    width:100%;padding:11px 15px;
    background:rgba(255,255,255,.9);border:1.5px solid var(--b2);
    border-radius:var(--r-md);color:var(--txt);
    font-size:14px;font-family:var(--ff-b);
    transition:all .25s;outline:none;
}
.form-input::placeholder{color:rgba(144,128,192,.5);}
.form-input:focus{border-color:var(--p5);background:rgba(91,63,181,.06);box-shadow:0 0 0 4px rgba(91,63,181,.12);}
textarea.form-input{resize:vertical;min-height:80px;line-height:1.55;}

/* File Upload */
.file-upload-area{
    border:2px dashed var(--b2);border-radius:var(--r-md);
    padding:30px 20px;text-align:center;
    transition:all .25s ease;cursor:pointer;
    background:rgba(107,70,193,.03);
}
.file-upload-area:hover,.file-upload-area.dragover{
    border-color:var(--p5);background:rgba(107,70,193,.07);
}
.upload-icon{font-size:36px;color:var(--p6);margin-bottom:12px;}
.upload-text{font-size:14px;color:var(--txt);margin-bottom:4px;font-weight:500;}
.upload-subtext{font-size:12px;color:var(--muted);}
.file-input{display:none;}
.selected-file{
    margin-top:12px;padding:10px 14px;
    background:rgba(107,70,193,.08);border:1px solid var(--b2);
    border-radius:var(--r-md);display:none;align-items:center;gap:10px;
}
.selected-file.active{display:flex;}
.selected-file-name{font-size:13px;color:var(--txt);font-weight:500;}
.selected-file-size{font-size:11px;color:var(--muted);}
.remove-file{color:var(--rose);cursor:pointer;margin-left:auto;}

.form-footer{
    display:flex;justify-content:flex-end;gap:10px;
    padding:20px 28px;border-top:1px solid var(--b1);margin-top:8px;
}
.invalid-feedback{display:none;color:var(--rose);font-size:11.5px;font-weight:500;margin-top:5px;padding-left:2px;}

/* ── Responsive ── */
@media(max-width:768px){
    .stats-grid{grid-template-columns:repeat(2,1fr);}
    .section-header{flex-direction:column;align-items:flex-start;gap:12px;}
    .table{display:block;overflow-x:auto;}
    .page-header{flex-direction:column;text-align:center;}
}
@media(max-width:480px){.stats-grid{grid-template-columns:1fr;}}
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
    <div style="display:flex;gap:10px;">
        <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
        <button class="btn btn-primary" id="addBtn"><i class="fas fa-cloud-upload-alt"></i> Upload Dokumen</button>
    </div>
</div>

<div class="search-bar">
    <i class="fas fa-search search-icon"></i>
    <input type="text" class="search-input" id="searchInput" placeholder="Cari dokumen…">
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th style="width:40%">Nama Dokumen</th>
                <th style="width:20%">Deskripsi</th>
                <th style="width:12%">Ukuran</th>
                <th style="width:13%">Tanggal</th>
                <th style="width:15%;text-align:right">Aksi</th>
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
                <label class="form-label">Deskripsi <span style="color:var(--muted);font-weight:400;text-transform:none;letter-spacing:0">(opsional)</span></label>
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
                    File <span id="fileOptional" style="display:none;color:var(--muted);font-weight:400;text-transform:none;letter-spacing:0">(opsional — kosongkan jika tidak ingin mengganti)</span>
                </label>
                <div class="file-upload-area" id="fileUploadArea">
                    <div class="upload-icon"><i class="fas fa-map"></i></div>
                    <div class="upload-text">Klik atau drag & drop file di sini</div>
                    <div class="upload-subtext">Maksimal 50MB</div>
                </div>
                <input type="file" class="file-input" id="fileInput" name="file">
                <div class="selected-file" id="selectedFileDiv">
                    <i class="fas fa-file" style="color:var(--p5)"></i>
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
            const e = document.getElementById(id);
            if (e) { e.style.display = 'none'; e.textContent = ''; }
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
            </td>`;
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

    el.searchInput.addEventListener('input', e => {
        const q = e.target.value.toLowerCase();
        renderTable(allData.filter(d => d.name.toLowerCase().includes(q) || (d.desc || '').toLowerCase().includes(q)));
    });

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
                document.getElementById('itemId').value   = d.id;
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
                    const errEl = document.getElementById(`${key}Error`);
                    if (errEl) { errEl.textContent = errors[key][0]; errEl.style.display = 'block'; }
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