@extends('admin.partials.layout')

@section('title', 'Tahun - ' . $kategoriDetail->name)
@section('page-title', $kategoriDetail->name)
@section('page-subtitle', 'Manajemen Tahun • ' . $kategoriDetail->desc)

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
    --p4:#6B46C1;--p5:#7C5FD4;--p6:#9B7FE8;--p7:#B794F4;--p8:#DDD5FF;
    --s1:rgba(255,255,255,0.55);--s2:rgba(255,255,255,0.80);--s3:rgba(255,255,255,0.96);
    --b1:rgba(107,70,193,0.10);--b2:rgba(107,70,193,0.20);--b3:rgba(107,70,193,0.36);
    --txt:#2D1F5E;--txt2:#5540A0;--muted:#9080C0;
    --emerald:#059669;--rose:#DC2626;
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

/* ── Detail Header ── */
.detail-header{
    position:relative;z-index:1;
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:24px;margin-bottom:32px;display:flex;align-items:center;gap:20px;
    backdrop-filter:blur(16px);box-shadow:var(--sh-md);overflow:hidden;
}
.detail-header::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);
}
.detail-header-icon{
    width:64px;height:64px;border-radius:var(--r-lg);
    background:linear-gradient(135deg,rgba(107,70,193,.15),rgba(155,127,232,.08));
    border:1px solid var(--b2);display:flex;align-items:center;justify-content:center;
    color:var(--p5);font-size:26px;flex-shrink:0;transition:transform .3s;
}
.detail-header:hover .detail-header-icon{transform:scale(1.05) rotate(-3deg);}
.detail-header-info h1{font-family:var(--ff-d);font-size:22px;font-weight:700;color:var(--txt);margin-bottom:5px;letter-spacing:-.02em;}
.detail-header-info p{font-size:13px;color:var(--muted);margin:0;font-weight:300;}

/* ── Stats ── */
.stats-grid{position:relative;z-index:1;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:36px;}
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
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(107,70,193,.3),transparent);opacity:0;transition:opacity .3s;}
.stat-card:hover{transform:translateY(-4px);border-color:var(--b2);box-shadow:var(--sh-md);}
.stat-card:hover::before{opacity:1;}
.stat-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
.stat-icon{
    width:38px;height:38px;border-radius:var(--r-sm);
    background:linear-gradient(135deg,rgba(107,70,193,.12),rgba(155,127,232,.08));border:1px solid var(--b2);
    display:flex;align-items:center;justify-content:center;font-size:15px;color:var(--p5);
    transition:transform .3s,color .3s;
}
.stat-card:hover .stat-icon{transform:scale(1.12) rotate(-5deg);color:var(--p4);}
.stat-value{font-family:var(--ff-d);font-size:32px;font-weight:700;color:var(--txt);line-height:1;margin-bottom:5px;letter-spacing:-.03em;}
.stat-label{font-size:11px;font-weight:500;color:var(--muted);letter-spacing:.04em;text-transform:uppercase;}

/* ── Section ── */
.section-header{position:relative;z-index:1;display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;}
.section-title{font-family:var(--ff-d);font-size:20px;font-weight:700;color:var(--txt);display:flex;align-items:center;gap:12px;letter-spacing:-.02em;}
.section-title::before{content:'';display:inline-block;width:3px;height:20px;background:linear-gradient(to bottom,var(--p5),var(--p6));border-radius:var(--r-full);}
.action-buttons{display:flex;gap:10px;}

/* ── Buttons ── */
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:var(--r-md);font-family:var(--ff-b);font-size:13px;font-weight:600;cursor:pointer;border:none;transition:all .25s cubic-bezier(.22,1,.36,1);text-decoration:none;position:relative;overflow:hidden;white-space:nowrap;}
.btn-primary{background:linear-gradient(135deg,var(--p4),var(--p5));color:#fff;box-shadow:0 4px 16px rgba(107,70,193,.35),inset 0 1px 0 rgba(255,255,255,.15);}
.btn-primary::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);transition:left .55s;}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(107,70,193,.45);}
.btn-primary:hover::before{left:100%;}
.btn-secondary{background:var(--s2);color:var(--txt2);border:1px solid var(--b2);backdrop-filter:blur(8px);}
.btn-secondary:hover{background:var(--s3);color:var(--txt);border-color:var(--b3);transform:translateY(-1px);}

