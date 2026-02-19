@extends('admin.partials.layout')

@section('title', 'Detail Arsip - ' . $kategori->name)
@section('page-title', $kategori->name)
@section('page-subtitle', 'Manajemen Detail Arsip • ' . $kategori->desc)

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --p4:#6B46C1; --p5:#7C5FD4; --p6:#9B7FE8; --p7:#B794F4; --p8:#DDD5FF;
    --s1:rgba(255,255,255,0.55); --s2:rgba(255,255,255,0.80); --s3:rgba(255,255,255,0.96);
    --b1:rgba(107,70,193,0.10); --b2:rgba(107,70,193,0.20); --b3:rgba(107,70,193,0.36);
    --txt:#2D1F5E; --txt2:#5540A0; --muted:#9080C0;
    --emerald:#059669; --rose:#DC2626;
    --ff-d:'Cormorant Garamond',Georgia,serif;
    --ff-b:'Plus Jakarta Sans',sans-serif;
    --r-sm:8px; --r-md:14px; --r-lg:20px; --r-xl:28px; --r-full:9999px;
    --sh-sm:0 2px 8px rgba(107,70,193,0.08);
    --sh-md:0 4px 20px rgba(107,70,193,0.12);
    --sh-lg:0 8px 36px rgba(107,70,193,0.16);
    --sh-xl:0 20px 56px rgba(107,70,193,0.22);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
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
        linear-gradient(160deg,#EDE8FF 0%,#F8F5FF 50%,#EEE8FF 100%);
}
body::after{
    content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
    background-image:radial-gradient(circle,rgba(107,70,193,0.07) 1px,transparent 1px);
    background-size:36px 36px;
}

/* ── Breadcrumb ── */
.breadcrumb{
    position:relative;z-index:1;
    display:flex;align-items:center;gap:8px;
    margin-bottom:24px;font-size:13px;color:var(--muted);flex-wrap:wrap;
}
.breadcrumb a{color:var(--p5);text-decoration:none;font-weight:500;transition:color .2s;}
.breadcrumb a:hover{color:var(--p4);}
.breadcrumb-separator{color:var(--p8);}
.breadcrumb-current{color:var(--txt);font-weight:600;}

/* ── Kategori Header ── */
.kategori-header{
    position:relative;z-index:1;
    background:var(--s2);
    border:1px solid var(--b1);
    border-radius:var(--r-lg);
    padding:24px;margin-bottom:32px;
    display:flex;align-items:center;gap:20px;
    backdrop-filter:blur(16px);
    box-shadow:var(--sh-md);
    overflow:hidden;
}
.kategori-header::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);
}
.kategori-header-icon{
    width:64px;height:64px;border-radius:var(--r-lg);
    background:linear-gradient(135deg,rgba(107,70,193,0.15),rgba(155,127,232,0.08));
    border:1px solid var(--b2);
    display:flex;align-items:center;justify-content:center;
    color:var(--p5);font-size:26px;flex-shrink:0;
    transition:transform .3s;
}
.kategori-header:hover .kategori-header-icon{transform:scale(1.05) rotate(-3deg);}
.kategori-header-info h1{
    font-family:var(--ff-d);font-size:22px;font-weight:700;
    color:var(--txt);margin-bottom:5px;letter-spacing:-.02em;
}
.kategori-header-info p{font-size:13px;color:var(--muted);margin:0;font-weight:300;}

