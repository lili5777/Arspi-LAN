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
.breadcrumb{position:relative;z-index:1;display:flex;align-items:center;gap:8px;margin-bottom:24px;font-size:13px;color:var(--muted);flex-wrap:wrap;}
.breadcrumb a{color:var(--p5);text-decoration:none;font-weight:500;transition:color .2s;}
.breadcrumb a:hover{color:var(--p4);}
.breadcrumb-separator{color:var(--p8);}
.breadcrumb-current{color:var(--txt);font-weight:600;}
.page-header{
    position:relative;z-index:1;
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:24px;margin-bottom:32px;display:flex;align-items:center;gap:20px;
    backdrop-filter:blur(16px);box-shadow:var(--sh-md);overflow:hidden;
}
.page-header::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);}
.page-header-icon{width:64px;height:64px;border-radius:var(--r-lg);background:linear-gradient(135deg,rgba(107,70,193,.15),rgba(155,127,232,.08));border:1px solid var(--b2);display:flex;align-items:center;justify-content:center;color:var(--p5);font-size:26px;flex-shrink:0;transition:transform .3s;}
.page-header:hover .page-header-icon{transform:scale(1.05) rotate(-3deg);}
.page-header-info h1{font-family:var(--ff-d);font-size:22px;font-weight:700;color:var(--txt);margin-bottom:5px;letter-spacing:-.02em;}
.page-header-info p{font-size:13px;color:var(--muted);margin:0;font-weight:300;}
.stats-grid{position:relative;z-index:1;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:32px;}
.stat-card{background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);padding:20px;backdrop-filter:blur(16px);position:relative;overflow:hidden;transition:transform .3s cubic-bezier(.34,1.56,.64,1),border-color .3s;animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both;}
.stat-card:nth-child(1){animation-delay:.04s;}
.stat-card:nth-child(2){animation-delay:.09s;}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(107,70,193,.3),transparent);opacity:0;transition:opacity .3s;}
.stat-card:hover{transform:translateY(-3px);border-color:var(--b2);box-shadow:var(--sh-md);}
.stat-card:hover::before{opacity:1;}
.stat-icon{width:38px;height:38px;border-radius:var(--r-sm);background:linear-gradient(135deg,rgba(107,70,193,.12),rgba(155,127,232,.08));border:1px solid var(--b2);display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--p5);margin-bottom:14px;transition:transform .3s,color .3s;}
.stat-card:hover .stat-icon{transform:scale(1.1) rotate(-5deg);color:var(--p4);}
.stat-value{font-family:var(--ff-d);font-size:26px;font-weight:700;color:var(--txt);margin-bottom:4px;letter-spacing:-.03em;}
.stat-label{font-size:11px;color:var(--muted);font-weight:500;letter-spacing:.04em;text-transform:uppercase;}
.section-header{position:relative;z-index:1;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.section-title{font-family:var(--ff-d);font-size:20px;font-weight:700;color:var(--txt);display:flex;align-items:center;gap:12px;letter-spacing:-.02em;}
.section-title::before{content:'';display:inline-block;width:3px;height:20px;background:linear-gradient(to bottom,var(--p5),var(--p6));border-radius:var(--r-full);}
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:var(--r-md);font-family:var(--ff-b);font-size:13px;font-weight:600;cursor:pointer;border:none;transition:all .25s cubic-bezier(.22,1,.36,1);text-decoration:none;position:relative;overflow:hidden;white-space:nowrap;}
.btn-primary{background:linear-gradient(135deg,var(--p4),var(--p5));color:#fff;box-shadow:0 4px 16px rgba(107,70,193,.35),inset 0 1px 0 rgba(255,255,255,.15);}
.btn-primary::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);transition:left .55s;}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(107,70,193,.45);}
.btn-primary:hover::before{left:100%;}
.btn-secondary{background:var(--s2);color:var(--txt2);border:1px solid var(--b2);backdrop-filter:blur(8px);}
.btn-secondary:hover{background:var(--s3);color:var(--txt);border-color:var(--b3);transform:translateY(-1px);}
.btn-success{background:linear-gradient(135deg,#059669,#10B981);color:#fff;box-shadow:0 4px 14px rgba(5,150,105,.3);}
.btn-success:hover{transform:translateY(-2px);box-shadow:0 8px 20px rgba(5,150,105,.4);}

/* ===== FILTER PANEL ===== */
.filter-panel{
    position:relative;z-index:1;
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:0;margin-bottom:16px;
    backdrop-filter:blur(16px);box-shadow:var(--sh-sm);
    overflow:hidden;
    transition:all .3s cubic-bezier(.22,1,.36,1);
}
.filter-panel::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p6),transparent);}
.filter-toggle{
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 20px;cursor:pointer;
    border:none;background:transparent;width:100%;text-align:left;
    font-family:var(--ff-b);
}
.filter-toggle-left{display:flex;align-items:center;gap:10px;}
.filter-toggle-label{font-size:13px;font-weight:600;color:var(--txt2);}
.filter-active-count{
    display:none;
    background:linear-gradient(135deg,var(--p4),var(--p5));
    color:#fff;font-size:10px;font-weight:700;
    padding:2px 8px;border-radius:var(--r-full);
    letter-spacing:.04em;
}
.filter-active-count.show{display:inline-flex;}
.filter-toggle-icon{color:var(--muted);font-size:12px;transition:transform .3s;}
.filter-panel.open .filter-toggle-icon{transform:rotate(180deg);}
.filter-body{
    display:none;padding:0 20px 20px;
    border-top:1px solid var(--b1);
    animation:fadeDown .25s ease both;
}
@keyframes fadeDown{from{opacity:0;transform:translateY(-6px);}to{opacity:1;transform:translateY(0);}}
.filter-panel.open .filter-body{display:block;}
.filter-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px;margin-top:16px;}
.filter-group{}
.filter-label{font-size:10px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.1em;margin-bottom:5px;display:block;}
.filter-input{width:100%;padding:8px 11px;background:rgba(255,255,255,.9);border:1.5px solid var(--b2);border-radius:var(--r-md);color:var(--txt);font-size:12px;font-family:var(--ff-b);transition:all .25s;outline:none;}
.filter-input::placeholder{color:rgba(144,128,192,.5);}
.filter-input:focus{border-color:var(--p5);background:#fff;box-shadow:0 0 0 3px rgba(107,70,193,.08);}
select.filter-input option{background:#F5F0FF;color:var(--txt);}
.filter-actions{display:flex;gap:8px;margin-top:14px;align-items:center;flex-wrap:wrap;}
.btn-filter-apply{padding:8px 16px;font-size:12px;}
.btn-filter-reset{padding:8px 14px;font-size:12px;}
.filter-separator{height:1px;background:var(--b1);margin:14px 0 0;}

/* ===== SEARCH BAR ===== */
.search-filter-row{position:relative;z-index:1;display:flex;gap:10px;margin-bottom:16px;align-items:center;}
.search-bar{flex:1;position:relative;}
.search-input{width:100%;padding:11px 16px 11px 44px;background:var(--s2);border:1.5px solid var(--b1);border-radius:var(--r-md);color:var(--txt);font-size:13px;font-family:var(--ff-b);backdrop-filter:blur(8px);transition:all .25s;outline:none;}
.search-input::placeholder{color:var(--muted);}
.search-input:focus{border-color:var(--p5);background:var(--s3);box-shadow:0 0 0 4px rgba(107,70,193,.08);}
.search-icon{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:13px;}

/* ===== TABLE ===== */
.table-wrapper{position:relative;z-index:1;background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);overflow:hidden;backdrop-filter:blur(16px);box-shadow:var(--sh-md);}
.table-wrapper::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);}
.table-scroll{overflow-x:auto;}
.table{width:100%;border-collapse:collapse;min-width:1400px;}
.table thead{background:rgba(107,70,193,.05);border-bottom:1px solid var(--b1);}
.table th{padding:13px 14px;text-align:left;font-size:10px;font-weight:700;color:var(--p5);text-transform:uppercase;letter-spacing:.08em;white-space:nowrap;}
.table td{padding:13px 14px;border-bottom:1px solid rgba(107,70,193,.06);font-size:13px;color:var(--txt);vertical-align:top;}
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

