@extends('admin.partials.layout')

@section('title', $kategori->name . ' - ' . $tahunDetail->name)
@section('page-title', $kategori->name)
@section('page-subtitle', 'Manajemen Data Arsip • ' . $kategoriDetail->name . ' • ' . $tahunDetail->name)

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
    --p4:#6B46C1;--p5:#7C5FD4;--p6:#9B7FE8;--p7:#B794F4;--p8:#DDD5FF;
    --s1:rgba(255,255,255,0.55);--s2:rgba(255,255,255,0.80);--s3:rgba(255,255,255,0.96);
    --b1:rgba(107,70,193,0.10);--b2:rgba(107,70,193,0.20);--b3:rgba(107,70,193,0.36);
    --txt:#2D1F5E;--txt2:#5540A0;--muted:#9080C0;
    --emerald:#059669;--rose:#DC2626;--amber:#D97706;
    --ff-d:'Cormorant Garamond',Georgia,serif;--ff-b:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px;--r-md:14px;--r-lg:20px;--r-xl:28px;--r-full:9999px;
    --sh-sm:0 2px 8px rgba(107,70,193,0.08);
    --sh-md:0 4px 20px rgba(107,70,193,0.12);
    --sh-lg:0 8px 36px rgba(107,70,193,0.16);
    --sh-xl:0 20px 56px rgba(107,70,193,0.22);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--ff-b);background:#F3EEFF;color:var(--txt);min-height:100vh;position:relative;overflow-x:hidden;}
body::before{
    content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
    background:
        radial-gradient(ellipse 80% 60% at -5% -10%,rgba(196,176,255,0.55) 0%,transparent 55%),
        radial-gradient(ellipse 60% 50% at 105% 105%,rgba(167,139,250,0.35) 0%,transparent 50%),
        linear-gradient(160deg,#EDE8FF 0%,#F8F5FF 50%,#EEE8FF 100%);
}
body::after{
    content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
    background-image:radial-gradient(circle,rgba(107,70,193,0.07) 1px,transparent 1px);
    background-size:36px 36px;
}

/* ── Breadcrumb ── */
.breadcrumb{position:relative;z-index:1;display:flex;align-items:center;gap:8px;margin-bottom:24px;font-size:13px;color:var(--muted);flex-wrap:wrap;}
.breadcrumb a{color:var(--p5);text-decoration:none;font-weight:500;transition:color .2s;}
.breadcrumb a:hover{color:var(--p4);}
.breadcrumb-separator{color:var(--p8);}
.breadcrumb-current{color:var(--txt);font-weight:600;}

/* ── Page Header ── */
.page-header{
    position:relative;z-index:1;
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:24px;margin-bottom:32px;display:flex;align-items:center;gap:20px;
    backdrop-filter:blur(16px);box-shadow:var(--sh-md);overflow:hidden;
}
.page-header::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);
}
.page-header-icon{
    width:64px;height:64px;border-radius:var(--r-lg);
    background:linear-gradient(135deg,rgba(107,70,193,.15),rgba(155,127,232,.08));
    border:1px solid var(--b2);display:flex;align-items:center;justify-content:center;
    color:var(--p5);font-size:26px;flex-shrink:0;transition:transform .3s;
}
.page-header:hover .page-header-icon{transform:scale(1.05) rotate(-3deg);}
.page-header-info h1{font-family:var(--ff-d);font-size:22px;font-weight:700;color:var(--txt);margin-bottom:5px;letter-spacing:-.02em;}
.page-header-info p{font-size:13px;color:var(--muted);margin:0;font-weight:300;}