/* ── Tahun Grid ── */
.tahun-grid{position:relative;z-index:1;display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:20px;margin-bottom:80px;}
.tahun-card{
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:0;position:relative;overflow:hidden;cursor:pointer;
    backdrop-filter:blur(16px);
    transition:all .35s cubic-bezier(.22,1,.36,1);
    animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both;
    animation-delay:calc(var(--i,0)*.07s);
}
.tahun-card::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(107,70,193,.3),transparent);opacity:0;transition:opacity .3s;}
.tahun-card:hover{transform:translateY(-6px);border-color:var(--b2);box-shadow:var(--sh-lg);}
.tahun-card:hover::before{opacity:1;}

.tahun-card-header{
    padding:18px 22px;border-bottom:1px solid var(--b1);
    display:flex;justify-content:space-between;align-items:center;
}
.tahun-year{display:flex;align-items:center;gap:12px;}
.year-icon{
    width:44px;height:44px;border-radius:var(--r-md);
    background:linear-gradient(135deg,rgba(107,70,193,.15),rgba(155,127,232,.08));
    border:1px solid var(--b2);display:flex;align-items:center;justify-content:center;
    color:var(--p5);font-size:16px;transition:all .3s;
}
.tahun-card:hover .year-icon{transform:scale(1.1) rotate(-5deg);color:var(--p4);}
.year-info h3{font-family:var(--ff-d);font-size:20px;font-weight:700;color:var(--txt);margin:0;letter-spacing:-.02em;transition:color .25s;}
.tahun-card:hover .year-info h3{color:var(--p4);}
.year-badge{font-size:11px;padding:4px 10px;border-radius:var(--r-full);font-weight:600;background:rgba(5,150,105,.1);color:var(--emerald);border:1px solid rgba(5,150,105,.2);}

.tahun-actions{display:flex;gap:6px;opacity:0;transform:translateY(-6px) scale(.88);transition:all .25s cubic-bezier(.34,1.56,.64,1);}
.tahun-card:hover .tahun-actions{opacity:1;transform:translateY(0) scale(1);}

.btn-icon{width:32px;height:32px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,.7);border:1px solid var(--b1);color:var(--muted);cursor:pointer;font-size:13px;transition:all .2s cubic-bezier(.34,1.56,.64,1);}
.btn-icon:hover{transform:scale(1.18);}
.btn-icon.edit:hover{color:var(--emerald);border-color:rgba(5,150,105,.25);background:rgba(5,150,105,.08);}
.btn-icon.delete:hover{color:var(--rose);border-color:rgba(220,38,38,.25);background:rgba(220,38,38,.08);}

.tahun-card-body{padding:20px 22px;}
.tahun-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:18px;}
.tahun-stat-item{display:flex;flex-direction:column;gap:4px;}
.stat-item-label{font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:.06em;font-weight:600;}
.stat-item-value{font-family:var(--ff-d);font-size:18px;font-weight:600;color:var(--txt);}

