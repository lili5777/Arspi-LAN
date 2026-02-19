@extends('admin.partials.layout')

@section('title', 'Kategori')
@section('page-title', 'SIMPADI')
@section('page-subtitle', 'Manajemen Kategori Arsip • Dashboard Admin')

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

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}

body{
    font-family:var(--ff-b);
    background:#F3EEFF;
    color:var(--txt);
    min-height:100vh;
    position:relative;
    overflow-x:hidden;
}

/* layered bg — soft light purple */
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

/* ═══════════════════════════════════════════════
   PAGE HERO
═══════════════════════════════════════════════ */
.page-hero{
    position:relative;z-index:1;
    display:flex;align-items:center;justify-content:space-between;
    padding:36px 0 36px;
    border-bottom:1px solid var(--b1);
    margin-bottom:40px;
}
.page-hero::after{
    content:'';position:absolute;bottom:-1px;left:0;
    width:140px;height:1px;
    background:linear-gradient(90deg,var(--p5),transparent);
}
.hero-eyebrow{
    display:flex;align-items:center;gap:9px;
    font-size:10px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;
    color:var(--p5);margin-bottom:10px;
}
.eyebrow-dot{
    width:6px;height:6px;border-radius:50%;
    background:var(--p4);box-shadow:0 0 8px rgba(107,70,193,0.5);
    animation:blink 2.2s ease-in-out infinite;
}
@keyframes blink{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.4;transform:scale(.65);}}
.hero-title{
    font-family:var(--ff-d);
    font-size:clamp(1.9rem,3vw,2.7rem);font-weight:700;
    color:var(--txt);letter-spacing:-.025em;line-height:1.1;
}
.hero-title em{
    font-style:normal;
    background:linear-gradient(135deg,var(--p7) 0%,#E0AAFF 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.hero-actions{display:flex;gap:10px;align-items:center;flex-shrink:0;}

/* ═══════════════════════════════════════════════
   STATS
═══════════════════════════════════════════════ */
.stats-grid{
    position:relative;z-index:1;
    display:grid;grid-template-columns:repeat(4,1fr);gap:16px;
    margin-bottom:44px;
}
.stat-card{
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:20px 22px;position:relative;overflow:hidden;
    backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
    transition:transform .3s cubic-bezier(.34,1.56,.64,1),border-color .3s,box-shadow .3s;
    animation:fadeUp .6s cubic-bezier(.22,1,.36,1) both;
}
.stat-card:nth-child(1){animation-delay:.04s;}
.stat-card:nth-child(2){animation-delay:.09s;}
.stat-card:nth-child(3){animation-delay:.14s;}
.stat-card:nth-child(4){animation-delay:.19s;}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px);}to{opacity:1;transform:translateY(0);}}
.stat-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:1px;
    background:linear-gradient(90deg,transparent,rgba(200,184,255,.4),transparent);
    opacity:0;transition:opacity .3s;
}
.stat-card:hover{transform:translateY(-5px) scale(1.01);border-color:var(--b2);box-shadow:var(--sh-md);}
.stat-card:hover::before{opacity:1;}
.stat-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;}
.stat-icon{
    width:38px;height:38px;border-radius:var(--r-sm);
    background:var(--s2);border:1px solid var(--b2);
    display:flex;align-items:center;justify-content:center;
    font-size:15px;color:var(--p5);
    transition:transform .3s,color .3s;
}
.stat-card:hover .stat-icon{transform:scale(1.14) rotate(-5deg);color:var(--p4);}
.stat-badge{
    font-size:10px;font-weight:700;padding:3px 9px;border-radius:var(--r-full);
    letter-spacing:.04em;display:flex;align-items:center;gap:4px;
}
.stat-badge.up{background:rgba(5,150,105,.1);color:var(--emerald);border:1px solid rgba(5,150,105,.2);}
.stat-badge.neutral{background:rgba(107,70,193,.08);color:var(--txt2);border:1px solid var(--b1);}
.stat-value{
    font-family:var(--ff-d);font-size:36px;font-weight:700;
    color:var(--txt);line-height:1;margin-bottom:5px;letter-spacing:-.03em;
    transition:color .3s;
}
.stat-card:hover .stat-value{color:var(--p4);}
.stat-label{font-size:11px;font-weight:500;color:var(--muted);letter-spacing:.04em;text-transform:uppercase;}