/* ── Stats Grid ── */
.stats-grid{position:relative;z-index:1;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:32px;}
.stat-card{
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:20px;backdrop-filter:blur(16px);position:relative;overflow:hidden;
    transition:transform .3s cubic-bezier(.34,1.56,.64,1),border-color .3s;
    animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both;
}
.stat-card:nth-child(1){animation-delay:.04s;}
.stat-card:nth-child(2){animation-delay:.09s;}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(107,70,193,.3),transparent);opacity:0;transition:opacity .3s;}
.stat-card:hover{transform:translateY(-3px);border-color:var(--b2);box-shadow:var(--sh-md);}
.stat-card:hover::before{opacity:1;}
.stat-icon{
    width:38px;height:38px;border-radius:var(--r-sm);
    background:linear-gradient(135deg,rgba(107,70,193,.12),rgba(155,127,232,.08));
    border:1px solid var(--b2);display:flex;align-items:center;justify-content:center;
    font-size:15px;color:var(--p5);margin-bottom:14px;
    transition:transform .3s,color .3s;
}
.stat-card:hover .stat-icon{transform:scale(1.1) rotate(-5deg);color:var(--p4);}
.stat-value{font-family:var(--ff-d);font-size:26px;font-weight:700;color:var(--txt);margin-bottom:4px;letter-spacing:-.03em;}
.stat-label{font-size:11px;color:var(--muted);font-weight:500;letter-spacing:.04em;text-transform:uppercase;}

/* ── Section Header ── */
.section-header{position:relative;z-index:1;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.section-title{font-family:var(--ff-d);font-size:20px;font-weight:700;color:var(--txt);display:flex;align-items:center;gap:12px;letter-spacing:-.02em;}
.section-title::before{content:'';display:inline-block;width:3px;height:20px;background:linear-gradient(to bottom,var(--p5),var(--p6));border-radius:var(--r-full);}

/* ── Buttons ── */
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:var(--r-md);font-family:var(--ff-b);font-size:13px;font-weight:600;cursor:pointer;border:none;transition:all .25s cubic-bezier(.22,1,.36,1);text-decoration:none;position:relative;overflow:hidden;white-space:nowrap;}
.btn-primary{background:linear-gradient(135deg,var(--p4),var(--p5));color:#fff;box-shadow:0 4px 16px rgba(107,70,193,.35),inset 0 1px 0 rgba(255,255,255,.15);}
.btn-primary::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);transition:left .55s;}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(107,70,193,.45);}
.btn-primary:hover::before{left:100%;}
.btn-secondary{background:var(--s2);color:var(--txt2);border:1px solid var(--b2);backdrop-filter:blur(8px);}
.btn-secondary:hover{background:var(--s3);color:var(--txt);border-color:var(--b3);transform:translateY(-1px);}
.btn-success{background:linear-gradient(135deg,#059669,#10B981);color:#fff;box-shadow:0 4px 14px rgba(5,150,105,.3);}
.btn-success:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(5,150,105,.4);}

/* ── Search Bar ── */
.search-bar{position:relative;z-index:1;margin-bottom:16px;}
.search-input{
    width:100%;padding:11px 16px 11px 44px;
    background:var(--s2);border:1.5px solid var(--b1);
    border-radius:var(--r-md);color:var(--txt);font-size:13px;font-family:var(--ff-b);
    backdrop-filter:blur(8px);transition:all .25s;outline:none;
}
.search-input::placeholder{color:var(--muted);}
.search-input:focus{border-color:var(--p5);background:var(--s3);box-shadow:0 0 0 4px rgba(107,70,193,.08);}
.search-icon{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px;}

/* ── Table Wrapper ── */
.table-wrapper{
    position:relative;z-index:1;
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    overflow:hidden;margin-bottom:80px;backdrop-filter:blur(16px);
    box-shadow:var(--sh-md);
}
.table-wrapper::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);
}
.table-scroll{overflow-x:auto;}
.table{width:100%;border-collapse:collapse;min-width:1400px;}
.table thead{background:rgba(107,70,193,.05);border-bottom:1px solid var(--b1);}
.table th{
    padding:13px 14px;text-align:left;
    font-size:10px;font-weight:700;color:var(--p5);
    text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;
}
.table td{
    padding:13px 14px;border-bottom:1px solid rgba(107,70,193,.06);
    font-size:13px;color:var(--txt);vertical-align:top;
}
.table tbody tr{transition:background .2s;}
.table tbody tr:hover{background:rgba(107,70,193,.04);}
.table tbody tr:last-child td{border-bottom:none;}