.berkas-list{margin-top:16px;padding-top:16px;border-top:1px solid var(--b1);}
.berkas-list-title{font-size:10px;color:var(--muted);margin-bottom:10px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;}
.berkas-items{display:flex;flex-direction:column;gap:7px;max-height:160px;overflow-y:auto;}
.berkas-items::-webkit-scrollbar{width:3px;}
.berkas-items::-webkit-scrollbar-thumb{background:var(--b2);border-radius:2px;}
.berkas-item{
    display:flex;align-items:center;gap:10px;padding:8px 10px;
    background:rgba(255,255,255,.65);border-radius:var(--r-sm);border:1px solid var(--b1);
    transition:all .2s;
}
.berkas-item:hover{background:rgba(107,70,193,.06);border-color:var(--b2);}
.berkas-item-icon{width:28px;height:28px;border-radius:6px;background:rgba(107,70,193,.1);display:flex;align-items:center;justify-content:center;color:var(--p5);font-size:12px;flex-shrink:0;}
.berkas-item-info{flex:1;min-width:0;}
.berkas-item-name{font-size:12px;color:var(--txt);font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.berkas-item-meta{font-size:10px;color:var(--muted);display:flex;align-items:center;gap:6px;margin-top:2px;}
.no-berkas{text-align:center;padding:16px;color:var(--muted);font-size:12px;font-weight:300;}

/* ── Empty State ── */
.empty-state{grid-column:1/-1;text-align:center;padding:70px 40px;border:1.5px dashed var(--b2);border-radius:var(--r-xl);background:var(--s1);}
.empty-state i{font-size:40px;color:var(--p5);margin-bottom:18px;opacity:.6;display:block;}
.empty-state h3{font-family:var(--ff-d);font-size:20px;font-weight:700;color:var(--txt);margin-bottom:10px;letter-spacing:-.02em;}
.empty-state p{font-size:13px;font-weight:300;color:var(--muted);max-width:360px;margin:0 auto 24px;line-height:1.65;}

/* ── FAB ── */
.fab{position:fixed;bottom:32px;right:32px;width:52px;height:52px;border-radius:var(--r-full);background:linear-gradient(135deg,var(--p4),var(--p5));color:#fff;border:none;font-size:20px;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 28px rgba(107,70,193,.45);transition:all .35s cubic-bezier(.34,1.56,.64,1);z-index:100;}
.fab:hover{transform:translateY(-4px) rotate(90deg) scale(1.08);box-shadow:0 14px 40px rgba(107,70,193,.6);}

/* ── Modal ── */
.modal-overlay{position:fixed;inset:0;background:rgba(45,31,94,.5);backdrop-filter:blur(12px);display:none;align-items:center;justify-content:center;z-index:2000;padding:20px;}
.modal-content{
    background:linear-gradient(160deg,#FDFBFF 0%,#F5F0FF 60%,#FDFBFF 100%);
    border:1px solid var(--b2);border-radius:var(--r-xl);padding:0;
    max-width:460px;width:100%;box-shadow:var(--sh-xl);position:relative;overflow:hidden;
    animation:modalIn .4s cubic-bezier(.22,1,.36,1) both;
}
@keyframes modalIn{from{opacity:0;transform:translateY(24px) scale(.95);}to{opacity:1;transform:translateY(0) scale(1);}}
.modal-content::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--p5),var(--p6),transparent);}
.modal-header{display:flex;justify-content:space-between;align-items:flex-start;padding:26px 28px 0;margin-bottom:22px;position:relative;z-index:1;}
.modal-eyebrow{font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--p5);margin-bottom:5px;}
.modal-header h3{font-family:var(--ff-d);font-size:21px;font-weight:700;color:var(--txt);letter-spacing:-.02em;}
.btn-close{width:32px;height:32px;border-radius:var(--r-sm);background:rgba(107,70,193,.08);border:1px solid var(--b2);color:var(--muted);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;transition:all .22s;flex-shrink:0;}
.btn-close:hover{background:rgba(220,38,38,.1);border-color:rgba(220,38,38,.25);color:var(--rose);transform:rotate(90deg);}
.modal-body{padding:0 28px;position:relative;z-index:1;}
.modal-foot{display:flex;justify-content:flex-end;gap:10px;padding:20px 28px;border-top:1px solid var(--b1);margin-top:22px;position:relative;z-index:1;}