/* ===== PAGINATION ===== */
.table-footer{
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 20px;border-top:1px solid var(--b1);
    flex-wrap:wrap;gap:12px;
    background:rgba(107,70,193,.02);
}
.pagination-info{font-size:12px;color:var(--muted);font-weight:500;}
.pagination-info strong{color:var(--txt2);}
.pagination-controls{display:flex;align-items:center;gap:4px;}
.pg-btn{
    min-width:32px;height:32px;border-radius:var(--r-sm);
    display:inline-flex;align-items:center;justify-content:center;
    background:transparent;border:1px solid transparent;
    color:var(--muted);font-size:12px;font-family:var(--ff-b);font-weight:600;
    cursor:pointer;transition:all .2s;padding:0 6px;
    text-decoration:none;
}
.pg-btn:hover:not(:disabled):not(.disabled){background:var(--b1);border-color:var(--b2);color:var(--txt2);}
.pg-btn.active{background:linear-gradient(135deg,var(--p4),var(--p5));border-color:transparent;color:#fff;box-shadow:0 2px 8px rgba(107,70,193,.3);}
.pg-btn:disabled,.pg-btn.disabled{opacity:.35;cursor:not-allowed;}
.pg-ellipsis{padding:0 4px;color:var(--muted);font-size:13px;}
.per-page-select{
    padding:6px 10px;background:rgba(255,255,255,.9);border:1.5px solid var(--b2);
    border-radius:var(--r-md);color:var(--txt);font-size:12px;font-family:var(--ff-b);
    outline:none;cursor:pointer;transition:all .25s;
}
.per-page-select:focus{border-color:var(--p5);}
.per-page-wrapper{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--muted);}