.td-no{width:50px;text-align:center;color:var(--muted);}
.td-kode{width:120px;}
.td-uraian{min-width:250px;}
.uraian-text{line-height:1.5;}
.td-waktu{width:120px;}
.td-jumlah{width:80px;}
.td-jenis{width:100px;}
.td-tingkat{width:120px;}
.td-tanggal{width:110px;}
.td-extra{min-width:120px;}
.td-ket{min-width:150px;color:var(--muted);font-size:12px;}
.td-aksi{width:90px;}

/* ── Badges ── */
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:var(--r-full);font-size:11px;font-weight:600;}
.badge-good{background:rgba(5,150,105,.1);color:var(--emerald);border:1px solid rgba(5,150,105,.2);}
.badge-rusak{background:rgba(220,38,38,.1);color:var(--rose);border:1px solid rgba(220,38,38,.2);}
.badge-default{background:rgba(107,70,193,.1);color:var(--p5);border:1px solid var(--b2);}

/* ── Row Actions ── */
.row-actions{display:flex;gap:5px;}
.btn-icon{
    width:30px;height:30px;border-radius:var(--r-sm);
    display:flex;align-items:center;justify-content:center;
    background:rgba(255,255,255,.7);border:1px solid var(--b1);
    color:var(--muted);cursor:pointer;transition:all .2s;font-size:12px;
}
.btn-icon:hover{transform:scale(1.12);}
.btn-icon.edit:hover{color:var(--emerald);background:rgba(5,150,105,.08);border-color:rgba(5,150,105,.25);}
.btn-icon.delete:hover{color:var(--rose);background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.25);}

/* ── Empty State ── */
.empty-state{text-align:center;padding:60px 30px;}
.empty-state i{font-size:44px;color:var(--p5);margin-bottom:16px;opacity:.5;display:block;}
.empty-state h3{font-family:var(--ff-d);font-size:18px;font-weight:700;color:var(--txt);margin-bottom:8px;letter-spacing:-.02em;}
.empty-state p{font-size:13px;color:var(--muted);font-weight:300;}

/* ── FAB ── */
.fab{position:fixed;bottom:32px;right:32px;width:52px;height:52px;border-radius:var(--r-full);background:linear-gradient(135deg,var(--p4),var(--p5));color:#fff;border:none;font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 28px rgba(107,70,193,.45);transition:all .35s cubic-bezier(.34,1.56,.64,1);z-index:100;}
.fab:hover{transform:translateY(-4px) rotate(90deg) scale(1.08);box-shadow:0 14px 40px rgba(107,70,193,.6);}

/* ── Modal ── */
.modal-overlay{position:fixed;inset:0;background:rgba(45,31,94,.5);backdrop-filter:blur(12px);display:none;align-items:center;justify-content:center;z-index:2000;padding:20px;}
.modal-content{
    background:linear-gradient(160deg,#FDFBFF 0%,#F5F0FF 60%,#FDFBFF 100%);
    border:1px solid var(--b2);border-radius:var(--r-xl);padding:0;
    max-width:880px;width:100%;
    box-shadow:var(--sh-xl);position:relative;overflow:hidden;
    max-height:90vh;overflow-y:auto;
    animation:modalIn .4s cubic-bezier(.22,1,.36,1) both;
}
@keyframes modalIn{from{opacity:0;transform:translateY(24px) scale(.95);}to{opacity:1;transform:translateY(0) scale(1);}}
.modal-content::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);z-index:10;}
.modal-header{display:flex;justify-content:space-between;align-items:flex-start;padding:26px 28px 0;margin-bottom:20px;position:sticky;top:0;background:rgba(253,251,255,.95);backdrop-filter:blur(8px);z-index:5;padding-top:28px;}
.modal-eyebrow{font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--p5);margin-bottom:5px;}
.modal-header h3{font-family:var(--ff-d);font-size:21px;font-weight:700;color:var(--txt);letter-spacing:-.02em;}
.btn-close{width:32px;height:32px;border-radius:var(--r-sm);background:rgba(107,70,193,.08);border:1px solid var(--b2);color:var(--muted);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;transition:all .22s;flex-shrink:0;}
.btn-close:hover{background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.25);color:var(--rose);transform:rotate(90deg);}