/* ═══════════════════════════════════════════════
   SECTION CONTROLS
═══════════════════════════════════════════════ */
.section-controls{
    position:relative;z-index:1;
    display:flex;justify-content:space-between;align-items:center;
    margin-bottom:28px;
}
.section-title{
    font-family:var(--ff-d);font-size:22px;font-weight:700;
    color:var(--txt);display:flex;align-items:center;gap:14px;letter-spacing:-.02em;
}
.title-pill{
    font-family:var(--ff-b);font-size:11px;font-weight:600;
    padding:4px 12px;border-radius:var(--r-full);
    background:var(--s2);border:1px solid var(--b2);color:var(--p6);letter-spacing:.04em;
}
.action-buttons{display:flex;gap:10px;}

/* ═══════════════════════════════════════════════
   BUTTONS
═══════════════════════════════════════════════ */
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
.btn-primary::before{
    content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.1),transparent);
    transition:left .55s;
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(91,63,181,.55);}
.btn-primary:hover::before{left:100%;}
.btn-primary:active{transform:translateY(0);}
.btn-secondary{
    background:var(--s2);color:var(--txt2);
    border:1px solid var(--b2);backdrop-filter:blur(8px);
}
.btn-secondary:hover{background:var(--s3);color:var(--txt);border-color:var(--b3);transform:translateY(-1px);}

/* ═══════════════════════════════════════════════
   CATEGORIES GRID
═══════════════════════════════════════════════ */
.categories-grid{
    position:relative;z-index:1;
    display:grid;grid-template-columns:repeat(auto-fill,minmax(310px,1fr));
    gap:20px;margin-bottom:80px;
}

.category-card{
    background:var(--s2);border:1px solid var(--b1);border-radius:var(--r-lg);
    padding:26px;position:relative;overflow:hidden;cursor:pointer;
    backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
    transition:all .35s cubic-bezier(.22,1,.36,1);
    animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both;
    animation-delay:calc(var(--i,0) * .07s);
}
.category-card::before{
    content:'';position:absolute;top:0;left:0;right:0;height:1px;
    background:linear-gradient(90deg,transparent,rgba(200,184,255,.35),transparent);
    opacity:0;transition:opacity .35s;
}
.category-card::after{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse 80% 55% at 50% 0%,rgba(107,70,193,.06),transparent 65%);
    opacity:0;transition:opacity .4s;pointer-events:none;
}
.category-card:hover{transform:translateY(-7px);border-color:var(--b2);box-shadow:var(--sh-lg);}
.category-card:hover::before{opacity:1;}
.category-card:hover::after{opacity:1;}

.card-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;}

.cat-icon-wrap{position:relative;}
.category-icon{
    width:52px;height:52px;border-radius:var(--r-md);
    background:linear-gradient(135deg,rgba(91,63,181,.2),rgba(124,95,212,.1));
    border:1px solid rgba(200,184,255,.15);
    display:flex;align-items:center;justify-content:center;
    font-size:20px;color:var(--p6);
    transition:all .35s cubic-bezier(.34,1.56,.64,1);position:relative;z-index:1;
}
.icon-ring{
    position:absolute;inset:-4px;
    border-radius:calc(var(--r-md) + 4px);
    border:1.5px solid rgba(200,184,255,.25);
    opacity:0;transition:opacity .35s;
    animation:spin-ring 8s linear infinite;
}
@keyframes spin-ring{from{transform:rotate(0);}to{transform:rotate(360deg);}}
.category-card:hover .category-icon{transform:scale(1.1) rotate(-6deg);color:var(--p7);box-shadow:0 0 20px rgba(124,95,212,.3);}
.category-card:hover .icon-ring{opacity:1;}

.card-actions{
    display:flex;gap:6px;
    opacity:0;transform:translateY(-6px) scale(.88);
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
}
.category-card:hover .card-actions{opacity:1;transform:translateY(0) scale(1);}

.btn-icon{
    width:32px;height:32px;border-radius:var(--r-sm);
    display:flex;align-items:center;justify-content:center;
    background:var(--s2);border:1px solid var(--b1);
    color:var(--muted);cursor:pointer;font-size:13px;
    transition:all .2s cubic-bezier(.34,1.56,.64,1);
}
.btn-icon:hover{transform:scale(1.18);}
.btn-icon.edit:hover{color:var(--emerald);border-color:rgba(52,211,153,.3);background:rgba(52,211,153,.1);box-shadow:0 0 12px rgba(52,211,153,.15);}
.btn-icon.delete:hover{color:var(--rose);border-color:rgba(248,113,113,.3);background:rgba(248,113,113,.1);box-shadow:0 0 12px rgba(248,113,113,.15);}