/* ── Stats Grid ── */
.stats-grid{
    position:relative;z-index:1;
    display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:16px;margin-bottom:36px;
}
.stat-card{
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:20px 22px;backdrop-filter:blur(16px);position:relative;overflow:hidden;
    transition:transform .3s cubic-bezier(.34,1.56,.64,1),border-color .3s,box-shadow .3s;
    animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both;
}
.stat-card:nth-child(1){animation-delay:.04s;}
.stat-card:nth-child(2){animation-delay:.09s;}
.stat-card:nth-child(3){animation-delay:.14s;}
.stat-card:nth-child(4){animation-delay:.19s;}
@keyframes fadeUp{from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);}}
.stat-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:1px;
    background:linear-gradient(90deg,transparent,rgba(107,70,193,.3),transparent);
    opacity:0;transition:opacity .3s;
}
.stat-card:hover{transform:translateY(-4px);border-color:var(--b2);box-shadow:var(--sh-md);}
.stat-card:hover::before{opacity:1;}
.stat-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
.stat-icon{
    width:38px;height:38px;border-radius:var(--r-sm);
    background:linear-gradient(135deg,rgba(107,70,193,.12),rgba(155,127,232,.08));
    border:1px solid var(--b2);display:flex;align-items:center;justify-content:center;
    font-size:15px;color:var(--p5);transition:transform .3s,color .3s;
}
.stat-card:hover .stat-icon{transform:scale(1.12) rotate(-5deg);color:var(--p4);}
.stat-value{
    font-family:var(--ff-d);font-size:32px;font-weight:700;
    color:var(--txt);line-height:1;margin-bottom:5px;letter-spacing:-.03em;
}
.stat-label{font-size:11px;font-weight:500;color:var(--muted);letter-spacing:.04em;text-transform:uppercase;}

/* ── Section Header ── */
.section-header{
    position:relative;z-index:1;
    display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;
}
.section-title{
    font-family:var(--ff-d);font-size:20px;font-weight:700;
    color:var(--txt);display:flex;align-items:center;gap:12px;letter-spacing:-.02em;
}
.section-title::before{
    content:'';display:inline-block;width:3px;height:20px;
    background:linear-gradient(to bottom,var(--p5),var(--p6));
    border-radius:var(--r-full);flex-shrink:0;
}
.action-buttons{display:flex;gap:10px;}

/* ── Buttons ── */
.btn{
    display:inline-flex;align-items:center;gap:8px;
    padding:10px 18px;border-radius:var(--r-md);
    font-family:var(--ff-b);font-size:13px;font-weight:600;
    cursor:pointer;border:none;transition:all .25s cubic-bezier(.22,1,.36,1);
    text-decoration:none;position:relative;overflow:hidden;white-space:nowrap;
}
.btn-primary{
    background:linear-gradient(135deg,var(--p4),var(--p5));color:#fff;
    box-shadow:0 4px 16px rgba(107,70,193,.35),inset 0 1px 0 rgba(255,255,255,.15);
}
.btn-primary::before{
    content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);
    transition:left .55s;
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(107,70,193,.45);}
.btn-primary:hover::before{left:100%;}
.btn-primary:active{transform:translateY(0);}
.btn-secondary{
    background:var(--s2);color:var(--txt2);border:1px solid var(--b2);backdrop-filter:blur(8px);
}
.btn-secondary:hover{background:var(--s3);color:var(--txt);border-color:var(--b3);transform:translateY(-1px);}

/* ── Details Grid ── */
.details-grid{
    position:relative;z-index:1;
    display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
    gap:20px;margin-bottom:80px;
}
.detail-card{
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:24px;position:relative;overflow:hidden;cursor:pointer;
    backdrop-filter:blur(16px);
    transition:all .35s cubic-bezier(.22,1,.36,1);
    animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both;
    animation-delay:calc(var(--i,0)*.07s);
}
.detail-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:1px;
    background:linear-gradient(90deg,transparent,rgba(107,70,193,.3),transparent);
    opacity:0;transition:opacity .3s;
}
.detail-card::after{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse 80% 55% at 50% 0%,rgba(107,70,193,.05),transparent 65%);
    opacity:0;transition:opacity .4s;pointer-events:none;
}
.detail-card:hover{transform:translateY(-6px);border-color:var(--b2);box-shadow:var(--sh-lg);}
.detail-card:hover::before{opacity:1;}
.detail-card:hover::after{opacity:1;}

.card-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;}
.detail-icon{
    width:50px;height:50px;border-radius:var(--r-md);
    background:linear-gradient(135deg,rgba(107,70,193,.15),rgba(155,127,232,.08));
    border:1px solid var(--b2);
    display:flex;align-items:center;justify-content:center;
    font-size:20px;color:var(--p5);
    transition:all .35s cubic-bezier(.34,1.56,.64,1);
}
.detail-card:hover .detail-icon{transform:scale(1.1) rotate(-5deg);color:var(--p4);box-shadow:0 0 16px rgba(107,70,193,.2);}