.form-group{margin-bottom:16px;}
.form-label{display:flex;align-items:center;gap:5px;font-size:10px;font-weight:700;color:var(--muted);margin-bottom:7px;letter-spacing:.14em;text-transform:uppercase;}
.req{color:var(--p5);font-size:13px;line-height:1;}
.form-input{width:100%;padding:11px 14px;background:rgba(255,255,255,.9);border:1.5px solid var(--b2);border-radius:var(--r-md);color:var(--txt);font-size:14px;font-family:var(--ff-b);transition:all .25s;outline:none;}
.form-input::placeholder{color:rgba(144,128,192,.5);}
.form-input:focus{border-color:var(--p5);background:#fff;box-shadow:0 0 0 4px rgba(107,70,193,.1);}
.invalid-feedback{display:none;color:var(--rose);font-size:11.5px;font-weight:500;margin-top:5px;}

/* ── Year Selector ── */
.year-selector{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-top:10px;}
.year-option{
    padding:10px 6px;background:rgba(255,255,255,.8);border:1.5px solid var(--b1);
    border-radius:var(--r-sm);color:var(--muted);cursor:pointer;text-align:center;
    font-weight:600;font-size:13px;font-family:var(--ff-b);
    transition:all .2s cubic-bezier(.34,1.56,.64,1);
}
.year-option:hover{background:rgba(107,70,193,.08);border-color:var(--b2);color:var(--p5);transform:scale(1.05);}
.year-option.active{background:linear-gradient(135deg,var(--p4),var(--p5));border-color:var(--p5);color:#fff;box-shadow:0 4px 12px rgba(107,70,193,.3);}

/* ── Responsive ── */
@media(max-width:768px){
    .stats-grid{grid-template-columns:repeat(2,1fr);}
    .tahun-grid{grid-template-columns:1fr;}
    .section-header{flex-direction:column;align-items:flex-start;gap:12px;}
    .action-buttons{width:100%;}
    .detail-header{flex-direction:column;text-align:center;}
    .year-selector{grid-template-columns:repeat(3,1fr);}
}
@media(max-width:480px){
    .stats-grid{grid-template-columns:1fr;}
    .year-selector{grid-template-columns:repeat(2,1fr);}
    .action-buttons{flex-direction:column;}
    .btn{justify-content:center;}
}
</style>
@endsection

@section('content')
<nav class="breadcrumb">
    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <a href="{{ route('kategori.detail.index', $kategori->id) }}">{{ $kategori->name }}</a>
    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
    <span class="breadcrumb-current">{{ $kategoriDetail->name }}</span>
</nav>

<div class="detail-header">
    <div class="detail-header-icon"><i class="{{ $kategoriDetail->icon ?? 'fas fa-folder' }}"></i></div>
    <div class="detail-header-info">
        <h1>{{ $kategoriDetail->name }}</h1>
        <p>{{ $kategoriDetail->desc }}</p>
    </div>
</div>

<div class="stats-grid">
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
        <div class="stat-value" id="totalSize" style="font-size:22px">{{ number_format($totalSize/(1024*1024),2) }} MB</div>
        <div class="stat-label">Total Penyimpanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-header"><div class="stat-icon"><i class="fas fa-clock"></i></div></div>
        <div class="stat-value" id="latestUpload" style="font-size:22px">-</div>
        <div class="stat-label">Upload Terakhir</div>
    </div>
</div>

<div class="section-header">
    <h2 class="section-title">Data Per Tahun</h2>
    <div class="action-buttons">
        <button class="btn btn-secondary" id="refreshBtn"><i class="fas fa-sync-alt"></i> Refresh</button>
        <button class="btn btn-primary" id="addTahunBtn"><i class="fas fa-plus"></i> Tambah Tahun</button>
    </div>
</div>

<div class="tahun-grid" id="tahunGrid"></div>
<button class="fab" id="fabBtn" title="Tambah Tahun (Ctrl+N)"><i class="fas fa-plus"></i></button>

<div class="modal-overlay" id="tahunModal">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <div class="modal-eyebrow">Kelola Tahun</div>
                <h3 id="modalTitle">Tambah Tahun Baru</h3>
            </div>
            <button class="btn-close" id="closeModalBtn"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="tahunForm" novalidate>
                @csrf
                <input type="hidden" id="tahunId" name="id">
                <div class="form-group">
                    <label class="form-label" for="tahunName">Tahun <span class="req">*</span></label>
                    <input type="text" class="form-input" id="tahunName" name="name" required placeholder="Contoh: 2024">
                    <div class="invalid-feedback" id="nameError"></div>
                    <div class="year-selector" id="yearSelector"></div>
                </div>
            </form>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="submitBtn"><i class="fas fa-save"></i> Simpan Tahun</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const kategoriId = {{ $kategori->id }};
const detailId   = {{ $kategoriDetail->id }};
const kategoriType = '{{ $kategori->type }}';
let currentTahunId = null;
const $ = id => document.getElementById(id);
const elements = {
    tahunGrid:$('tahunGrid'), addTahunBtn:$('addTahunBtn'), refreshBtn:$('refreshBtn'),
    fabBtn:$('fabBtn'), tahunModal:$('tahunModal'), closeModalBtn:$('closeModalBtn'),
    cancelBtn:$('cancelBtn'), tahunForm:$('tahunForm'), modalTitle:$('modalTitle'),
    yearSelector:$('yearSelector'), tahunName:$('tahunName'),
};

function clearFormErrors(){const e=$('nameError');if(e){e.style.display='none';e.textContent='';}}
function resetForm(){elements.tahunForm.reset();$('tahunId').value='';clearFormErrors();}

function formatSize(bytes){
    if(bytes>=1073741824)return(bytes/1073741824).toFixed(2)+' GB';
    if(bytes>=1048576)return(bytes/1048576).toFixed(2)+' MB';
    if(bytes>=1024)return(bytes/1024).toFixed(2)+' KB';
    return bytes+' bytes';
}
function formatDate(dateString){
    const date=new Date(dateString);
    const months=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    return`${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
}

function initYearSelector(){
    elements.yearSelector.innerHTML='';
    const currentYear=new Date().getFullYear();
    for(let i=currentYear;i>=currentYear-15;i--){
        const option=document.createElement('button');
        option.type='button';option.className='year-option';option.textContent=i;
        option.addEventListener('click',()=>{
            document.querySelectorAll('.year-option').forEach(opt=>opt.classList.remove('active'));
            option.classList.add('active');elements.tahunName.value=i;
        });
        elements.yearSelector.appendChild(option);
    }
}

async function loadStats(){
    try{
        const response=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/stats`);
        if(response.data.success&&response.data.data){
            const data=response.data.data;
            $('totalTahun').textContent=data.total_tahun||0;
            $('totalBerkas').textContent=data.total_berkas||0;
            $('totalSize').textContent=data.total_size||'0 MB';
            $('latestUpload').textContent=data.latest_upload||'-';
        }
    }catch(error){console.log('Stats API error:',error);}
}