.modal-body{padding:0 28px;position:relative;z-index:1;}

/* Form Grid */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-grid .span-2{grid-column:1/-1;}
.form-group{margin-bottom:0;}
.form-label{display:flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:var(--muted);margin-bottom:6px;letter-spacing:.12em;text-transform:uppercase;}
.form-label span{color:var(--rose);}
.form-input{
    width:100%;padding:10px 13px;
    background:rgba(255,255,255,.9);border:1.5px solid var(--b2);
    border-radius:var(--r-md);color:var(--txt);font-size:13px;font-family:var(--ff-b);
    transition:all .25s;outline:none;
}
.form-input::placeholder{color:rgba(144,128,192,.5);}
.form-input:focus{border-color:var(--p5);background:#fff;box-shadow:0 0 0 4px rgba(107,70,193,.08);}
textarea.form-input{resize:vertical;min-height:75px;line-height:1.55;}
select.form-input option{background:#F5F0FF;color:var(--txt);}
.invalid-feedback{display:none;color:var(--rose);font-size:11px;font-weight:500;margin-top:3px;}

.section-divider{grid-column:1/-1;border:none;border-top:1px solid var(--b1);margin:4px 0;}
.section-label{grid-column:1/-1;font-size:10px;font-weight:700;color:var(--p5);text-transform:uppercase;letter-spacing:.1em;margin-bottom:-4px;}

.form-footer{
    display:flex;justify-content:flex-end;gap:10px;
    padding:20px 28px;border-top:1px solid var(--b1);
    margin-top:22px;position:sticky;bottom:0;
    background:rgba(253,251,255,.95);backdrop-filter:blur(8px);z-index:5;
}

/* ── Code Cell ── */
code.kode{color:var(--p5);font-size:12px;background:rgba(107,70,193,.08);padding:2px 7px;border-radius:5px;font-family:'Courier New',monospace;}

/* ── Responsive ── */
@media(max-width:768px){
    .form-grid{grid-template-columns:1fr;}
    .form-grid .span-2{grid-column:1;}
    .page-header{flex-direction:column;text-align:center;}
    .section-header{flex-direction:column;align-items:flex-start;gap:10px;}
}
</style>
@endsection

@section('content')
<nav class="breadcrumb">
    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('kategori.detail.index', $kategori->id) }}">{{ $kategori->name }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('kategori.detail.tahun.index', [$kategori->id, $kategoriDetail->id]) }}">{{ $kategoriDetail->name }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-current">{{ $tahunDetail->name }}</span>
</nav>

<div class="page-header">
    <div class="page-header-icon">
        <i class="{{ $kategori->icon ?? 'fas fa-list-alt' }}"></i>
    </div>
    <div class="page-header-info">
        <h1>{{ $kategori->name }} — {{ $tahunDetail->name }}</h1>
        <p>{{ $kategoriDetail->name }} • {{ $kategori->desc }}</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-list"></i></div>
        <div class="stat-value" id="totalInput">{{ $totalInput }}</div>
        <div class="stat-label">Total Data Arsip</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-value" id="latestUpdate" style="font-size:18px">-</div>
        <div class="stat-label">Update Terakhir</div>
    </div>
</div>

<div class="section-header">
    <h2 class="section-title">Daftar Arsip</h2>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
        <a href="{{ route('kategori.detail.tahun.input.export', [$kategori->id, $kategoriDetail->id, $tahunDetail->id]) }}"
            class="btn btn-success" style="text-decoration:none;">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        @if($userRole === 'admin')
        <button class="btn btn-primary" id="addBtn"><i class="fas fa-plus"></i> Tambah Data</button>
        @endif
    </div>
</div>

<div class="search-bar">
    <i class="fas fa-search search-icon"></i>
    <input type="text" class="search-input" id="searchInput" placeholder="Cari uraian, kode klasifikasi, jenis arsip...">
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
                    <th class="td-extra">No. Folder</th>
                    <th class="td-extra">Jangka Simpan</th>
                    <th class="td-extra">Nasib Akhir</th>
                    <th class="td-extra">Lbr</th>
                    <th class="td-ket">Ket</th>
                    @if($userRole === 'admin')<th class="td-aksi">Aksi</th>@endif
                </tr>
                @else
                <tr>
                    <th class="td-no">No.</th>
                    <th class="td-jenis">Jenis Arsip</th>
                    <th class="td-extra">No Box</th>
                    <th class="td-extra">No Berkas</th>
                    <th class="td-extra">No. Perjanjian</th>
                    <th class="td-extra">Pihak I</th>
                    <th class="td-extra">Pihak II</th>
                    <th class="td-tingkat">Tingkat Perkembangan</th>
                    <th class="td-tanggal">Tgl Berlaku</th>
                    <th class="td-tanggal">Tgl Berakhir</th>
                    <th class="td-extra">Media</th>
                    <th class="td-jumlah">Jumlah</th>
                    <th class="td-extra">Jangka Simpan</th>
                    <th class="td-extra">Lokasi Simpan</th>
                    <th class="td-extra">Metode</th>
                    <th class="td-ket">Ket</th>
                    @if($userRole === 'admin')<th class="td-aksi">Aksi</th>@endif
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

<div class="modal-overlay" id="mainModal">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <div class="modal-eyebrow">Kelola Data</div>
                <h3 id="modalTitle">Tambah Data Arsip</h3>
            </div>
            <button class="btn-close" id="closeModalBtn"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="mainForm">
                @csrf
                <input type="hidden" id="itemId">

                @if($kategori->name === 'Daftar Arsip Usul Musnah')
                <div class="form-grid">
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
                    <div class="form-group span-2">
                        <label class="form-label">Uraian Informasi <span>*</span></label>
                        <textarea class="form-input" id="fUraian" name="uraian_informasi" required placeholder="Deskripsi arsip..."></textarea>
                        <div class="invalid-feedback" id="uraian_informasiError"></div>
                    </div>
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
                    <div class="form-group">
                        <label class="form-label">Jumlah <span>*</span></label>
                        <input type="text" class="form-input" id="fJumlah" name="jumlah" required placeholder="Contoh: 5 Berkas">
                        <div class="invalid-feedback" id="jumlahError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Box</label>
                        <input type="text" class="form-input" id="fNoBox" name="no_box" placeholder="Contoh: B-001">
                    </div>
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
                    <div class="form-group">
                        <label class="form-label">Nomor Folder</label>
                        <input type="text" class="form-input" id="fNomorFolder" name="nomor_folder" placeholder="Contoh: F-001">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jangka Simpan <span>*</span></label>
                        <input type="text" class="form-input" id="fJangka" name="jangka_simpan" required placeholder="Contoh: 5 Tahun">
                        <div class="invalid-feedback" id="jangka_simpanError"></div>
                    </div>
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
                    <div class="form-group span-2">
                        <label class="form-label">Ket</label>
                        <textarea class="form-input" id="fKet" name="keterangan" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>

                @else
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">No. <span>*</span></label>
                        <input type="number" class="form-input" id="fNo" name="no" min="1" required>
                        <div class="invalid-feedback" id="noError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Arsip <span>*</span></label>
                        <input type="text" class="form-input" id="fJenisArsip" name="jenis_arsip" required placeholder="Contoh: Vital, Permanen">
                        <div class="invalid-feedback" id="jenis_arsipError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No Box</label>
                        <input type="text" class="form-input" id="fNoBox" name="no_box" placeholder="Contoh: B-001">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No Berkas</label>
                        <input type="text" class="form-input" id="fNoBerkas" name="no_berkas" placeholder="Contoh: BRK-001">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Perjanjian Kerjasama</label>
                        <input type="text" class="form-input" id="fNoPerjanjian" name="no_perjanjian_kerjasama" placeholder="Contoh: PKS-001">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pihak I</label>
                        <input type="text" class="form-input" id="fPihakI" name="pihak_i" placeholder="Nama pihak pertama">
                    </div>
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
                    <div class="form-group">
                        <label class="form-label">Tanggal Berlaku</label>
                        <input type="date" class="form-input" id="fTanggalBerlaku" name="tanggal_berlaku">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Berakhir</label>
                        <input type="date" class="form-input" id="fTanggalBerakhir" name="tanggal_berakhir">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Media</label>
                        <input type="text" class="form-input" id="fMedia" name="media" placeholder="Jenis media">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah <span>*</span></label>
                        <input type="text" class="form-input" id="fJumlah" name="jumlah" required placeholder="Contoh: 5 Berkas">
                        <div class="invalid-feedback" id="jumlahError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jangka Simpan</label>
                        <input type="text" class="form-input" id="fJangka" name="jangka_simpan" placeholder="Contoh: 10 Tahun">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lokasi Simpan</label>
                        <input type="text" class="form-input" id="fLokasi" name="lokasi_simpan" placeholder="Contoh: Ruang Arsip Lantai 2">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metode Perlindungan</label>
                        <input type="text" class="form-input" id="fMetode" name="metode_perlindungan" placeholder="Contoh: Brankas, Digital">
                    </div>
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

function clearErrors(){
    ['noError','kode_klasifikasiError','uraian_informasiError','kurun_waktuError',
     'jumlahError','jangka_simpanError','nasib_akhir_arsipError','jenis_arsipError'
    ].forEach(id=>{const e=document.getElementById(id);if(e){e.style.display='none';e.textContent='';}});
}
function resetForm(){elForm.mainForm.reset();document.getElementById('itemId').value='';currentId=null;clearErrors();}
function setField(id,val){const e=document.getElementById(id);if(e)e.value=val||'';}

function getKondisiBadge(kondisi){
    if(!kondisi)return'-';
    if(kondisi==='Baik')return`<span class="badge badge-good">${kondisi}</span>`;
    if(kondisi.includes('Rusak'))return`<span class="badge badge-rusak">${kondisi}</span>`;
    return`<span class="badge badge-default">${kondisi}</span>`;
}

async function loadStats(){
    try{
        const res=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/stats`);
        if(res.data.success){
            document.getElementById('totalInput').textContent=res.data.data.total_input||0;
            document.getElementById('latestUpdate').textContent=res.data.data.latest_update||'-';
        }
    }catch(e){console.log('stats error',e);}
}

async function loadData(){
    showLoading();
    try{
        const res=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input`);
        if(res.data.success){allData=res.data.data||[];renderTable(allData);}
        else renderEmpty();
    }catch(e){showNotification('Gagal memuat data','error');renderEmpty();}
    finally{hideLoading();}
}