.card-actions{
    display:flex;gap:6px;
    opacity:0;transform:translateY(-6px) scale(.88);
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
}
.detail-card:hover .card-actions{opacity:1;transform:translateY(0) scale(1);}

.btn-icon{
    width:32px;height:32px;border-radius:var(--r-sm);
    display:flex;align-items:center;justify-content:center;
    background:rgba(255,255,255,.7);border:1px solid var(--b1);
    color:var(--muted);cursor:pointer;font-size:13px;
    transition:all .2s cubic-bezier(.34,1.56,.64,1);
}
.btn-icon:hover{transform:scale(1.18);}
.btn-icon.edit:hover{color:var(--emerald);border-color:rgba(5,150,105,.25);background:rgba(5,150,105,.08);box-shadow:0 0 10px rgba(5,150,105,.12);}
.btn-icon.delete:hover{color:var(--rose);border-color:rgba(220,38,38,.25);background:rgba(220,38,38,.08);box-shadow:0 0 10px rgba(220,38,38,.12);}

.detail-info h3{
    font-family:var(--ff-d);font-size:17px;font-weight:600;
    color:var(--txt);margin-bottom:8px;letter-spacing:-.01em;line-height:1.3;
    transition:color .25s;
}
.detail-card:hover .detail-info h3{color:var(--p4);}
.detail-info p{
    font-size:13px;font-weight:300;color:var(--muted);line-height:1.65;
    margin-bottom:18px;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.card-footer{
    display:flex;justify-content:space-between;align-items:center;
    padding-top:16px;border-top:1px solid var(--b1);
}
.detail-id{
    font-size:11px;font-weight:500;color:var(--muted);
    font-family:'Courier New',monospace;
    padding:3px 10px;background:rgba(107,70,193,.06);
    border-radius:var(--r-full);border:1px solid var(--b1);letter-spacing:.04em;
}
.detail-stats{
    display:flex;align-items:center;gap:5px;
    font-size:12px;font-weight:600;color:var(--emerald);
    padding:4px 12px;background:rgba(5,150,105,.08);
    border-radius:var(--r-full);border:1px solid rgba(5,150,105,.2);
    transition:all .2s;
}
.detail-card:hover .detail-stats{background:rgba(5,150,105,.14);border-color:rgba(5,150,105,.3);}

/* ── Empty State ── */
.empty-state{
    grid-column:1/-1;text-align:center;padding:70px 40px;
    border:1.5px dashed var(--b2);border-radius:var(--r-xl);background:var(--s1);
}
.empty-state i{font-size:40px;color:var(--p5);margin-bottom:18px;opacity:.6;display:block;}
.empty-state h3{
    font-family:var(--ff-d);font-size:20px;font-weight:700;
    color:var(--txt);margin-bottom:10px;letter-spacing:-.02em;
}
.empty-state p{font-size:13px;font-weight:300;color:var(--muted);max-width:360px;margin:0 auto 24px;line-height:1.65;}

/* ── FAB ── */
.fab{
    position:fixed;bottom:32px;right:32px;width:52px;height:52px;
    border-radius:var(--r-full);
    background:linear-gradient(135deg,var(--p4),var(--p5));
    color:#fff;border:none;font-size:20px;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 8px 28px rgba(107,70,193,.45),0 0 0 1px rgba(107,70,193,.2);
    transition:all .35s cubic-bezier(.34,1.56,.64,1);z-index:100;
}
.fab:hover{transform:translateY(-4px) rotate(90deg) scale(1.08);box-shadow:0 14px 40px rgba(107,70,193,.6);}

/* ── Modal ── */
.modal-overlay{
    position:fixed;inset:0;
    background:rgba(45,31,94,.5);backdrop-filter:blur(12px);
    display:none;align-items:center;justify-content:center;z-index:2000;padding:20px;
}
.modal-content{
    background:linear-gradient(160deg,#FDFBFF 0%,#F5F0FF 60%,#FDFBFF 100%);
    border:1px solid var(--b2);border-radius:var(--r-xl);padding:0;
    max-width:460px;width:100%;
    box-shadow:var(--sh-xl),0 0 0 1px rgba(107,70,193,.05);
    position:relative;overflow:hidden;
    animation:modalIn .4s cubic-bezier(.22,1,.36,1) both;
}
@keyframes modalIn{from{opacity:0;transform:translateY(24px) scale(.95);}to{opacity:1;transform:translateY(0) scale(1);}}
.modal-content::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);
}
.modal-header{
    display:flex;justify-content:space-between;align-items:flex-start;
    padding:26px 28px 0;margin-bottom:22px;position:relative;z-index:1;
}
.modal-eyebrow{font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--p5);margin-bottom:5px;}
.modal-header h3{font-family:var(--ff-d);font-size:21px;font-weight:700;color:var(--txt);letter-spacing:-.02em;}
.btn-close{
    width:32px;height:32px;border-radius:var(--r-sm);
    background:rgba(107,70,193,.08);border:1px solid var(--b2);
    color:var(--muted);display:flex;align-items:center;justify-content:center;
    cursor:pointer;font-size:13px;transition:all .22s;flex-shrink:0;margin-top:2px;
}
.btn-close:hover{background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.25);color:var(--rose);transform:rotate(90deg);}