async function loadTahunDetails(){
    showLoading();
    try{
        const response=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun`);
        if(response.data.success){renderTahunDetails(response.data.data||[]);}
        else renderEmptyState();
    }catch(error){
        console.error('Error loading tahun details:',error);
        showNotification('Gagal memuat data tahun','error');
        renderEmptyState();
    }finally{hideLoading();}
}

function renderTahunDetails(tahunList){
    if(!tahunList||tahunList.length===0){renderEmptyState();return;}
    elements.tahunGrid.innerHTML='';
    tahunList.forEach((tahun,i)=>{
        const card=createTahunCard(tahun);
        card.style.setProperty('--i',i);
        elements.tahunGrid.appendChild(card);
    });
}

function createTahunCard(tahun){
    const card=document.createElement('div');
    card.className='tahun-card';
    const userRole='{{ $userRole }}';const canEdit=userRole==='admin';
    const berkasCount=tahun.berkas_count||0;
    const totalSize=tahun.total_size||0;
    const berkasPreview=tahun.berkas?tahun.berkas.slice(0,5):[];
    card.innerHTML=`
        <div class="tahun-card-header">
            <div class="tahun-year">
                <div class="year-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="year-info"><h3>${tahun.name||'N/A'}</h3></div>
            </div>
            <div class="tahun-actions">
                ${canEdit?`
                <button class="btn-icon edit" data-id="${tahun.id}" title="Edit"><i class="fas fa-edit"></i></button>
                <button class="btn-icon delete" data-id="${tahun.id}" title="Hapus"><i class="fas fa-trash"></i></button>`:''}
            </div>
        </div>
        <div class="tahun-card-body">
            <div class="tahun-stats">
                <div class="tahun-stat-item">
                    <span class="stat-item-label">Total Berkas</span>
                    <span class="stat-item-value">${berkasCount} File</span>
                </div>
                <div class="tahun-stat-item">
                    <span class="stat-item-label">Ukuran Total</span>
                    <span class="stat-item-value">${formatSize(totalSize)}</span>
                </div>
            </div>
            ${berkasPreview.length>0?`
            <div class="berkas-list">
                <div class="berkas-list-title"><i class="fas fa-file-alt"></i> File Terbaru</div>
                <div class="berkas-items">
                    ${berkasPreview.map(berkas=>`
                    <div class="berkas-item">
                        <div class="berkas-item-icon"><i class="fas fa-file"></i></div>
                        <div class="berkas-item-info">
                            <div class="berkas-item-name">${berkas.name||'Untitled'}</div>
                            <div class="berkas-item-meta">
                                <span>${berkas.date?formatDate(berkas.date):'-'}</span>
                                <span>•</span><span>${formatSize(berkas.size||0)}</span>
                            </div>
                        </div>
                    </div>`).join('')}
                </div>
            </div>`:'<div class="no-berkas">Belum ada berkas</div>'}
        </div>`;
    const editBtn=card.querySelector('.edit');
    if(editBtn)editBtn.addEventListener('click',e=>{e.stopPropagation();openEditModal(tahun.id);});
    const deleteBtn=card.querySelector('.delete');
    if(deleteBtn)deleteBtn.addEventListener('click',e=>{e.stopPropagation();deleteTahun(tahun.id);});
    card.addEventListener('click',e=>{
        if(!e.target.closest('.tahun-actions')){
            if(kategoriType==='input'){
                window.location.href=`/kategori/${kategoriId}/detail/${detailId}/tahun/${tahun.id}/input`;
            }else{
                window.location.href=`/kategori/${kategoriId}/detail/${detailId}/tahun/${tahun.id}/berkas`;
            }
        }
    });
    return card;
}

function renderEmptyState(){
    elements.tahunGrid.innerHTML=`
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>Belum Ada Data Tahun</h3>
            <p>Mulai dengan menambahkan tahun pertama untuk menyimpan berkas.</p>
            <button class="btn btn-primary" onclick="openAddModal()"><i class="fas fa-plus"></i> Tambah Sekarang</button>
        </div>`;
}

function openAddModal(){
    elements.modalTitle.textContent='Tambah Tahun Baru';
    resetForm();currentTahunId=null;
    const currentYear=new Date().getFullYear();
    elements.tahunName.value=currentYear;
    document.querySelectorAll('.year-option').forEach(opt=>{
        opt.classList.toggle('active',opt.textContent==currentYear);
    });
    elements.tahunModal.style.display='flex';
}

async function openEditModal(tahunId){
    showLoading();
    try{
        const response=await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/edit`);
        if(response.data.success){
            const tahun=response.data.data;
            elements.modalTitle.textContent='Edit Tahun';
            $('tahunId').value=tahun.id;
            elements.tahunName.value=tahun.name;
            currentTahunId=tahun.id;
            document.querySelectorAll('.year-option').forEach(opt=>{
                opt.classList.toggle('active',opt.textContent==tahun.name);
            });
            elements.tahunModal.style.display='flex';
        }
    }catch(error){
        console.error('Error loading tahun:',error);
        showNotification('Gagal memuat data tahun','error');
    }finally{hideLoading();}
}