function renderTable(data){
    if(!data||data.length===0){renderEmpty();return;}
    elForm.tableBody.innerHTML='';
    data.forEach(item=>elForm.tableBody.appendChild(createRow(item)));
}

function createRow(item){
    const tr=document.createElement('tr');
    if(isMusnah){
        tr.innerHTML=`
            <td class="td-no">${item.no||'-'}</td>
            <td class="td-kode"><code class="kode">${item.kode_klasifikasi||'-'}</code></td>
            <td class="td-uraian"><div class="uraian-text">${item.uraian_informasi||'-'}</div></td>
            <td class="td-waktu">${item.kurun_waktu||'-'}</td>
            <td class="td-tingkat">${item.tingkat_perkembangan||'-'}</td>
            <td class="td-jumlah">${item.jumlah||'-'}</td>
            <td class="td-extra">${item.no_box||'-'}</td>
            <td class="td-extra">${item.media_simpan||'-'}</td>
            <td class="td-extra">${getKondisiBadge(item.kondisi_fisik)}</td>
            <td class="td-extra">${item.nomor_folder||'-'}</td>
            <td class="td-extra">${item.jangka_simpan||'-'}</td>
            <td class="td-extra">${item.nasib_akhir_arsip?`<span class="badge badge-default">${item.nasib_akhir_arsip}</span>`:'-'}</td>
            <td class="td-extra">${item.lembar||'-'}</td>
            <td class="td-ket">${item.keterangan||'-'}</td>
            ${canEdit?`<td class="td-aksi"><div class="row-actions">
                <button class="btn-icon edit" title="Edit"><i class="fas fa-edit"></i></button>
                <button class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div></td>`:''}`;
    }else{
        tr.innerHTML=`
            <td class="td-no">${item.no||'-'}</td>
            <td class="td-jenis">${item.jenis_arsip||'-'}</td>
            <td class="td-extra">${item.no_box||'-'}</td>
            <td class="td-extra">${item.no_berkas||'-'}</td>
            <td class="td-extra">${item.no_perjanjian_kerjasama||'-'}</td>
            <td class="td-extra">${item.pihak_i||'-'}</td>
            <td class="td-extra">${item.pihak_ii||'-'}</td>
            <td class="td-tingkat">${item.tingkat_perkembangan||'-'}</td>
            <td class="td-tanggal">${item.tanggal_berlaku?new Date(item.tanggal_berlaku).toLocaleDateString('id-ID'):'-'}</td>
            <td class="td-tanggal">${item.tanggal_berakhir?new Date(item.tanggal_berakhir).toLocaleDateString('id-ID'):'-'}</td>
            <td class="td-extra">${item.media||'-'}</td>
            <td class="td-jumlah">${item.jumlah||'-'}</td>
            <td class="td-extra">${item.jangka_simpan||'-'}</td>
            <td class="td-extra">${item.lokasi_simpan||'-'}</td>
            <td class="td-extra">${item.metode_perlindungan||'-'}</td>
            <td class="td-ket">${item.keterangan||'-'}</td>
            ${canEdit?`<td class="td-aksi"><div class="row-actions">
                <button class="btn-icon edit" title="Edit"><i class="fas fa-edit"></i></button>
                <button class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div></td>`:''}`;
    }
    if(canEdit){
        tr.querySelector('.edit')?.addEventListener('click',()=>openEdit(item.id));
        tr.querySelector('.delete')?.addEventListener('click',()=>deleteItem(item.id));
    }
    return tr;
}