.category-body{margin-bottom:20px;}
.category-name{
    font-family:var(--ff-d);font-size:17px;font-weight:600;
    color:var(--txt);margin-bottom:8px;letter-spacing:-.01em;line-height:1.3;
    transition:color .25s;
}
.category-card:hover .category-name{color:var(--p4);}
.category-desc{
    font-size:13px;font-weight:300;color:var(--muted);line-height:1.65;
    display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;
}
.card-foot{
    display:flex;justify-content:space-between;align-items:center;
    padding-top:16px;border-top:1px solid var(--b1);
}
.card-id{
    font-size:11px;font-weight:500;color:var(--muted);
    font-family:'Courier New',monospace;
    padding:3px 10px;background:rgba(0,0,0,.2);
    border-radius:var(--r-full);border:1px solid var(--b1);letter-spacing:.04em;
}
.card-docs{
    display:flex;align-items:center;gap:6px;
    font-size:12px;font-weight:600;color:#059669;
    padding:4px 12px;background:rgba(52,211,153,.08);
    border-radius:var(--r-full);border:1px solid rgba(52,211,153,.18);
    transition:all .2s;
}
.category-card:hover .card-docs{background:rgba(52,211,153,.14);border-color:rgba(52,211,153,.3);}

/* ═══════════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════════ */
.empty-state{
    grid-column:1/-1;text-align:center;padding:80px 40px;
    border:1.5px dashed var(--b2);border-radius:var(--r-xl);background:var(--s2);
}
.empty-icon{
    width:72px;height:72px;border-radius:var(--r-lg);
    background:var(--s2);border:1px solid var(--b2);
    display:flex;align-items:center;justify-content:center;
    font-size:28px;color:var(--p6);margin:0 auto 24px;
}
.empty-state h3{
    font-family:var(--ff-d);font-size:22px;font-weight:700;
    color:var(--txt);margin-bottom:10px;letter-spacing:-.02em;
}
.empty-state p{
    font-size:14px;font-weight:300;color:var(--muted);
    max-width:360px;margin:0 auto 28px;line-height:1.65;
}

/* ═══════════════════════════════════════════════
   FAB
═══════════════════════════════════════════════ */
.fab{
    position:fixed;bottom:32px;right:32px;
    width:56px;height:56px;border-radius:var(--r-full);
    background:linear-gradient(135deg,var(--p4),var(--p5));
    color:#fff;border:none;font-size:22px;cursor:pointer;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 8px 32px rgba(91,63,181,.55),0 0 0 1px rgba(200,184,255,.2);
    transition:all .35s cubic-bezier(.34,1.56,.64,1);z-index:100;
}
.fab:hover{transform:translateY(-4px) rotate(90deg) scale(1.08);box-shadow:0 16px 48px rgba(91,63,181,.7);}

/* ═══════════════════════════════════════════════
   MODAL
═══════════════════════════════════════════════ */
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
    max-width:480px;width:100%;
    box-shadow:var(--sh-xl),0 0 0 1px rgba(200,184,255,.05);
    position:relative;overflow:hidden;
    animation:modalIn .4s cubic-bezier(.22,1,.36,1) both;
}
@keyframes modalIn{from{opacity:0;transform:translateY(28px) scale(.95);}to{opacity:1;transform:translateY(0) scale(1);}}
.modal-content::before{
    content:'';position:absolute;top:0;left:0;right:0;height:2px;
    background:linear-gradient(90deg,transparent,var(--p5),var(--p7),transparent);
}
.modal-content::after{
    content:'';position:absolute;top:-80px;left:50%;transform:translateX(-50%);
    width:240px;height:160px;
    background:radial-gradient(ellipse,rgba(167,139,250,.15),transparent 70%);
    pointer-events:none;
}
.modal-head{
    display:flex;justify-content:space-between;align-items:flex-start;
    padding:28px 30px 0;position:relative;z-index:1;margin-bottom:22px;
}
.modal-eyebrow{
    font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;
    color:var(--p5);margin-bottom:6px;
}
.modal-head h3{
    font-family:var(--ff-d);font-size:22px;font-weight:700;
    color:var(--txt);letter-spacing:-.02em;
}
.btn-close{
    width:34px;height:34px;border-radius:var(--r-sm);
    background:var(--s2);border:1px solid var(--b2);
    color:var(--muted);display:flex;align-items:center;justify-content:center;
    cursor:pointer;font-size:13px;transition:all .22s;flex-shrink:0;margin-top:2px;
}
.btn-close:hover{background:rgba(248,113,113,.12);border-color:rgba(248,113,113,.25);color:var(--rose);transform:rotate(90deg);}