.modal-body{padding:0 28px;position:relative;z-index:1;}
.modal-foot{
    display:flex;justify-content:flex-end;gap:10px;
    padding:20px 28px;border-top:1px solid var(--b1);margin-top:22px;position:relative;z-index:1;
}

.form-group{margin-bottom:16px;}
.form-label{
    display:flex;align-items:center;gap:5px;
    font-size:10px;font-weight:700;color:var(--muted);
    margin-bottom:7px;letter-spacing:.14em;text-transform:uppercase;
}
.req{color:var(--p5);font-size:13px;line-height:1;}
.form-input{
    width:100%;padding:11px 14px;
    background:rgba(255,255,255,.9);border:1.5px solid var(--b2);
    border-radius:var(--r-md);color:var(--txt);
    font-size:14px;font-family:var(--ff-b);font-weight:400;
    transition:all .25s;outline:none;
}
.form-input::placeholder{color:rgba(144,128,192,.5);}
.form-input:focus{border-color:var(--p5);background:#fff;box-shadow:0 0 0 4px rgba(107,70,193,.1);}
textarea.form-input{resize:vertical;min-height:88px;line-height:1.55;}

/* Icon picker */
.icon-options{
    display:grid;grid-template-columns:repeat(10,1fr);gap:6px;margin-top:8px;
}
.icon-option{
    aspect-ratio:1;border-radius:var(--r-sm);
    background:rgba(255,255,255,.8);border:1.5px solid var(--b1);
    display:flex;align-items:center;justify-content:center;
    color:var(--muted);cursor:pointer;font-size:14px;
    transition:all .2s cubic-bezier(.34,1.56,.64,1);
}
.icon-option:hover{background:rgba(107,70,193,.1);border-color:var(--b2);color:var(--p5);transform:scale(1.18);}
.icon-option.active{
    background:linear-gradient(135deg,var(--p4),var(--p5));
    border-color:var(--p5);color:#fff;
    box-shadow:0 4px 12px rgba(107,70,193,.35);transform:scale(1.08);
}
.invalid-feedback{display:none;color:var(--rose);font-size:11.5px;font-weight:500;margin-top:5px;}

/* ── Responsive ── */
@media(max-width:768px){
    .stats-grid{grid-template-columns:repeat(2,1fr);}
    .details-grid{grid-template-columns:1fr;}
    .section-header{flex-direction:column;align-items:flex-start;gap:12px;}
    .action-buttons{width:100%;}
    .kategori-header{flex-direction:column;text-align:center;}
    .icon-options{grid-template-columns:repeat(8,1fr);}
}
@media(max-width:480px){
    .stats-grid{grid-template-columns:1fr;}
    .action-buttons{flex-direction:column;}
    .btn{justify-content:center;}
    .icon-options{grid-template-columns:repeat(6,1fr);}
}
</style>
@endsection

@section('content')
<nav class="breadcrumb">
    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-current">{{ $kategori->name }}</span>
</nav>

<div class="kategori-header">
    <div class="kategori-header-icon">
        <i class="{{ $kategori->icon ?? 'fas fa-folder' }}"></i>
    </div>
    <div class="kategori-header-info">
        <h1>{{ $kategori->name }}</h1>
        <p>{{ $kategori->desc }}</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header"><div class="stat-icon"><i class="fas fa-list"></i></div></div>
        <div class="stat-value" id="totalDetails">{{ $totalDetails }}</div>
        <div class="stat-label">Total Detail</div>
    </div>
    <div class="stat-card">
        <div class="stat-header"><div class="stat-icon"><i class="fas fa-calendar"></i></div></div>
        <div class="stat-value" id="totalTahun">{{ $totalTahun }}</div>
        <div class="stat-label">Total Tahun</div>
    </div>
    <div class="stat-card">
        <div class="stat-header"><div class="stat-icon"><i class="fas fa-file-alt"></i></div></div>
        <div class="stat-value" id="totalBerkas">{{ $totalBerkas }}</div>
        <div class="stat-label">Total Berkas</div>
    </div>
    <div class="stat-card">
        <div class="stat-header"><div class="stat-icon"><i class="fas fa-database"></i></div></div>
        <div class="stat-value" id="totalSize" style="font-size:24px">0 MB</div>
        <div class="stat-label">Total Penyimpanan</div>
    </div>
</div>

<div class="section-header">
    <h2 class="section-title">Detail Arsip</h2>
    <div class="action-buttons">
        <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
        <button class="btn btn-primary" id="addDetailBtn"><i class="fas fa-plus"></i> Tambah Detail</button>
    </div>
</div>

<div class="details-grid" id="detailsGrid"></div>

<button class="fab" id="fabBtn" title="Tambah Detail (Ctrl+N)"><i class="fas fa-plus"></i></button>

<div class="modal-overlay" id="detailModal">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <div class="modal-eyebrow">Kelola Detail</div>
                <h3 id="modalTitle">Tambah Detail Baru</h3>
            </div>
            <button class="btn-close" id="closeModalBtn"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="detailForm" novalidate>
                @csrf
                <input type="hidden" id="detailId" name="id">
                <div class="form-group">
                    <label class="form-label" for="detailName">Nama Detail <span class="req">*</span></label>
                    <input type="text" class="form-input" id="detailName" name="name" required placeholder="Masukkan nama detail">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="detailDesc">Deskripsi <span class="req">*</span></label>
                    <textarea class="form-input" id="detailDesc" name="desc" rows="3" placeholder="Masukkan deskripsi detail" required></textarea>
                    <div class="invalid-feedback" id="descError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Pilih Ikon</label>
                    <input type="hidden" id="detailIcon" name="icon" value="fas fa-folder">
                    <div class="icon-options" id="iconOptions"></div>
                    <div class="invalid-feedback" id="iconError"></div>
                </div>
            </form>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="submitBtn"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const kategoriId = {{ $kategori->id }};
const iconOptions = [
    'fas fa-folder','fas fa-folder-open','fas fa-file-alt','fas fa-file-pdf',
    'fas fa-file-excel','fas fa-file-word','fas fa-file-image','fas fa-file-video',
    'fas fa-archive','fas fa-database','fas fa-box','fas fa-book',
    'fas fa-book-open','fas fa-clipboard','fas fa-sticky-note','fas fa-certificate',
    'fas fa-star','fas fa-tag','fas fa-tags','fas fa-filter'
];
let currentDetailId = null;
const $ = id => document.getElementById(id);
const elements = {
    detailsGrid:$('detailsGrid'), addDetailBtn:$('addDetailBtn'), refreshBtn:$('refreshBtn'),
    fabBtn:$('fabBtn'), detailModal:$('detailModal'), closeModalBtn:$('closeModalBtn'),
    cancelBtn:$('cancelBtn'), detailForm:$('detailForm'), modalTitle:$('modalTitle'),
    iconOptionsContainer:$('iconOptions'),
};

function clearFormErrors(){
    ['nameError','descError','iconError'].forEach(id=>{
        const e=$(id);if(e){e.style.display='none';e.textContent='';}
    });
}
function resetForm(){elements.detailForm.reset();$('detailId').value='';clearFormErrors();}

function initIconOptions(){
    elements.iconOptionsContainer.innerHTML='';
    iconOptions.forEach((icon,index)=>{
        const option=document.createElement('button');
        option.type='button';
        option.className='icon-option'+(index===0?' active':'');
        option.innerHTML=`<i class="${icon}"></i>`;
        option.title=icon.replace('fas fa-','');
        option.addEventListener('click',()=>{
            document.querySelectorAll('.icon-option').forEach(o=>o.classList.remove('active'));
            option.classList.add('active');
            $('detailIcon').value=icon;
        });
        elements.iconOptionsContainer.appendChild(option);
    });
    $('detailIcon').value=iconOptions[0];
}

async function loadStats(){
    try{
        const response=await axios.get(`/api/kategori/${kategoriId}/detail/stats`);
        if(response.data.success&&response.data.data){
            const data=response.data.data;
            $('totalDetails').textContent=data.total_details||0;
            $('totalTahun').textContent=data.total_tahun||0;
            $('totalBerkas').textContent=data.total_berkas||0;
            $('totalSize').textContent=data.total_size||'0 MB';
        }
    }catch(error){console.log('Stats API error:',error);}
}

async function loadDetails(){
    showLoading();
    try{
        const response=await axios.get(`/api/kategori/${kategoriId}/detail`);
        if(response.data.success){renderDetails(response.data.data||[]);}
        else renderEmptyState();
    }catch(error){
        console.error('Error loading details:',error);
        showNotification('Gagal memuat detail','error');
        renderEmptyState();
    }finally{hideLoading();}
}

function renderDetails(details){
    if(!details||details.length===0){renderEmptyState();return;}
    elements.detailsGrid.innerHTML='';
    details.forEach((detail,i)=>{
        const card=createDetailCard(detail);
        card.style.setProperty('--i',i);
        elements.detailsGrid.appendChild(card);
    });
}

function createDetailCard(detail){
    const card=document.createElement('div');
    card.className='detail-card';
    const userRole='{{ $userRole }}';
    const canEdit=userRole==='admin';
    const totalBerkas=detail.berkas_count||(detail.tahun_kategori_details?detail.tahun_kategori_details.reduce((sum,tahun)=>sum+(tahun.berkas_count||0),0):0);
    card.innerHTML=`
        <div class="card-header">
            <div class="detail-icon"><i class="${detail.icon||'fas fa-folder'}"></i></div>
            <div class="card-actions">
                ${canEdit?`
                <button class="btn-icon edit" data-id="${detail.id}" title="Edit"><i class="fas fa-edit"></i></button>
                <button class="btn-icon delete" data-id="${detail.id}" title="Hapus"><i class="fas fa-trash"></i></button>`:''}
            </div>
        </div>
        <div class="detail-info">
            <h3>${detail.name||'Untitled Detail'}</h3>
            <p>${detail.desc||'Tidak ada deskripsi.'}</p>
        </div>
        <div class="card-footer">
            <span class="detail-id">#${detail.id||'N/A'}</span>
            <span class="detail-stats"><i class="fas fa-file"></i>${totalBerkas} berkas</span>
        </div>`;
    const editBtn=card.querySelector('.edit');
    if(editBtn)editBtn.addEventListener('click',e=>{e.stopPropagation();openEditModal(detail.id);});
    const deleteBtn=card.querySelector('.delete');
    if(deleteBtn)deleteBtn.addEventListener('click',e=>{e.stopPropagation();deleteDetail(detail.id);});
    card.addEventListener('click',e=>{
        if(!e.target.closest('.card-actions'))window.location.href=`/kategori/${kategoriId}/detail/${detail.id}/tahun`;
    });
    return card;
}

function renderEmptyState(){
    elements.detailsGrid.innerHTML=`
        <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <h3>Belum Ada Detail</h3>
            <p>Mulai dengan menambahkan detail pertama untuk kategori ini.</p>
            <button class="btn btn-primary" onclick="openAddModal()"><i class="fas fa-plus"></i> Tambah Sekarang</button>
        </div>`;
}

function openAddModal(){
    elements.modalTitle.textContent='Tambah Detail Baru';
    resetForm();currentDetailId=null;
    document.querySelectorAll('.icon-option').forEach((opt,index)=>{
        opt.classList.toggle('active',index===0);
    });
    $('detailIcon').value=iconOptions[0];
    elements.detailModal.style.display='flex';
    setTimeout(()=>$('detailName').focus(),300);
}

async function openEditModal(detailId){
    showLoading();
    try{
        const response=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/edit`);
        if(response.data.success){
            const detail=response.data.data;
            elements.modalTitle.textContent='Edit Detail';
            $('detailId').value=detail.id;
            $('detailName').value=detail.name;
            $('detailDesc').value=detail.desc;
            currentDetailId=detail.id;
            document.querySelectorAll('.icon-option').forEach(opt=>{
                const iconClass=opt.querySelector('i').className;
                opt.classList.toggle('active',iconClass===detail.icon);
            });
            $('detailIcon').value=detail.icon||iconOptions[0];
            elements.detailModal.style.display='flex';
        }
    }catch(error){
        console.error('Error loading detail:',error);
        showNotification('Gagal memuat data detail','error');
    }finally{hideLoading();}
}

function closeModal(){elements.detailModal.style.display='none';resetForm();currentDetailId=null;}

async function handleSubmit(){
    const formData=new FormData(elements.detailForm);
    const data=Object.fromEntries(formData);
    const url=currentDetailId?`/api/kategori/${kategoriId}/detail/${currentDetailId}`:`/api/kategori/${kategoriId}/detail`;
    const method=currentDetailId?'put':'post';
    $('submitBtn').disabled=true;
    $('submitBtn').innerHTML='<i class="fas fa-circle-notch fa-spin"></i> Menyimpan…';
    showLoading();
    try{
        const response=await axios({method,url,data,headers:{'X-CSRF-TOKEN':csrfToken,'Content-Type':'application/json'}});
        if(response.data.success){showNotification(response.data.message,'success');loadStats();loadDetails();closeModal();}
    }catch(error){
        if(error.response?.status===422){
            const errors=error.response.data.errors;
            Object.keys(errors).forEach(key=>{
                const errorElement=$(`${key}Error`);
                if(errorElement){errorElement.textContent=errors[key][0];errorElement.style.display='block';}
            });
            showNotification('Periksa kembali form Anda','error');
        }else showNotification(error.response?.data?.message||'Terjadi kesalahan','error');
    }finally{
        $('submitBtn').disabled=false;
        $('submitBtn').innerHTML='<i class="fas fa-save"></i> Simpan';
        hideLoading();
    }
}

async function deleteDetail(detailId){
    if(!confirm('Hapus detail ini? Tindakan tidak bisa dibatalkan.'))return;
    showLoading();
    try{
        const response=await axios.delete(`/api/kategori/${kategoriId}/detail/${detailId}`,{headers:{'X-CSRF-TOKEN':csrfToken}});
        if(response.data.success){showNotification(response.data.message,'success');loadStats();loadDetails();}
    }catch(error){
        console.error('Error deleting detail:',error);
        showNotification(error.response?.data?.message||'Gagal menghapus detail','error');
    }finally{hideLoading();}
}

function init(){
    initIconOptions();loadStats();loadDetails();
    elements.addDetailBtn.addEventListener('click',openAddModal);
    elements.fabBtn.addEventListener('click',openAddModal);
    elements.refreshBtn.addEventListener('click',()=>{
        const icon=elements.refreshBtn.querySelector('i');
        icon.classList.add('fa-spin');
        showNotification('Memperbarui data...','success');
        Promise.all([loadStats(),loadDetails()]).finally(()=>setTimeout(()=>icon.classList.remove('fa-spin'),700));
    });
    elements.closeModalBtn.addEventListener('click',closeModal);
    elements.cancelBtn.addEventListener('click',closeModal);
    $('submitBtn').addEventListener('click',handleSubmit);
    elements.detailModal.addEventListener('click',e=>{if(e.target===elements.detailModal)closeModal();});
    document.addEventListener('keydown',e=>{
        if(e.key==='Escape')closeModal();
        if(e.ctrlKey&&e.key==='n'){e.preventDefault();openAddModal();}
    });
}
document.addEventListener('DOMContentLoaded',init);
</script>
@endsection