function renderEmpty(){
    const colspan=isMusnah?(canEdit?15:14):(canEdit?17:16);
    elForm.tableBody.innerHTML=`<tr><td colspan="${colspan}">
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Data Arsip</h3>
            <p>Tambahkan data arsip untuk tahun ini.</p>
        </div>
    </td></tr>`;
}

elForm.searchInput?.addEventListener('input',e=>{
    const q=e.target.value.toLowerCase();
    renderTable(allData.filter(d=>{
        if(isMusnah)return(d.uraian_informasi||'').toLowerCase().includes(q)||(d.kode_klasifikasi||'').toLowerCase().includes(q);
        return(d.jenis_arsip||'').toLowerCase().includes(q)||(d.pihak_i||'').toLowerCase().includes(q)||(d.pihak_ii||'').toLowerCase().includes(q);
    }));
});

function openAdd(){
    resetForm();
    document.getElementById('modalTitle').textContent='Tambah Data Arsip';
    document.getElementById('submitText').textContent='Simpan';
    const nextNo=allData.length>0?Math.max(...allData.map(d=>d.no||0))+1:1;
    setField('fNo',nextNo);
    elForm.mainModal.style.display='flex';
}

async function openEdit(id){
    showLoading();
    try{
        const res=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${id}/edit`);
        if(res.data.success){
            const d=res.data.data;resetForm();currentId=d.id;
            document.getElementById('modalTitle').textContent='Edit Data Arsip';
            document.getElementById('submitText').textContent='Update';
            document.getElementById('itemId').value=d.id;
            setField('fNo',d.no);
            if(isMusnah){
                setField('fKodeKlasifikasi',d.kode_klasifikasi);setField('fUraian',d.uraian_informasi);
                setField('fKurun',d.kurun_waktu);setField('fTingkat',d.tingkat_perkembangan);
                setField('fJumlah',d.jumlah);setField('fNoBox',d.no_box);
                setField('fMediaSimpan',d.media_simpan);setField('fKondisi',d.kondisi_fisik);
                setField('fNomorFolder',d.nomor_folder);setField('fJangka',d.jangka_simpan);
                setField('fNasib',d.nasib_akhir_arsip);setField('fLembar',d.lembar);setField('fKet',d.keterangan);
            }else{
                setField('fJenisArsip',d.jenis_arsip);setField('fNoBox',d.no_box);
                setField('fNoBerkas',d.no_berkas);setField('fNoPerjanjian',d.no_perjanjian_kerjasama);
                setField('fPihakI',d.pihak_i);setField('fPihakII',d.pihak_ii);
                setField('fTingkat',d.tingkat_perkembangan);setField('fTanggalBerlaku',d.tanggal_berlaku);
                setField('fTanggalBerakhir',d.tanggal_berakhir);setField('fMedia',d.media);
                setField('fJumlah',d.jumlah);setField('fJangka',d.jangka_simpan);
                setField('fLokasi',d.lokasi_simpan);setField('fMetode',d.metode_perlindungan);setField('fKet',d.keterangan);
            }
            elForm.mainModal.style.display='flex';
        }
    }catch(e){showNotification('Gagal memuat data','error');}
    finally{hideLoading();}
}

function closeModal(){elForm.mainModal.style.display='none';resetForm();}

elForm.mainForm?.addEventListener('submit',async e=>{
    e.preventDefault();clearErrors();
    const noVal=document.getElementById('fNo')?.value;
    if(!noVal){
        const err=document.getElementById('noError');
        if(err){err.textContent='No harus diisi';err.style.display='block';}
        showNotification('No harus diisi','error');return;
    }
    if(!isMusnah){
        const jenisVal=document.getElementById('fJenisArsip')?.value;
        if(!jenisVal){
            const err=document.getElementById('jenis_arsipError');
            if(err){err.textContent='Jenis Arsip harus dipilih';err.style.display='block';}
            showNotification('Jenis Arsip harus dipilih','error');return;
        }
    }
    const formData=new FormData(elForm.mainForm);
    if(currentId)formData.append('_method','PUT');
    const url=currentId
        ?`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${currentId}`
        :`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input`;
    showLoading();
    try{
        const res=await axios.post(url,formData,{headers:{'X-CSRF-TOKEN':csrfToken}});
        if(res.data.success){showNotification(res.data.message,'success');await loadStats();await loadData();closeModal();}
    }catch(e){
        if(e.response?.status===422){
            const errors=e.response.data.errors;
            Object.keys(errors).forEach(key=>{
                const err=document.getElementById(`${key}Error`);
                if(err){err.textContent=errors[key][0];err.style.display='block';}
            });
            showNotification('Periksa kembali form Anda','error');
        }else showNotification(e.response?.data?.message||'Terjadi kesalahan','error');
    }finally{hideLoading();}
});

async function deleteItem(id){
    if(!confirm('Yakin ingin menghapus data arsip ini?'))return;
    showLoading();
    try{
        const res=await axios.delete(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${id}`,{headers:{'X-CSRF-TOKEN':csrfToken}});
        if(res.data.success){showNotification(res.data.message,'success');await loadStats();await loadData();}
    }catch(e){showNotification('Gagal menghapus data','error');}
    finally{hideLoading();}
}

if(canEdit){
    document.getElementById('addBtn')?.addEventListener('click',openAdd);
    document.getElementById('fabBtn')?.addEventListener('click',openAdd);
}
document.getElementById('refreshBtn')?.addEventListener('click',()=>{
    const icon=document.getElementById('refreshBtn').querySelector('i');
    icon.classList.add('fa-spin');
    Promise.all([loadStats(),loadData()]).finally(()=>setTimeout(()=>icon.classList.remove('fa-spin'),700));
});
document.getElementById('closeModalBtn')?.addEventListener('click',closeModal);
document.getElementById('cancelBtn')?.addEventListener('click',closeModal);
elForm.mainModal?.addEventListener('click',e=>{if(e.target===elForm.mainModal)closeModal();});
document.addEventListener('keydown',e=>{if(e.key==='Escape'&&elForm.mainModal?.style.display==='flex')closeModal();});

document.addEventListener('DOMContentLoaded',()=>{loadStats();loadData();});
</script>
@endsection