.modal-body{padding:0 30px;position:relative;z-index:1;}
.modal-foot{
    display:flex;justify-content:flex-end;gap:10px;
    padding:22px 30px;border-top:1px solid var(--b1);
    margin-top:22px;position:relative;z-index:1;
}

.form-group{margin-bottom:18px;}
.form-label{
    display:flex;align-items:center;gap:5px;
    font-size:10px;font-weight:700;color:var(--muted);
    margin-bottom:8px;letter-spacing:.14em;text-transform:uppercase;
}
.req{color:var(--p5);font-size:13px;line-height:1;}
.form-input{
    width:100%;padding:11px 15px;
    background:rgba(255,255,255,0.9);border:1.5px solid var(--b2);
    border-radius:var(--r-md);color:var(--txt);
    font-size:14px;font-family:var(--ff-b);font-weight:400;
    transition:all .25s;outline:none;
}
.form-input::placeholder{color:rgba(144,128,192,.5);}
.form-input:focus{border-color:var(--p5);background:rgba(91,63,181,.08);box-shadow:0 0 0 4px rgba(91,63,181,.12);}
.form-input option{background:#F5F0FF;color:var(--txt);}
textarea.form-input{resize:vertical;min-height:88px;line-height:1.55;}

/* Icon picker */
.icon-picker{display:grid;grid-template-columns:repeat(10,1fr);gap:6px;margin-top:8px;}
.icon-option{
    aspect-ratio:1;border-radius:var(--r-sm);
    background:rgba(255,255,255,0.8);border:1.5px solid var(--b1);
    display:flex;align-items:center;justify-content:center;
    color:var(--muted);cursor:pointer;font-size:14px;
    transition:all .2s cubic-bezier(.34,1.56,.64,1);
}
.icon-option:hover{background:var(--s3);border-color:var(--b2);color:var(--p7);transform:scale(1.18);}
.icon-option.active{
    background:linear-gradient(135deg,var(--p4),var(--p5));
    border-color:var(--p5);color:#fff;
    box-shadow:0 4px 12px rgba(91,63,181,.4);transform:scale(1.08);
}

.invalid-feedback{
    display:none;color:var(--rose);font-size:11.5px;font-weight:500;
    margin-top:5px;padding-left:2px;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════ */
@media(max-width:1100px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:768px){
    .stats-grid{grid-template-columns:repeat(2,1fr);}
    .categories-grid{grid-template-columns:1fr;}
    .section-controls{flex-direction:column;align-items:flex-start;gap:14px;}
    .action-buttons{width:100%;}
    .page-hero{flex-direction:column;align-items:flex-start;gap:20px;}
    .hero-actions{width:100%;}
    .icon-picker{grid-template-columns:repeat(8,1fr);}
}
@media(max-width:520px){
    .stats-grid{grid-template-columns:1fr;}
    .action-buttons{flex-direction:column;}
    .btn{justify-content:center;}
    .modal-head,.modal-body{padding-left:20px;padding-right:20px;}
    .modal-foot{padding-left:20px;padding-right:20px;}
    .icon-picker{grid-template-columns:repeat(6,1fr);}
}
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div>
        <div class="hero-eyebrow"><span class="eyebrow-dot"></span>Manajemen Arsip Digital</div>
        <h1 class="hero-title">Kategori <em>Arsip</em></h1>
    </div>
    <div class="hero-actions">
        <button class="btn btn-secondary" id="refreshBtn">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
        <button class="btn btn-primary" id="addCategoryBtn">
            <i class="fas fa-plus"></i> Tambah Kategori
        </button>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid" id="statsContainer">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"><i class="fas fa-folder-open"></i></div>
            <div class="stat-badge up"><i class="fas fa-arrow-up"></i>+0</div>
        </div>
        <div class="stat-value" id="totalKategori">—</div>
        <div class="stat-label">Total Kategori</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-badge up"><i class="fas fa-arrow-up"></i>+0</div>
        </div>
        <div class="stat-value" id="totalDokumen">—</div>
        <div class="stat-label">Total Dokumen</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-badge neutral">aktif</div>
        </div>
        <div class="stat-value" id="totalUsers">—</div>
        <div class="stat-label">Pengguna Aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"><i class="fas fa-database"></i></div>
            <div class="stat-badge neutral">storage</div>
        </div>
        <div class="stat-value" id="totalSize" style="font-size:26px">—</div>
        <div class="stat-label">Total Penyimpanan</div>
    </div>
</div>

<!-- Section Controls -->
<div class="section-controls">
    <h2 class="section-title">
        Semua Kategori
        <span class="title-pill" id="categoryCount">memuat…</span>
    </h2>
    <div class="action-buttons"></div>
</div>

<!-- Grid -->
<div class="categories-grid" id="categoriesGrid"></div>

<!-- FAB -->
<button class="fab" id="fabBtn" title="Tambah Kategori (Ctrl+N)">
    <i class="fas fa-plus"></i>
</button>

<!-- Modal -->
<div class="modal-overlay" id="categoryModal">
    <div class="modal-content">
        <div class="modal-head">
            <div>
                <div class="modal-eyebrow">Kelola Arsip</div>
                <h3 id="modalTitle">Tambah Kategori</h3>
            </div>
            <button class="btn-close" id="closeModalBtn"><i class="fas fa-times"></i></button>
        </div>

        <div class="modal-body">
            <form id="categoryForm" novalidate>
                @csrf
                <input type="hidden" id="categoryId" name="id">

                <div class="form-group">
                    <label class="form-label" for="categoryName">Nama Kategori <span class="req">*</span></label>
                    <input type="text" class="form-input" id="categoryName" name="name"
                        placeholder="cth. Dokumen Keuangan 2025" required>
                    <div class="invalid-feedback" id="nameError"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="categoryDesc">Deskripsi <span class="req">*</span></label>
                    <textarea class="form-input" id="categoryDesc" name="desc"
                        placeholder="Jelaskan isi dan tujuan kategori ini…" required></textarea>
                    <div class="invalid-feedback" id="descError"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Pilih Ikon</label>
                    <input type="hidden" id="categoryIcon" name="icon" value="fas fa-folder">
                    <div class="icon-picker" id="iconOptions"></div>
                    <div class="invalid-feedback" id="iconError"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="categoryType">Tipe Kategori <span class="req">*</span></label>
                    <select class="form-input" id="categoryType" name="type" required>
                        <option value="upload">Upload Dokumen (Folder → Tahun → Upload)</option>
                        <option value="input">Form Input (Folder → Tahun → Input Tabel)</option>
                        <option value="direct">Langsung Upload (tanpa Folder &amp; Tahun)</option>
                    </select>
                    <div class="invalid-feedback" id="typeError"></div>
                </div>
            </form>
        </div>

        <div class="modal-foot">
            <button type="button" class="btn btn-secondary" id="cancelBtn">Batal</button>
            <button type="button" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save"></i> Simpan Kategori
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
/* ── config ── */
const ICONS = [
    'fas fa-folder','fas fa-folder-open','fas fa-file-alt','fas fa-file-pdf',
    'fas fa-file-excel','fas fa-file-word','fas fa-file-image','fas fa-file-video',
    'fas fa-archive','fas fa-database','fas fa-box','fas fa-book',
    'fas fa-book-open','fas fa-clipboard','fas fa-sticky-note','fas fa-certificate',
    'fas fa-star','fas fa-tag','fas fa-tags','fas fa-filter'
];

let currentCategoryId = null;
const $ = id => document.getElementById(id);

const el = {
    grid:       $('categoriesGrid'),
    addBtn:     $('addCategoryBtn'),
    refreshBtn: $('refreshBtn'),
    fab:        $('fabBtn'),
    modal:      $('categoryModal'),
    closeBtn:   $('closeModalBtn'),
    cancelBtn:  $('cancelBtn'),
    submitBtn:  $('submitBtn'),
    form:       $('categoryForm'),
    modalTitle: $('modalTitle'),
    iconGrid:   $('iconOptions'),
    pill:       $('categoryCount'),
};

/* ── icon picker ── */
function buildIconPicker(selected = ICONS[0]) {
    el.iconGrid.innerHTML = '';
    ICONS.forEach(icon => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'icon-option' + (icon === selected ? ' active' : '');
        btn.innerHTML = `<i class="${icon}"></i>`;
        btn.title = icon.replace('fas fa-','');
        btn.addEventListener('click', () => {
            el.iconGrid.querySelectorAll('.icon-option').forEach(o => o.classList.remove('active'));
            btn.classList.add('active');
            $('categoryIcon').value = icon;
        });
        el.iconGrid.appendChild(btn);
    });
    $('categoryIcon').value = selected;
}

/* ── animated counter ── */
function countUp(domEl, target) {
    const dur = 900;
    const t0  = performance.now();
    const step = now => {
        const p    = Math.min((now - t0) / dur, 1);
        const ease = 1 - Math.pow(1 - p, 3);
        domEl.textContent = Math.round(target * ease);
        if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
}

/* ── stats ── */
async function loadStats() {
    try {
        const res = await axios.get('/api/kategori/stats');
        if (res.data.success && res.data.data) {
            const d = res.data.data;
            countUp($('totalKategori'), d.total_kategori || 0);
            countUp($('totalDokumen'),  d.total_dokumen  || 0);
            countUp($('totalUsers'),    d.total_users    || 1);
            $('totalSize').textContent = d.total_size || '0 MB';
        }
    } catch(e) {
        ['totalKategori','totalDokumen','totalUsers'].forEach(id => $(id).textContent = '0');
        $('totalSize').textContent = '0 MB';
    }
}

/* ── load categories ── */
async function loadCategories() {
    showLoading();
    try {
        const res = await axios.get('/api/kategori');
        if (res.data.success) {
            const cats = res.data.kategoris || res.data.data || [];
            el.pill.textContent = `${cats.length} kategori`;
            renderCategories(cats);
        } else { renderEmptyState(); }
    } catch(e) {
        console.error(e);
        showNotification('Gagal memuat kategori', 'error');
        renderEmptyState();
    } finally { hideLoading(); }
}

function renderCategories(cats) {
    if (!cats || cats.length === 0) { renderEmptyState(); return; }
    el.grid.innerHTML = '';
    cats.forEach((cat, i) => {
        const card = buildCard(cat);
        card.style.setProperty('--i', i);
        el.grid.appendChild(card);
    });
}

function buildCard(cat) {
    const userRole = '{{ $userRole }}';
    const canEdit  = userRole === 'admin';
    const totalDocs = cat.total_documents
        || cat.documents_count
        || (cat.kategori_details
            ? cat.kategori_details.reduce((s,d) => s + (d.tahun_kategori_details_count||0), 0)
            : 0);

    const card = document.createElement('div');
    card.className = 'category-card';
    card.innerHTML = `
        <div class="card-top">
            <div class="cat-icon-wrap">
                <div class="category-icon"><i class="${cat.icon || 'fas fa-folder'}"></i></div>
                <div class="icon-ring"></div>
            </div>
            <div class="card-actions">
                ${canEdit ? `
                <button class="btn-icon edit" title="Edit"><i class="fas fa-pen"></i></button>
                <button class="btn-icon delete" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                ` : ''}
            </div>
        </div>
        <div class="category-body">
            <div class="category-name">${cat.name || 'Untitled'}</div>
            <div class="category-desc">${cat.desc || 'Tidak ada deskripsi.'}</div>
        </div>
        <div class="card-foot">
            
            <span class="card-docs"><i class="fas fa-file-alt"></i>${totalDocs} dokumen</span>
        </div>
    `;

    card.querySelector('.edit')?.addEventListener('click', e => { e.stopPropagation(); openEditModal(cat.id); });
    card.querySelector('.delete')?.addEventListener('click', e => { e.stopPropagation(); deleteCategory(cat.id); });
    card.addEventListener('click', e => { if (!e.target.closest('.card-actions')) window.location.href = `/kategori/${cat.id}`; });

    return card;
}

function renderEmptyState() {
    el.pill.textContent = '0 kategori';
    el.grid.innerHTML = `
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
            <h3>Belum Ada Kategori</h3>
            <p>Mulai dengan menambahkan kategori pertama untuk mengelola arsip digital lembaga Anda.</p>
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus"></i> Tambah Sekarang
            </button>
        </div>
    `;
}

/* ── modal helpers ── */
function clearErrors() {
    ['nameError','descError','iconError','typeError'].forEach(id => {
        const e = $(id); if (e) { e.style.display = 'none'; e.textContent = ''; }
    });
}

function resetForm() { el.form.reset(); $('categoryId').value = ''; clearErrors(); }

function openAddModal() {
    el.modalTitle.textContent = 'Tambah Kategori Baru';
    resetForm(); currentCategoryId = null;
    $('categoryType').value = 'upload';
    buildIconPicker(ICONS[0]);
    el.modal.style.display = 'flex';
    setTimeout(() => $('categoryName').focus(), 350);
}

async function openEditModal(categoryId) {
    showLoading();
    try {
        const res = await axios.get(`/api/kategori/${categoryId}/edit`);
        if (res.data.success) {
            const cat = res.data.data || res.data.kategori;
            el.modalTitle.textContent = 'Edit Kategori';
            $('categoryId').value   = cat.id;
            $('categoryName').value = cat.name;
            $('categoryDesc').value = cat.desc;
            $('categoryType').value = cat.type || 'upload';
            currentCategoryId = cat.id;
            buildIconPicker(cat.icon || ICONS[0]);
            el.modal.style.display = 'flex';
        }
    } catch(e) { showNotification('Gagal memuat data kategori', 'error'); }
    finally { hideLoading(); }
}

function closeModal() {
    el.modal.style.display = 'none';
    resetForm(); currentCategoryId = null;
}

/* ── submit ── */
async function handleSubmit() {
    clearErrors();
    const data   = Object.fromEntries(new FormData(el.form));
    const url    = currentCategoryId ? `/api/kategori/${currentCategoryId}` : '/api/kategori';
    const method = currentCategoryId ? 'put' : 'post';

    el.submitBtn.disabled = true;
    el.submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Menyimpan…';
    showLoading();

    try {
        const res = await axios({ method, url, data,
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
        });
        if (res.data.success) {
            showNotification(res.data.message, 'success');
            loadStats(); loadCategories(); closeModal();
        }
    } catch(err) {
        if (err.response?.status === 422) {
            const errors = err.response.data.errors;
            Object.keys(errors).forEach(k => {
                const e = $(`${k}Error`);
                if (e) { e.textContent = errors[k][0]; e.style.display = 'block'; }
            });
            showNotification('Periksa kembali form Anda', 'error');
        } else {
            showNotification(err.response?.data?.message || 'Terjadi kesalahan', 'error');
        }
    } finally {
        el.submitBtn.disabled = false;
        el.submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Kategori';
        hideLoading();
    }
}

/* ── delete ── */
async function deleteCategory(categoryId) {
    if (!confirm('Hapus kategori ini? Tindakan tidak bisa dibatalkan.')) return;
    showLoading();
    try {
        const res = await axios.delete(`/api/kategori/${categoryId}`,
            { headers: { 'X-CSRF-TOKEN': csrfToken } });
        if (res.data.success) {
            showNotification(res.data.message, 'success');
            loadStats(); loadCategories();
        }
    } catch(e) {
        showNotification(e.response?.data?.message || 'Gagal menghapus kategori', 'error');
    } finally { hideLoading(); }
}

/* ── init ── */
function init() {
    buildIconPicker();
    loadStats();
    loadCategories();

    el.addBtn.addEventListener('click', openAddModal);
    el.fab.addEventListener('click', openAddModal);
    el.refreshBtn.addEventListener('click', () => {
        const icon = el.refreshBtn.querySelector('i');
        icon.classList.add('fa-spin');
        showNotification('Memperbarui data…', 'success');
        Promise.all([loadStats(), loadCategories()])
            .finally(() => setTimeout(() => icon.classList.remove('fa-spin'), 700));
    });
    el.closeBtn.addEventListener('click', closeModal);
    el.cancelBtn.addEventListener('click', closeModal);
    el.submitBtn.addEventListener('click', handleSubmit);
    el.modal.addEventListener('click', e => { if (e.target === el.modal) closeModal(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') { e.preventDefault(); openAddModal(); }
    });
}

document.addEventListener('DOMContentLoaded', init);
</script>
@endsection