/* ===== BADGES ===== */
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:var(--r-full);font-size:11px;font-weight:600;}
.badge-good{background:rgba(5,150,105,.1);color:var(--emerald);border:1px solid rgba(5,150,105,.2);}
.badge-rusak{background:rgba(220,38,38,.1);color:var(--rose);border:1px solid rgba(220,38,38,.2);}
.badge-default{background:rgba(107,70,193,.1);color:var(--p5);border:1px solid var(--b2);}
.badge-terbuka{background:rgba(5,150,105,.1);color:var(--emerald);border:1px solid rgba(5,150,105,.2);}
.badge-terbatas{background:rgba(217,119,6,.1);color:var(--amber);border:1px solid rgba(217,119,6,.2);}
.badge-rahasia{background:rgba(220,38,38,.1);color:var(--rose);border:1px solid rgba(220,38,38,.2);}
.row-actions{display:flex;gap:5px;}
.btn-icon{width:30px;height:30px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.7);border:1px solid var(--b1);color:var(--muted);cursor:pointer;transition:all .2s;font-size:12px;}
.btn-icon:hover{transform:scale(1.12);}
.btn-icon.edit:hover{color:var(--emerald);background:rgba(5,150,105,.08);border-color:rgba(5,150,105,.25);}
.btn-icon.delete:hover{color:var(--rose);background:rgba(220,38,38,.08);border-color:rgba(220,38,38,.25);}
.empty-state{text-align:center;padding:60px 30px;}
.empty-state i{font-size:44px;color:var(--p5);margin-bottom:16px;opacity:.5;display:block;}
.empty-state h3{font-family:var(--ff-d);font-size:18px;font-weight:700;color:var(--txt);margin-bottom:8px;letter-spacing:-.02em;}
.empty-state p{font-size:13px;color:var(--muted);font-weight:300;}
.fab{position:fixed;bottom:32px;right:32px;width:52px;height:52px;border-radius:var(--r-full);background:linear-gradient(135deg,var(--p4),var(--p5));color:#fff;border:none;font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 28px rgba(107,70,193,.45);transition:all .35s cubic-bezier(.34,1.56,.64,1);z-index:100;}
.fab:hover{transform:translateY(-4px) rotate(90deg) scale(1.08);box-shadow:0 14px 40px rgba(107,70,193,.6);}

/* ===== RESULTS INFO BAR ===== */
.results-info-bar{
    position:relative;z-index:1;
    display:flex;align-items:center;justify-content:space-between;
    padding:8px 14px;margin-bottom:8px;
    background:rgba(107,70,193,.04);border:1px solid var(--b1);border-radius:var(--r-md);
    font-size:12px;color:var(--muted);flex-wrap:wrap;gap:6px;
}
.results-info-bar strong{color:var(--txt2);}
.filter-tags{display:flex;gap:6px;flex-wrap:wrap;}
.filter-tag{
    display:inline-flex;align-items:center;gap:4px;
    background:rgba(107,70,193,.1);border:1px solid var(--b2);
    color:var(--p5);font-size:10px;font-weight:600;
    padding:2px 8px;border-radius:var(--r-full);
}
.filter-tag-remove{cursor:pointer;opacity:.7;font-size:9px;transition:opacity .2s;}
.filter-tag-remove:hover{opacity:1;}
.table-wrapper-outer{margin-bottom:80px;}

/* ===== MODAL ===== */
.modal-overlay{position:fixed;inset:0;background:rgba(45,31,94,.5);backdrop-filter:blur(12px);display:none;align-items:center;justify-content:center;z-index:2000;padding:20px;}
.modal-content{background:linear-gradient(160deg,#FDFBFF 0%,#F5F0FF 60%,#FDFBFF 100%);border:1px solid var(--b2);border-radius:var(--r-xl);padding:0;max-width:880px;width:100%;box-shadow:var(--sh-xl);position:relative;overflow:hidden;max-height:90vh;overflow-y:auto;animation:modalIn .4s cubic-bezier(.22,1,.36,1) both;}
@keyframes modalIn{from{opacity:0;transform:translateY(24px) scale(.95);}to{opacity:1;transform:translateY(0) scale(1);}}
.modal-content::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);z-index:10;}
.modal-header{display:flex;justify-content:space-between;align-items:flex-start;padding:26px 28px 0;margin-bottom:20px;position:sticky;top:0;background:rgba(253,251,255,.95);backdrop-filter:blur(8px);z-index:5;padding-top:28px;}
.modal-eyebrow{font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--p5);margin-bottom:5px;}
.modal-header h3{font-family:var(--ff-d);font-size:21px;font-weight:700;color:var(--txt);letter-spacing:-.02em;}
.btn-close{width:32px;height:32px;border-radius:var(--r-sm);background:rgba(107,70,193,.08);border:1px solid var(--b2);color:var(--muted);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;transition:all .22s;flex-shrink:0;}
.btn-close:hover{background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.25);color:var(--rose);transform:rotate(90deg);}
.modal-body{padding:0 28px;position:relative;z-index:1;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.form-grid .span-2{grid-column:1/-1;}
.form-grid .span-3{grid-column:1/-1;}
.form-group{margin-bottom:0;}
.form-label{display:flex;align-items:center;gap:4px;font-size:10px;font-weight:700;color:var(--muted);margin-bottom:6px;letter-spacing:.12em;text-transform:uppercase;}
.form-label span{color:var(--rose);}
.form-input{width:100%;padding:10px 13px;background:rgba(255,255,255,.9);border:1.5px solid var(--b2);border-radius:var(--r-md);color:var(--txt);font-size:13px;font-family:var(--ff-b);transition:all .25s;outline:none;}
.form-input::placeholder{color:rgba(144,128,192,.5);}
.form-input:focus{border-color:var(--p5);background:#fff;box-shadow:0 0 0 4px rgba(107,70,193,.08);}
textarea.form-input{resize:vertical;min-height:75px;line-height:1.55;}
select.form-input option{background:#F5F0FF;color:var(--txt);}
.invalid-feedback{display:none;color:var(--rose);font-size:11px;font-weight:500;margin-top:3px;}
.section-divider{grid-column:1/-1;border:none;border-top:1px solid var(--b1);margin:4px 0;}
.section-label{grid-column:1/-1;font-size:10px;font-weight:700;color:var(--p5);text-transform:uppercase;letter-spacing:.1em;margin-bottom:-4px;}
.form-footer{display:flex;justify-content:flex-end;gap:10px;padding:20px 28px;border-top:1px solid var(--b1);margin-top:22px;position:sticky;bottom:0;background:rgba(253,251,255,.95);backdrop-filter:blur(8px);z-index:5;}
code.kode{color:var(--p5);font-size:12px;background:rgba(107,70,193,.08);padding:2px 7px;border-radius:5px;font-family:'Courier New',monospace;}

@keyframes slideInRight{from{opacity:0;transform:translateX(40px);}to{opacity:1;transform:translateX(0);}}
@media(max-width:768px){
    .form-grid{grid-template-columns:1fr;}
    .form-grid .span-2,.form-grid .span-3{grid-column:1;}
    .page-header{flex-direction:column;text-align:center;}
    .section-header{flex-direction:column;align-items:flex-start;gap:10px;}
    .filter-grid{grid-template-columns:1fr 1fr;}
    .table-footer{flex-direction:column;align-items:flex-start;}
    .per-page-wrapper{order:-1;}
}
@media(max-width:480px){
    .filter-grid{grid-template-columns:1fr;}
    .search-filter-row{flex-direction:column;}
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
        <button class="btn btn-secondary" id="importBtn" style="border-color:rgba(5,150,105,.3);color:#059669;">
            <i class="fas fa-file-import"></i> Import Excel
        </button>
        <button class="btn btn-primary" id="addBtn"><i class="fas fa-plus"></i> Tambah Data</button>
        @endif
    </div>
</div>

{{-- ===== FILTER PANEL ===== --}}
<div class="filter-panel" id="filterPanel">
    <button class="filter-toggle" id="filterToggle">
        <div class="filter-toggle-left">
            <i class="fas fa-sliders-h" style="color:var(--p5);font-size:14px;"></i>
            <span class="filter-toggle-label">Filter Data</span>
            <span class="filter-active-count" id="filterActiveCount">0 aktif</span>
        </div>
        <i class="fas fa-chevron-down filter-toggle-icon"></i>
    </button>
    <div class="filter-body" id="filterBody">

        @if($kategori->name === 'Daftar Arsip Usul Musnah')
        <div class="filter-grid">
            <div class="filter-group">
                <label class="filter-label">Kode Klasifikasi</label>
                <input type="text" class="filter-input" id="flt_kode_klasifikasi" placeholder="Cari kode...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Kurun Waktu</label>
                <input type="text" class="filter-input" id="flt_kurun_waktu" placeholder="Contoh: 2020">
            </div>
            <div class="filter-group">
                <label class="filter-label">Tingkat Perkembangan</label>
                <select class="filter-input" id="flt_tingkat_perkembangan">
                    <option value="">-- Semua --</option>
                    <option value="Asli">Asli</option>
                    <option value="Fotokopi">Fotokopi</option>
                    <option value="Salinan">Salinan</option>
                    <option value="Tembusan">Tembusan</option>
                    <option value="Disposisi">Disposisi</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Media Simpan</label>
                <select class="filter-input" id="flt_media_simpan">
                    <option value="">-- Semua --</option>
                    <option value="Kertas">Kertas</option>
                    <option value="Digital">Digital</option>
                    <option value="Mikrofilm">Mikrofilm</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Kondisi Fisik</label>
                <select class="filter-input" id="flt_kondisi_fisik">
                    <option value="">-- Semua --</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Nasib Akhir</label>
                <select class="filter-input" id="flt_nasib_akhir_arsip">
                    <option value="">-- Semua --</option>
                    <option value="Musnah">Musnah</option>
                    <option value="Permanen">Permanen</option>
                    <option value="Dinilai Kembali">Dinilai Kembali</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">No. Box</label>
                <input type="text" class="filter-input" id="flt_no_box" placeholder="Cari box...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Jangka Simpan</label>
                <input type="text" class="filter-input" id="flt_jangka_simpan" placeholder="Contoh: 5 Tahun">
            </div>
        </div>

        @elseif($kategori->name === 'Arsip Inaktif Persuratan')
        <div class="filter-grid">
            <div class="filter-group">
                <label class="filter-label">Unit Kerja</label>
                <input type="text" class="filter-input" id="flt_unit_kerja" placeholder="Cari unit kerja...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Kode Klasifikasi</label>
                <input type="text" class="filter-input" id="flt_kode_klasifikasi_persuratan" placeholder="Cari kode...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Tingkat Perkembangan</label>
                <select class="filter-input" id="flt_tingkat_perkembangan_persuratan">
                    <option value="">-- Semua --</option>
                    <option value="Asli">Asli</option>
                    <option value="Fotokopi">Fotokopi</option>
                    <option value="Salinan">Salinan</option>
                    <option value="Tembusan">Tembusan</option>
                    <option value="Disposisi">Disposisi</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Klasifikasi Keamanan</label>
                <select class="filter-input" id="flt_klasifikasi_keamanan">
                    <option value="">-- Semua --</option>
                    <option value="Terbuka">Terbuka</option>
                    <option value="Terbatas">Terbatas</option>
                    <option value="Rahasia">Rahasia</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Tanggal Dari</label>
                <input type="date" class="filter-input" id="flt_tgl_dari">
            </div>
            <div class="filter-group">
                <label class="filter-label">Tanggal Sampai</label>
                <input type="date" class="filter-input" id="flt_tgl_sampai">
            </div>
            <div class="filter-group">
                <label class="filter-label">No. Filling Cabinet</label>
                <input type="text" class="filter-input" id="flt_no_filling_cabinet" placeholder="Cari FC...">
            </div>
            <div class="filter-group">
                <label class="filter-label">No. Berkas</label>
                <input type="text" class="filter-input" id="flt_no_berkas_persuratan" placeholder="Cari no berkas...">
            </div>
        </div>

        @else
        <div class="filter-grid">
            <div class="filter-group">
                <label class="filter-label">Jenis Arsip</label>
                <input type="text" class="filter-input" id="flt_jenis_arsip" placeholder="Contoh: Vital, Permanen">
            </div>
            <div class="filter-group">
                <label class="filter-label">Tingkat Perkembangan</label>
                <select class="filter-input" id="flt_tingkat_perkembangan">
                    <option value="">-- Semua --</option>
                    <option value="Asli">Asli</option>
                    <option value="Fotokopi">Fotokopi</option>
                    <option value="Salinan">Salinan</option>
                    <option value="Tembusan">Tembusan</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Pihak I</label>
                <input type="text" class="filter-input" id="flt_pihak_i" placeholder="Cari pihak I...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Pihak II</label>
                <input type="text" class="filter-input" id="flt_pihak_ii" placeholder="Cari pihak II...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Media</label>
                <input type="text" class="filter-input" id="flt_media" placeholder="Cari media...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Lokasi Simpan</label>
                <input type="text" class="filter-input" id="flt_lokasi_simpan" placeholder="Cari lokasi...">
            </div>
            <div class="filter-group">
                <label class="filter-label">Berlaku Dari</label>
                <input type="date" class="filter-input" id="flt_berlaku_dari">
            </div>
            <div class="filter-group">
                <label class="filter-label">Berlaku Sampai</label>
                <input type="date" class="filter-input" id="flt_berlaku_sampai">
            </div>
        </div>
        @endif

        <div class="filter-separator"></div>
        <div class="filter-actions">
            <button class="btn btn-primary btn-filter-apply" id="applyFilterBtn"><i class="fas fa-filter"></i> Terapkan Filter</button>
            <button class="btn btn-secondary btn-filter-reset" id="resetFilterBtn"><i class="fas fa-times"></i> Reset Filter</button>
            <span style="font-size:12px;color:var(--muted);margin-left:auto;" id="filterResultInfo"></span>
        </div>
    </div>
</div>

{{-- ===== SEARCH + INFO ===== --}}
<div class="search-filter-row">
    <div class="search-bar">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" id="searchInput" placeholder="Cari uraian, kode klasifikasi, jenis arsip...">
    </div>
</div>

<div class="results-info-bar" id="resultsInfoBar" style="display:none;">
    <div>
        Menampilkan <strong id="infoShowing">-</strong> dari <strong id="infoTotal">-</strong> data
        <span id="infoFilteredFrom" style="display:none;"> (difilter dari <strong id="infoAllTotal">-</strong> total)</span>
    </div>
    <div class="filter-tags" id="filterTagsContainer"></div>
</div>

<div class="table-wrapper-outer">
    <div class="table-wrapper">
        <div class="table-scroll">
            <table class="table">
                <thead>
                    @if($kategori->name === 'Daftar Arsip Usul Musnah')
                    <tr>
                        <th class="td-no">#</th>
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
                    @elseif($kategori->name === 'Arsip Inaktif Persuratan')
                    <tr>
                        <th class="td-extra">No. Berkas</th>
                        <th class="td-extra">Unit Kerja</th>
                        <th class="td-extra">No. Item Arsip</th>
                        <th class="td-kode">Kode Klasifikasi</th>
                        <th class="td-uraian">Uraian Informasi Isi Arsip</th>
                        <th class="td-tanggal">Tgl</th>
                        <th class="td-tingkat">Tingkat Perkembangan</th>
                        <th class="td-jumlah">Jumlah (lbr)</th>
                        <th class="td-extra">No. Filling Cabinet</th>
                        <th class="td-extra">No. Laci</th>
                        <th class="td-extra">No. Folder</th>
                        <th class="td-extra">Klasifikasi Keamanan</th>
                        <th class="td-ket">Ket</th>
                        @if($userRole === 'admin')<th class="td-aksi">Aksi</th>@endif
                    </tr>
                    @else
                    <tr>
                        <th class="td-no">#</th>
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

        <div class="table-footer" id="tableFooter" style="display:none;">
            <div class="per-page-wrapper">
                <span>Tampilkan</span>
                <select class="per-page-select" id="perPageSelect">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>per halaman</span>
            </div>
            <div class="pagination-info" id="paginationInfo">-</div>
            <div class="pagination-controls" id="paginationControls"></div>
        </div>
    </div>
</div>

@if($userRole === 'admin')
<button class="fab" id="fabBtn"><i class="fas fa-plus"></i></button>
@endif

{{-- ===== MODAL TAMBAH/EDIT ===== --}}
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
                        <label class="form-label">Kode Klasifikasi</label>
                        <input type="text" class="form-input" id="fKodeKlasifikasi" name="kode_klasifikasi" placeholder="Contoh: 600.1">
                        <div class="invalid-feedback" id="kode_klasifikasiError"></div>
                    </div>
                    <div class="form-group span-2">
                        <label class="form-label">Uraian Informasi</label>
                        <textarea class="form-input" id="fUraian" name="uraian_informasi" placeholder="Deskripsi arsip..."></textarea>
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
                            <option value="Disposisi">Disposisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah</label>
                        <input type="text" class="form-input" id="fJumlah" name="jumlah" placeholder="Contoh: 5 Berkas">
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
                        <label class="form-label">Jangka Simpan</label>
                        <input type="text" class="form-input" id="fJangka" name="jangka_simpan" placeholder="Contoh: 5 Tahun">
                        <div class="invalid-feedback" id="jangka_simpanError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nasib Akhir Arsip</label>
                        <select class="form-input" id="fNasib" name="nasib_akhir_arsip">
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

                @elseif($kategori->name === 'Arsip Inaktif Persuratan')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">No. Berkas</label>
                        <input type="text" class="form-input" id="fNoBerkasPersuratan" name="no_berkas_persuratan" placeholder="Contoh: 001">
                        <div class="invalid-feedback" id="no_berkas_persurationError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit Kerja</label>
                        <input type="text" class="form-input" id="fUnitKerja" name="unit_kerja" placeholder="Contoh: Bagian Umum">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Item Arsip</label>
                        <input type="text" class="form-input" id="fNomorItem" name="nomor_item_arsip" placeholder="Contoh: 1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Klasifikasi</label>
                        <input type="text" class="form-input" id="fKodeKlasifikasiPersuratan" name="kode_klasifikasi_persuratan" placeholder="Contoh: HKM.02.1">
                    </div>
                    <div class="form-group span-2">
                        <label class="form-label">Uraian Informasi Isi Arsip</label>
                        <textarea class="form-input" id="fUraianPersuratan" name="uraian_informasi_persuratan" placeholder="Deskripsi surat / arsip..."></textarea>
                        <div class="invalid-feedback" id="uraian_informasi_persurationError"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-input" id="fTgl" name="tgl">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tingkat Perkembangan</label>
                        <select class="form-input" id="fTingkatPersuratan" name="tingkat_perkembangan_persuratan">
                            <option value="">-- Pilih --</option>
                            <option value="Asli">Asli</option>
                            <option value="Fotokopi">Fotokopi</option>
                            <option value="Salinan">Salinan</option>
                            <option value="Tembusan">Tembusan</option>
                            <option value="Disposisi">Disposisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah (lbr)</label>
                        <input type="text" class="form-input" id="fJumlahLembar" name="jumlah_lembar" placeholder="Contoh: 5">
                    </div>
                    <hr class="section-divider">
                    <div class="section-label">Lokasi Penyimpanan</div>
                    <div class="form-group">
                        <label class="form-label">No. Filling Cabinet</label>
                        <input type="text" class="form-input" id="fNoFillingCabinet" name="no_filling_cabinet" placeholder="Contoh: FC-01">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Laci</label>
                        <input type="text" class="form-input" id="fNoLaci" name="no_laci" placeholder="Contoh: L-02">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Folder</label>
                        <input type="text" class="form-input" id="fNoFolderPersuratan" name="no_folder_persuratan" placeholder="Contoh: F-003">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Klasifikasi Keamanan</label>
                        <select class="form-input" id="fKlasifikasiKeamanan" name="klasifikasi_keamanan">
                            <option value="">-- Pilih --</option>
                            <option value="Terbuka">Terbuka</option>
                            <option value="Terbatas">Terbatas</option>
                            <option value="Rahasia">Rahasia</option>
                        </select>
                    </div>
                    <div class="form-group span-2">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-input" id="fKetPersuratan" name="keterangan_persuratan" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>

                @else
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Jenis Arsip</label>
                        <input type="text" class="form-input" id="fJenisArsip" name="jenis_arsip" placeholder="Contoh: Vital, Permanen">
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
                        <label class="form-label">Jumlah</label>
                        <input type="text" class="form-input" id="fJumlah" name="jumlah" placeholder="Contoh: 5 Berkas">
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

{{-- ===== MODAL IMPORT ===== --}}
<div class="modal-overlay" id="importModal">
    <div class="modal-content" style="max-width:480px;">
        <div class="modal-header">
            <div>
                <div class="modal-eyebrow">Upload File</div>
                <h3>Import Data dari Excel</h3>
            </div>
            <button class="btn-close" id="closeImportBtn"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" style="padding-bottom:0;">
            <div style="background:rgba(107,70,193,.05);border:1.5px dashed rgba(107,70,193,.25);border-radius:14px;padding:20px;margin-bottom:20px;">
                <div style="text-align:center;margin-bottom:14px;">
                    <i class="fas fa-file-excel" style="font-size:36px;color:#059669;opacity:.8;"></i>
                    <p style="font-size:12px;color:var(--muted);margin-top:8px;font-weight:500;">Format yang diterima: <strong>.xlsx</strong> atau <strong>.xls</strong></p>
                </div>
                <div style="background:rgba(255,255,255,.7);border-radius:10px;padding:12px 14px;margin-bottom:14px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;">
                        <div style="font-size:12px;color:var(--txt2);line-height:1.6;flex:1;">
                            <i class="fas fa-info-circle" style="color:var(--p5);margin-right:6px;"></i>
                            Pastikan format file sesuai template. Baris header &amp; nomor urut dilewati otomatis.
                            <br><i class="fas fa-copy" style="color:var(--amber);margin-right:4px;"></i>
                            <span style="color:var(--amber);font-weight:600;">Data duplikat (uraian sudah ada) akan dilewati otomatis.</span>
                        </div>
                        <a href="{{ route('kategori.detail.tahun.input.template', [$kategori->id, $kategoriDetail->id, $tahunDetail->id]) }}"
                           style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:linear-gradient(135deg,#059669,#10B981);color:#fff;border-radius:10px;font-size:12px;font-weight:600;text-decoration:none;white-space:nowrap;box-shadow:0 3px 10px rgba(5,150,105,.3);transition:all .2s;"
                           onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 5px 16px rgba(5,150,105,.4)'"
                           onmouseout="this.style.transform='';this.style.boxShadow='0 3px 10px rgba(5,150,105,.3)'">
                            <i class="fas fa-download"></i> Download Template
                        </a>
                    </div>
                </div>
                <div id="dropZone" style="border:1.5px dashed rgba(107,70,193,.3);border-radius:10px;padding:18px;text-align:center;cursor:pointer;transition:all .2s;background:rgba(255,255,255,.6);"
                    ondragover="event.preventDefault();this.style.borderColor='var(--p5)';this.style.background='rgba(107,70,193,.06)'"
                    ondragleave="this.style.borderColor='rgba(107,70,193,.3)';this.style.background='rgba(255,255,255,.6)'"
                    ondrop="handleDrop(event)"
                    onclick="document.getElementById('importFile').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size:22px;color:var(--p5);margin-bottom:8px;display:block;"></i>
                    <p style="font-size:12px;color:var(--muted);margin:0;" id="dropText">Klik atau drag & drop file Excel di sini</p>
                </div>
                <input type="file" id="importFile" accept=".xlsx,.xls" style="display:none;" onchange="handleFileSelect(this)">
            </div>
            <div id="filePreview" style="display:none;background:rgba(5,150,105,.06);border:1px solid rgba(5,150,105,.2);border-radius:10px;padding:12px 14px;margin-bottom:16px;align-items:center;gap:10px;">
                <i class="fas fa-file-excel" style="color:#059669;font-size:20px;flex-shrink:0;"></i>
                <div style="flex:1;min-width:0;">
                    <div id="fileName" style="font-size:13px;font-weight:600;color:var(--txt);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></div>
                    <div id="fileSize" style="font-size:11px;color:var(--muted);"></div>
                </div>
                <button onclick="clearImportFile()" style="background:none;border:none;color:var(--muted);cursor:pointer;font-size:14px;padding:4px;flex-shrink:0;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="importProgress" style="display:none;margin-bottom:16px;">
                <div style="height:6px;background:rgba(107,70,193,.1);border-radius:99px;overflow:hidden;">
                    <div id="progressBar" style="height:100%;background:linear-gradient(90deg,var(--p5),var(--p6));border-radius:99px;width:0%;transition:width .3s;"></div>
                </div>
                <p style="font-size:11px;color:var(--muted);margin-top:6px;text-align:center;" id="progressText">Mengupload...</p>
            </div>
        </div>
        <div class="form-footer">
            <button type="button" class="btn btn-secondary" id="cancelImportBtn">Batal</button>
            <button type="button" class="btn btn-success" id="doImportBtn" disabled style="opacity:.5;cursor:not-allowed;">
                <i class="fas fa-file-import"></i> Import Sekarang
            </button>
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
const isPersuratan = kategoriNama === 'Arsip Inaktif Persuratan';

let allData       = [];
let filteredData  = [];
let currentPage   = 1;
let perPage       = 10;
let currentId     = null;
let activeFilters = {};

const elForm = {
    tableBody:           document.getElementById('tableBody'),
    searchInput:         document.getElementById('searchInput'),
    mainModal:           document.getElementById('mainModal'),
    mainForm:            document.getElementById('mainForm'),
    tableFooter:         document.getElementById('tableFooter'),
    paginationInfo:      document.getElementById('paginationInfo'),
    paginationControls:  document.getElementById('paginationControls'),
    perPageSelect:       document.getElementById('perPageSelect'),
    resultsInfoBar:      document.getElementById('resultsInfoBar'),
    filterTagsContainer: document.getElementById('filterTagsContainer'),
};

/* =========================================================
   HELPERS
   ========================================================= */
function clearErrors(){
    ['noError','kode_klasifikasiError','uraian_informasiError','kurun_waktuError',
     'jumlahError','jangka_simpanError','nasib_akhir_arsipError','jenis_arsipError',
     'uraian_informasi_persurationError']
    .forEach(id=>{const e=document.getElementById(id);if(e){e.style.display='none';e.textContent='';}});
}
function resetForm(){elForm.mainForm.reset();document.getElementById('itemId').value='';currentId=null;clearErrors();}
function setField(id,val){const e=document.getElementById(id);if(e)e.value=val??'';}
function includes_ci(str,q){return(str||'').toLowerCase().includes((q||'').toLowerCase());}

function getKondisiBadge(k){
    if(!k)return'-';
    if(k==='Baik')return`<span class="badge badge-good">${k}</span>`;
    if(k.includes('Rusak'))return`<span class="badge badge-rusak">${k}</span>`;
    return`<span class="badge badge-default">${k}</span>`;
}
function getKeamananBadge(k){
    if(!k)return'-';
    if(k==='Terbuka')return`<span class="badge badge-terbuka">${k}</span>`;
    if(k==='Terbatas')return`<span class="badge badge-terbatas">${k}</span>`;
    if(k==='Rahasia')return`<span class="badge badge-rahasia">${k}</span>`;
    return`<span class="badge badge-default">${k}</span>`;
}
function fmtDate(val){
    if(!val)return'-';
    return new Date(val).toLocaleDateString('id-ID');
}

/* =========================================================
   FILTER ENGINE
   ========================================================= */
function getFilterValues(){
    const vals = {};
    document.querySelectorAll('.filter-input').forEach(el=>{
        if(el.value.trim()) vals[el.id] = el.value.trim();
    });
    return vals;
}

function applyFiltersAndSearch(){
    const q  = (elForm.searchInput.value||'').toLowerCase();
    const fv = activeFilters;

    filteredData = allData.filter(item => {
        // search
        if(q){
            let match = false;
            if(isMusnah)      match = includes_ci(item.uraian_informasi,q)||includes_ci(item.kode_klasifikasi,q)||includes_ci(item.kurun_waktu,q);
            else if(isPersuratan) match = includes_ci(item.uraian_informasi_persuratan,q)||includes_ci(item.kode_klasifikasi_persuratan,q)||includes_ci(item.unit_kerja,q);
            else              match = includes_ci(item.jenis_arsip,q)||includes_ci(item.pihak_i,q)||includes_ci(item.pihak_ii,q)||includes_ci(item.no_perjanjian_kerjasama,q);
            if(!match) return false;
        }
        // filters
        if(isMusnah){
            if(fv.flt_kode_klasifikasi     && !includes_ci(item.kode_klasifikasi,   fv.flt_kode_klasifikasi))    return false;
            if(fv.flt_kurun_waktu          && !includes_ci(item.kurun_waktu,        fv.flt_kurun_waktu))         return false;
            if(fv.flt_tingkat_perkembangan && item.tingkat_perkembangan !== fv.flt_tingkat_perkembangan)         return false;
            if(fv.flt_media_simpan         && item.media_simpan          !== fv.flt_media_simpan)                return false;
            if(fv.flt_kondisi_fisik        && item.kondisi_fisik         !== fv.flt_kondisi_fisik)               return false;
            if(fv.flt_nasib_akhir_arsip    && item.nasib_akhir_arsip     !== fv.flt_nasib_akhir_arsip)           return false;
            if(fv.flt_no_box               && !includes_ci(item.no_box,  fv.flt_no_box))                         return false;
            if(fv.flt_jangka_simpan        && !includes_ci(item.jangka_simpan, fv.flt_jangka_simpan))           return false;
        } else if(isPersuratan){
            if(fv.flt_unit_kerja                      && !includes_ci(item.unit_kerja,                  fv.flt_unit_kerja))                  return false;
            if(fv.flt_kode_klasifikasi_persuratan     && !includes_ci(item.kode_klasifikasi_persuratan, fv.flt_kode_klasifikasi_persuratan)) return false;
            if(fv.flt_tingkat_perkembangan_persuratan && item.tingkat_perkembangan_persuratan !== fv.flt_tingkat_perkembangan_persuratan)    return false;
            if(fv.flt_klasifikasi_keamanan            && item.klasifikasi_keamanan            !== fv.flt_klasifikasi_keamanan)               return false;
            if(fv.flt_no_filling_cabinet              && !includes_ci(item.no_filling_cabinet,           fv.flt_no_filling_cabinet))          return false;
            if(fv.flt_no_berkas_persuratan            && !includes_ci(item.no_berkas_persuratan,         fv.flt_no_berkas_persuratan))        return false;
            if(fv.flt_tgl_dari   && item.tgl && item.tgl < fv.flt_tgl_dari)   return false;
            if(fv.flt_tgl_sampai && item.tgl && item.tgl > fv.flt_tgl_sampai) return false;
        } else {
            if(fv.flt_jenis_arsip          && !includes_ci(item.jenis_arsip,   fv.flt_jenis_arsip))    return false;
            if(fv.flt_tingkat_perkembangan && item.tingkat_perkembangan !== fv.flt_tingkat_perkembangan) return false;
            if(fv.flt_pihak_i              && !includes_ci(item.pihak_i,       fv.flt_pihak_i))        return false;
            if(fv.flt_pihak_ii             && !includes_ci(item.pihak_ii,      fv.flt_pihak_ii))       return false;
            if(fv.flt_media                && !includes_ci(item.media,          fv.flt_media))           return false;
            if(fv.flt_lokasi_simpan        && !includes_ci(item.lokasi_simpan, fv.flt_lokasi_simpan))   return false;
            if(fv.flt_berlaku_dari   && item.tanggal_berlaku  && item.tanggal_berlaku  < fv.flt_berlaku_dari)   return false;
            if(fv.flt_berlaku_sampai && item.tanggal_berakhir && item.tanggal_berakhir > fv.flt_berlaku_sampai) return false;
        }
        return true;
    });

    currentPage = 1;
    renderTable();
    updateResultsInfo();
    updateFilterTags();
}

/* =========================================================
   FILTER TAGS
   ========================================================= */
const filterLabels = {
    flt_kode_klasifikasi:'Kode',flt_kurun_waktu:'Kurun Waktu',flt_tingkat_perkembangan:'Tingkat',
    flt_media_simpan:'Media Simpan',flt_kondisi_fisik:'Kondisi',flt_nasib_akhir_arsip:'Nasib Akhir',
    flt_no_box:'No Box',flt_jangka_simpan:'Jangka Simpan',
    flt_unit_kerja:'Unit Kerja',flt_kode_klasifikasi_persuratan:'Kode',
    flt_tingkat_perkembangan_persuratan:'Tingkat',flt_klasifikasi_keamanan:'Keamanan',
    flt_no_filling_cabinet:'Filling Cabinet',flt_no_berkas_persuratan:'No Berkas',
    flt_tgl_dari:'Tgl Dari',flt_tgl_sampai:'Tgl Sampai',
    flt_jenis_arsip:'Jenis',flt_pihak_i:'Pihak I',flt_pihak_ii:'Pihak II',
    flt_media:'Media',flt_lokasi_simpan:'Lokasi',flt_berlaku_dari:'Berlaku Dari',flt_berlaku_sampai:'Berlaku Sampai',
};
function updateFilterTags(){
    const entries = Object.entries(activeFilters);
    elForm.filterTagsContainer.innerHTML = entries.map(([k,v])=>`
        <span class="filter-tag">
            ${filterLabels[k]||k}: ${v}
            <span class="filter-tag-remove" data-key="${k}" title="Hapus filter"><i class="fas fa-times"></i></span>
        </span>`).join('');
    elForm.filterTagsContainer.querySelectorAll('.filter-tag-remove').forEach(btn=>{
        btn.addEventListener('click',()=>{
            const key=btn.dataset.key;
            const el=document.getElementById(key);
            if(el) el.value='';
            delete activeFilters[key];
            applyFiltersAndSearch();
        });
    });
    const count = entries.length;
    const badge = document.getElementById('filterActiveCount');
    badge.textContent = count+' aktif';
    badge.classList.toggle('show', count>0);
}

function updateResultsInfo(){
    const total    = allData.length;
    const filtered = filteredData.length;
    elForm.resultsInfoBar.style.display = total>0 ? 'flex' : 'none';
    document.getElementById('infoTotal').textContent    = filtered;
    document.getElementById('infoAllTotal').textContent = total;
    document.getElementById('infoFilteredFrom').style.display = (filtered<total) ? '' : 'none';
    const start = Math.min((currentPage-1)*perPage+1, filtered);
    const end   = Math.min(currentPage*perPage, filtered);
    document.getElementById('infoShowing').textContent = filtered===0 ? '0' : `${start}–${end}`;
}

/* =========================================================
   RENDER TABLE + PAGINATION
   ========================================================= */
function renderTable(){
    if(!filteredData||filteredData.length===0){renderEmpty();return;}

    const totalPages = Math.ceil(filteredData.length/perPage);
    if(currentPage>totalPages) currentPage=totalPages;
    const start    = (currentPage-1)*perPage;
    const pageData = filteredData.slice(start, start+perPage);

    elForm.tableBody.innerHTML='';
    pageData.forEach((item,idx)=>elForm.tableBody.appendChild(createRow(item, start+idx)));

    elForm.tableFooter.style.display = filteredData.length>0 ? 'flex' : 'none';
    renderPaginationInfo(filteredData.length, totalPages);
    renderPaginationControls(totalPages);
    updateResultsInfo();
}

function renderPaginationInfo(total, totalPages){
    const start = Math.min((currentPage-1)*perPage+1, total);
    const end   = Math.min(currentPage*perPage, total);
    elForm.paginationInfo.innerHTML = total===0
        ? 'Tidak ada data'
        : `Menampilkan <strong>${start}–${end}</strong> dari <strong>${total}</strong> data (Hal. <strong>${currentPage}</strong>/${totalPages})`;
}

function renderPaginationControls(totalPages){
    const ctrl = elForm.paginationControls;
    ctrl.innerHTML='';
    if(totalPages<=1){ctrl.style.display='none';return;}
    ctrl.style.display='flex';

    const mk=(label,page,cls='',disabled=false)=>{
        const btn=document.createElement('button');
        btn.className='pg-btn'+(cls?' '+cls:'');
        btn.innerHTML=label;
        btn.disabled=disabled;
        if(!disabled) btn.addEventListener('click',()=>{currentPage=page;renderTable();});
        return btn;
    };

    ctrl.appendChild(mk('<i class="fas fa-chevron-left"></i>', currentPage-1, '', currentPage===1));
    paginationRange(currentPage, totalPages).forEach(p=>{
        if(p==='…'){const sp=document.createElement('span');sp.className='pg-ellipsis';sp.textContent='…';ctrl.appendChild(sp);}
        else ctrl.appendChild(mk(p, p, p===currentPage?'active':''));
    });
    ctrl.appendChild(mk('<i class="fas fa-chevron-right"></i>', currentPage+1, '', currentPage===totalPages));
}

function paginationRange(current, total){
    if(total<=7) return Array.from({length:total},(_,i)=>i+1);
    if(current<=4) return [1,2,3,4,5,'…',total];
    if(current>=total-3) return [1,'…',total-4,total-3,total-2,total-1,total];
    return [1,'…',current-1,current,current+1,'…',total];
}

function createRow(item, idx=0){
    const tr=document.createElement('tr');
    if(isMusnah){
        tr.innerHTML=`
            <td class="td-no">${idx+1}</td>
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
    } else if(isPersuratan){
        tr.innerHTML=`
            <td class="td-extra">${item.no_berkas_persuratan||(idx+1)}</td>
            <td class="td-extra">${item.unit_kerja||'-'}</td>
            <td class="td-extra">${item.nomor_item_arsip||'-'}</td>
            <td class="td-kode"><code class="kode">${item.kode_klasifikasi_persuratan||'-'}</code></td>
            <td class="td-uraian"><div class="uraian-text">${item.uraian_informasi_persuratan||'-'}</div></td>
            <td class="td-tanggal">${fmtDate(item.tgl)}</td>
            <td class="td-tingkat">${item.tingkat_perkembangan_persuratan||'-'}</td>
            <td class="td-jumlah">${item.jumlah_lembar||'-'}</td>
            <td class="td-extra">${item.no_filling_cabinet||'-'}</td>
            <td class="td-extra">${item.no_laci||'-'}</td>
            <td class="td-extra">${item.no_folder_persuratan||'-'}</td>
            <td class="td-extra">${getKeamananBadge(item.klasifikasi_keamanan)}</td>
            <td class="td-ket">${item.keterangan_persuratan||'-'}</td>
            ${canEdit?`<td class="td-aksi"><div class="row-actions">
                <button class="btn-icon edit" title="Edit"><i class="fas fa-edit"></i></button>
                <button class="btn-icon delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div></td>`:''}`;
    } else {
        tr.innerHTML=`
            <td class="td-no">${idx+1}</td>
            <td class="td-jenis">${item.jenis_arsip||'-'}</td>
            <td class="td-extra">${item.no_box||'-'}</td>
            <td class="td-extra">${item.no_berkas||'-'}</td>
            <td class="td-extra">${item.no_perjanjian_kerjasama||'-'}</td>
            <td class="td-extra">${item.pihak_i||'-'}</td>
            <td class="td-extra">${item.pihak_ii||'-'}</td>
            <td class="td-tingkat">${item.tingkat_perkembangan||'-'}</td>
            <td class="td-tanggal">${fmtDate(item.tanggal_berlaku)}</td>
            <td class="td-tanggal">${fmtDate(item.tanggal_berakhir)}</td>
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
    let colspan;
    if(isMusnah)          colspan = canEdit ? 15 : 14;
    else if(isPersuratan) colspan = canEdit ? 14 : 13;
    else                  colspan = canEdit ? 17 : 16;
    elForm.tableBody.innerHTML=`<tr><td colspan="${colspan}">
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Data Arsip</h3>
            <p>Tambahkan data arsip atau ubah kriteria filter/pencarian.</p>
        </div>
    </td></tr>`;
    elForm.tableFooter.style.display='none';
}

/* =========================================================
   LOAD DATA & STATS
   ========================================================= */
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
        if(res.data.success){
            allData=[...res.data.data||[]];
            filteredData=[...allData];
            currentPage=1;
            applyFiltersAndSearch();
        } else renderEmpty();
    }catch(e){showNotification('Gagal memuat data','error');renderEmpty();}
    finally{hideLoading();}
}

/* =========================================================
   MODAL OPEN / CLOSE
   ========================================================= */
function openAdd(){
    resetForm();
    document.getElementById('modalTitle').textContent='Tambah Data Arsip';
    document.getElementById('submitText').textContent='Simpan';
    elForm.mainModal.style.display='flex';
}

async function openEdit(id){
    showLoading();
    try{
        const res=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${id}/edit`);
        if(res.data.success){
            const d=res.data.data;
            resetForm();currentId=d.id;
            document.getElementById('modalTitle').textContent='Edit Data Arsip';
            document.getElementById('submitText').textContent='Update';
            document.getElementById('itemId').value=d.id;

            if(isMusnah){
                setField('fKodeKlasifikasi',d.kode_klasifikasi);setField('fUraian',d.uraian_informasi);
                setField('fKurun',d.kurun_waktu);setField('fTingkat',d.tingkat_perkembangan);
                setField('fJumlah',d.jumlah);setField('fNoBox',d.no_box);
                setField('fMediaSimpan',d.media_simpan);setField('fKondisi',d.kondisi_fisik);
                setField('fNomorFolder',d.nomor_folder);setField('fJangka',d.jangka_simpan);
                setField('fNasib',d.nasib_akhir_arsip);setField('fLembar',d.lembar);
                setField('fKet',d.keterangan);
            } else if(isPersuratan){
                setField('fNoBerkasPersuratan',d.no_berkas_persuratan);setField('fUnitKerja',d.unit_kerja);
                setField('fNomorItem',d.nomor_item_arsip);setField('fKodeKlasifikasiPersuratan',d.kode_klasifikasi_persuratan);
                setField('fUraianPersuratan',d.uraian_informasi_persuratan);
                setField('fTgl',d.tgl?d.tgl.substring(0,10):'');
                setField('fTingkatPersuratan',d.tingkat_perkembangan_persuratan);setField('fJumlahLembar',d.jumlah_lembar);
                setField('fNoFillingCabinet',d.no_filling_cabinet);setField('fNoLaci',d.no_laci);
                setField('fNoFolderPersuratan',d.no_folder_persuratan);setField('fKlasifikasiKeamanan',d.klasifikasi_keamanan);
                setField('fKetPersuratan',d.keterangan_persuratan);
            } else {
                setField('fJenisArsip',d.jenis_arsip);setField('fNoBox',d.no_box);
                setField('fNoBerkas',d.no_berkas);setField('fNoPerjanjian',d.no_perjanjian_kerjasama);
                setField('fPihakI',d.pihak_i);setField('fPihakII',d.pihak_ii);
                setField('fTingkat',d.tingkat_perkembangan);
                setField('fTanggalBerlaku',d.tanggal_berlaku?d.tanggal_berlaku.substring(0,10):'');
                setField('fTanggalBerakhir',d.tanggal_berakhir?d.tanggal_berakhir.substring(0,10):'');
                setField('fMedia',d.media);setField('fJumlah',d.jumlah);setField('fJangka',d.jangka_simpan);
                setField('fLokasi',d.lokasi_simpan);setField('fMetode',d.metode_perlindungan);
                setField('fKet',d.keterangan);
            }
            elForm.mainModal.style.display='flex';
        }
    }catch(e){showNotification('Gagal memuat data','error');}
    finally{hideLoading();}
}

function closeModal(){elForm.mainModal.style.display='none';resetForm();}

/* =========================================================
   FORM SUBMIT
   ========================================================= */
elForm.mainForm?.addEventListener('submit',async e=>{
    e.preventDefault();clearErrors();
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

/* =========================================================
   DELETE
   ========================================================= */
async function deleteItem(id){
    if(!confirm('Yakin ingin menghapus data arsip ini?'))return;
    showLoading();
    try{
        const res=await axios.delete(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/input/${id}`,{headers:{'X-CSRF-TOKEN':csrfToken}});
        if(res.data.success){showNotification(res.data.message,'success');await loadStats();await loadData();}
    }catch(e){showNotification('Gagal menghapus data','error');}
    finally{hideLoading();}
}

/* =========================================================
   EVENT LISTENERS
   ========================================================= */
document.getElementById('filterToggle').addEventListener('click',()=>{
    document.getElementById('filterPanel').classList.toggle('open');
});
document.getElementById('applyFilterBtn').addEventListener('click',()=>{
    activeFilters=getFilterValues();
    applyFiltersAndSearch();
    if(window.innerWidth<768) document.getElementById('filterPanel').classList.remove('open');
});
document.getElementById('resetFilterBtn').addEventListener('click',()=>{
    document.querySelectorAll('.filter-input').forEach(el=>el.value='');
    activeFilters={};
    elForm.searchInput.value='';
    applyFiltersAndSearch();
});
let searchTimeout;
elForm.searchInput?.addEventListener('input',()=>{
    clearTimeout(searchTimeout);
    searchTimeout=setTimeout(applyFiltersAndSearch,250);
});
document.querySelectorAll('.filter-input').forEach(el=>{
    el.addEventListener('keydown',e=>{
        if(e.key==='Enter'){activeFilters=getFilterValues();applyFiltersAndSearch();}
    });
});
elForm.perPageSelect?.addEventListener('change',e=>{
    perPage=parseInt(e.target.value);currentPage=1;renderTable();
});
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

/* =========================================================
   IMPORT EXCEL
   ========================================================= */
let importFile = null;
const importModal    = document.getElementById('importModal');
const doImportBtn    = document.getElementById('doImportBtn');
const filePreview    = document.getElementById('filePreview');
const importProgress = document.getElementById('importProgress');

document.getElementById('importBtn')?.addEventListener('click',()=>{
    clearImportFile();importModal.style.display='flex';
});
document.getElementById('closeImportBtn')?.addEventListener('click',closeImportModal);
document.getElementById('cancelImportBtn')?.addEventListener('click',closeImportModal);
importModal?.addEventListener('click',e=>{if(e.target===importModal)closeImportModal();});

function closeImportModal(){importModal.style.display='none';clearImportFile();}
function handleFileSelect(input){if(input.files&&input.files[0])setImportFile(input.files[0]);}
function handleDrop(e){
    e.preventDefault();
    document.getElementById('dropZone').style.borderColor='rgba(107,70,193,.3)';
    document.getElementById('dropZone').style.background='rgba(255,255,255,.6)';
    const file=e.dataTransfer.files[0];
    if(file&&(file.name.endsWith('.xlsx')||file.name.endsWith('.xls'))){setImportFile(file);}
    else showNotification('Hanya file .xlsx atau .xls yang diterima','error');
}
function setImportFile(file){
    importFile=file;
    document.getElementById('fileName').textContent=file.name;
    document.getElementById('fileSize').textContent=(file.size/1024).toFixed(1)+' KB';
    filePreview.style.display='flex';
    document.getElementById('dropText').textContent='File terpilih — klik untuk ganti';
    doImportBtn.disabled=false;doImportBtn.style.opacity='1';doImportBtn.style.cursor='pointer';
}
function clearImportFile(){
    importFile=null;
    document.getElementById('importFile').value='';
    filePreview.style.display='none';
    document.getElementById('dropText').textContent='Klik atau drag & drop file Excel di sini';
    doImportBtn.disabled=true;doImportBtn.style.opacity='0.5';doImportBtn.style.cursor='not-allowed';
    importProgress.style.display='none';
    document.getElementById('progressBar').style.width='0%';
}

doImportBtn?.addEventListener('click',async()=>{
    if(!importFile)return;
    importProgress.style.display='block';
    doImportBtn.disabled=true;doImportBtn.style.opacity='0.5';

    let pct=0;
    const progressBar=document.getElementById('progressBar');
    const progressText=document.getElementById('progressText');
    const ticker=setInterval(()=>{
        if(pct<85){pct+=Math.random()*12;progressBar.style.width=Math.min(pct,85)+'%';}
    },300);

    try{
        const fd=new FormData();
        fd.append('file',importFile);
        fd.append('_token',csrfToken);
        const res=await axios.post(
            `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/import`,
            fd,{headers:{'Content-Type':'multipart/form-data'}}
        );
        clearInterval(ticker);
        progressBar.style.width='100%';
        progressText.textContent='Selesai!';

        if(res.data.success){
            const skippedCount=res.data.skipped_count||0;
            const skippedItems=res.data.skipped_items||[];
            setTimeout(async()=>{
                closeImportModal();
                await loadStats();
                await loadData();
                showNotification(res.data.message, skippedCount>0?'warning':'success');
                if(skippedCount>0) showSkippedPanel(skippedItems);
            },800);
        } else {
            showNotification(res.data.message||'Import gagal','error');
            doImportBtn.disabled=false;doImportBtn.style.opacity='1';
        }
    }catch(e){
        clearInterval(ticker);
        showNotification(e.response?.data?.message||'Terjadi kesalahan saat import','error');
        progressText.textContent='Gagal.';
        doImportBtn.disabled=false;doImportBtn.style.opacity='1';
    }
});

/* =========================================================
   PANEL DUPLIKAT
   ========================================================= */
function showSkippedPanel(items){
    const old=document.getElementById('skippedPanel');
    if(old) old.remove();
    const panel=document.createElement('div');
    panel.id='skippedPanel';
    panel.style.cssText=`
        position:fixed;bottom:90px;right:32px;z-index:3000;
        background:#FFFBEB;border:1.5px solid #D97706;border-radius:16px;
        box-shadow:0 8px 32px rgba(217,119,6,.25);
        max-width:440px;width:calc(100vw - 64px);
        animation:slideInRight .4s cubic-bezier(.22,1,.36,1) both;
        overflow:hidden;`;
    const listHtml=items.slice(0,10).map(item=>`
        <li style="padding:5px 0;border-bottom:1px solid rgba(217,119,6,.12);font-size:12px;color:#92400E;line-height:1.4;">
            <i class="fas fa-minus-circle" style="color:#D97706;margin-right:6px;font-size:10px;"></i>${item}
        </li>`).join('');
    const moreText=items.length>10
        ?`<p style="font-size:11px;color:#B45309;margin-top:8px;font-style:italic;">... dan ${items.length-10} data lainnya tidak diimport.</p>`:'';
    panel.innerHTML=`
        <div style="background:linear-gradient(135deg,#D97706,#F59E0B);padding:12px 16px;display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <i class="fas fa-exclamation-triangle" style="color:#fff;font-size:14px;"></i>
                <span style="color:#fff;font-weight:700;font-size:13px;">${items.length} Data Dilewati (Duplikat)</span>
            </div>
            <button onclick="document.getElementById('skippedPanel').remove()"
                style="background:rgba(255,255,255,.25);border:none;color:#fff;width:24px;height:24px;border-radius:6px;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div style="padding:14px 16px;">
            <p style="font-size:12px;color:#92400E;margin-bottom:10px;line-height:1.5;">
                Baris berikut <strong>tidak diimport</strong> karena uraian informasinya sudah ada di database:
            </p>
            <ul style="list-style:none;padding:0;margin:0;max-height:200px;overflow-y:auto;">${listHtml}</ul>
            ${moreText}
        </div>`;
    document.body.appendChild(panel);
    setTimeout(()=>{if(panel.parentNode)panel.remove();},15000);
}
</script>
@endsection