function closeModal(){elements.tahunModal.style.display='none';resetForm();currentTahunId=null;}

async function handleSubmit(){
    const formData=new FormData(elements.tahunForm);
    const data=Object.fromEntries(formData);
    const url=currentTahunId
        ?`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${currentTahunId}`
        :`/api/kategori/${kategoriId}/detail/${detailId}/tahun`;
    const method=currentTahunId?'put':'post';
    $('submitBtn').disabled=true;
    $('submitBtn').innerHTML='<i class="fas fa-circle-notch fa-spin"></i> Menyimpan…';
    showLoading();
    try{
        const response=await axios({method,url,data,headers:{'X-CSRF-TOKEN':csrfToken,'Content-Type':'application/json'}});
        if(response.data.success){showNotification(response.data.message,'success');loadStats();loadTahunDetails();closeModal();}
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
        $('submitBtn').innerHTML='<i class="fas fa-save"></i> Simpan Tahun';
        hideLoading();
    }
}

async function deleteTahun(tahunId){
    if(!confirm('Hapus tahun ini? Semua berkas di dalamnya juga akan terhapus.'))return;
    showLoading();
    try{
        const response=await axios.delete(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}`,{headers:{'X-CSRF-TOKEN':csrfToken}});
        if(response.data.success){showNotification(response.data.message,'success');loadStats();loadTahunDetails();}
    }catch(error){
        console.error('Error deleting tahun:',error);
        showNotification(error.response?.data?.message||'Gagal menghapus tahun','error');
    }finally{hideLoading();}
}

function init(){
    initYearSelector();loadStats();loadTahunDetails();
    elements.addTahunBtn.addEventListener('click',openAddModal);
    elements.fabBtn.addEventListener('click',openAddModal);
    elements.refreshBtn.addEventListener('click',()=>{
        const icon=elements.refreshBtn.querySelector('i');icon.classList.add('fa-spin');
        showNotification('Memperbarui data...','success');
        Promise.all([loadStats(),loadTahunDetails()]).finally(()=>setTimeout(()=>icon.classList.remove('fa-spin'),700));
    });
    elements.closeModalBtn.addEventListener('click',closeModal);
    elements.cancelBtn.addEventListener('click',closeModal);
    $('submitBtn').addEventListener('click',handleSubmit);
    elements.tahunModal.addEventListener('click',e=>{if(e.target===elements.tahunModal)closeModal();});
    document.addEventListener('keydown',e=>{
        if(e.key==='Escape')closeModal();
        if(e.ctrlKey&&e.key==='n'){e.preventDefault();openAddModal();}
    });
}
document.addEventListener('DOMContentLoaded',init);
</script>
@endsection