@extends('admin.partials.layout')

@section('title', 'Tahun - ' . $kategoriDetail->name)
@section('page-title', $kategoriDetail->name)
@section('page-subtitle', 'Manajemen Tahun • ' . $kategoriDetail->desc)

@section('styles')
    <style>
        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--gray);
            flex-wrap: wrap;
        }

        .breadcrumb a {
            color: var(--primary-light);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        .breadcrumb-separator {
            color: rgba(255, 255, 255, 0.2);
        }

        .breadcrumb-current {
            color: white;
            font-weight: 500;
        }

        /* Detail Header */
        .detail-header {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .detail-header-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-lg);
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-light);
            font-size: 28px;
        }

        .detail-header-info h1 {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
        }

        .detail-header-info p {
            font-size: 14px;
            color: var(--gray);
            margin: 0;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            padding: 22px;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            border-color: rgba(67, 97, 238, 0.2);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-light);
            font-size: 16px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
            line-height: 1;
        }

        .stat-label {
            font-size: 13px;
            color: var(--gray);
            font-weight: 400;
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: white;
            position: relative;
            padding-left: 12px;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 16px;
            background: linear-gradient(to bottom, var(--primary), var(--primary-light));
            border-radius: var(--radius-full);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        /* Tahun Grid */
        .tahun-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 60px;
        }

        .tahun-card {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            padding: 0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .tahun-card:hover {
            border-color: rgba(67, 97, 238, 0.3);
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .tahun-card-header {
            padding: 20px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tahun-year {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .year-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-light);
            font-size: 16px;
        }

        .year-info h3 {
            font-size: 18px;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .year-badge {
            font-size: 11px;
            padding: 4px 10px;
            background: rgba(76, 201, 240, 0.1);
            color: var(--success);
            border-radius: var(--radius-full);
            font-weight: 500;
        }

        .tahun-actions {
            display: flex;
            gap: 6px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .tahun-card:hover .tahun-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: scale(1.1);
        }

        .btn-icon.edit:hover {
            color: var(--success);
            border-color: rgba(76, 201, 240, 0.2);
            background: rgba(76, 201, 240, 0.08);
        }

        .btn-icon.delete:hover {
            color: var(--danger);
            border-color: rgba(247, 37, 133, 0.2);
            background: rgba(247, 37, 133, 0.08);
        }

        .tahun-card-body {
            padding: 22px;
        }

        .tahun-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 18px;
        }

        .tahun-stat-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-item-label {
            font-size: 11px;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-item-value {
            font-size: 16px;
            font-weight: 600;
            color: white;
        }

        .berkas-list {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .berkas-list-title {
            font-size: 12px;
            color: var(--gray);
            margin-bottom: 12px;
            font-weight: 500;
        }

        .berkas-items {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 180px;
            overflow-y: auto;
        }

        .berkas-items::-webkit-scrollbar {
            width: 4px;
        }

        .berkas-items::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .berkas-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: var(--radius-md);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .berkas-item:hover {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(67, 97, 238, 0.2);
        }

        .berkas-item-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            background: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-light);
            font-size: 12px;
            flex-shrink: 0;
        }

        .berkas-item-info {
            flex: 1;
            min-width: 0;
        }

        .berkas-item-name {
            font-size: 12px;
            color: white;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .berkas-item-meta {
            font-size: 10px;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 2px;
        }

        .no-berkas {
            text-align: center;
            padding: 20px;
            color: var(--gray);
            font-size: 12px;
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px 30px;
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-lg);
        }

        .empty-state i {
            font-size: 40px;
            color: var(--primary-light);
            margin-bottom: 16px;
            opacity: 0.7;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--gray);
            max-width: 400px;
            margin: 0 auto 20px;
            line-height: 1.5;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-content {
            background: var(--dark-light);
            border-radius: var(--radius-xl);
            padding: 28px;
            max-width: 450px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: var(--shadow-xl);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: white;
        }

        .btn-close {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--gray);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-close:hover {
            background: rgba(255, 255, 255, 0.06);
            color: white;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: white;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
            color: white;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
            background: rgba(255, 255, 255, 0.04);
            outline: none;
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .invalid-feedback {
            display: none;
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        .year-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .year-option {
            padding: 10px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
            color: var(--gray);
            cursor: pointer;
            text-align: center;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .year-option:hover,
        .year-option.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border-color: var(--primary);
        }

        /* FAB */
        .fab {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 48px;
            height: 48px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
            transition: all 0.2s ease;
            z-index: 100;
        }

        .fab:hover {
            transform: translateY(-3px) rotate(90deg);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .tahun-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .action-buttons {
                width: 100%;
                justify-content: space-between;
            }

            .detail-header {
                flex-direction: column;
                text-align: center;
            }

            .year-selector {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .year-selector {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <span class="breadcrumb-separator">
            <i class="fas fa-chevron-right"></i>
        </span>
        <a href="{{ route('kategori.detail.index', $kategori->id) }}">
            {{ $kategori->name }}
        </a>
        <span class="breadcrumb-separator">
            <i class="fas fa-chevron-right"></i>
        </span>
        <span class="breadcrumb-current">{{ $kategoriDetail->name }}</span>
    </nav>

    <!-- Detail Header -->
    <div class="detail-header">
        <div class="detail-header-icon">
            <i class="{{ $kategoriDetail->icon ?? 'fas fa-folder' }}"></i>
        </div>
        <div class="detail-header-info">
            <h1>{{ $kategoriDetail->name }}</h1>
            <p>{{ $kategoriDetail->desc }}</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-calendar"></i>
                </div>
            </div>
            <div class="stat-value" id="totalTahun">{{ $totalTahun }}</div>
            <div class="stat-label">Total Tahun</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <div class="stat-value" id="totalBerkas">{{ $totalBerkas }}</div>
            <div class="stat-label">Total Berkas</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-database"></i>
                </div>
            </div>
            <div class="stat-value" id="totalSize">{{ number_format($totalSize / (1024 * 1024), 2) }} MB</div>
            <div class="stat-label">Total Penyimpanan</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div class="stat-value" id="latestUpload">-</div>
            <div class="stat-label">Upload Terakhir</div>
        </div>
    </div>

    <!-- Tahun Section -->
    <div class="section-header">
        <h2 class="section-title">Data Per Tahun</h2>
        <div class="action-buttons">
            <button class="btn btn-secondary" id="refreshBtn">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
            <button class="btn btn-primary" id="addTahunBtn">
                <i class="fas fa-plus"></i>
                Tambah Tahun
            </button>
        </div>
    </div>

    <div class="tahun-grid" id="tahunGrid">
        <!-- Tahun cards will be loaded via AJAX -->
    </div>

    <!-- FAB -->
    <button class="fab" id="fabBtn" title="Tambah Tahun">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Modal -->
    <div class="modal-overlay" id="tahunModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Tahun Baru</h3>
                <button class="btn-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="tahunForm">
                @csrf
                <input type="hidden" id="tahunId" name="id">
                <div class="form-group">
                    <label class="form-label" for="tahunName">
                        Tahun
                    </label>
                    <input type="text" class="form-input" id="tahunName" name="name" required
                        placeholder="Contoh: 2024">
                    <div class="invalid-feedback" id="nameError"></div>
                    <div class="year-selector" id="yearSelector">
                        <!-- Year options will be added here -->
                    </div>
                </div>
                <div class="form-footer">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const kategoriId = {{ $kategori->id }};
        const detailId = {{ $kategoriDetail->id }};

        // Global variables
        let currentTahunId = null;

        // DOM Elements
        const elements = {
            tahunGrid: document.getElementById('tahunGrid'),
            addTahunBtn: document.getElementById('addTahunBtn'),
            refreshBtn: document.getElementById('refreshBtn'),
            fabBtn: document.getElementById('fabBtn'),
            tahunModal: document.getElementById('tahunModal'),
            closeModalBtn: document.getElementById('closeModalBtn'),
            cancelBtn: document.getElementById('cancelBtn'),
            tahunForm: document.getElementById('tahunForm'),
            modalTitle: document.getElementById('modalTitle'),
            yearSelector: document.getElementById('yearSelector'),
            tahunName: document.getElementById('tahunName')
        };

        // Utility Functions
        function clearFormErrors() {
            const errorElement = document.getElementById('nameError');
            if (errorElement) {
                errorElement.style.display = 'none';
                errorElement.textContent = '';
            }
        }

        function resetForm() {
            elements.tahunForm.reset();
            document.getElementById('tahunId').value = '';
            clearFormErrors();
        }

        function formatSize(bytes) {
            if (bytes >= 1073741824) {
                return (bytes / 1073741824).toFixed(2) + ' GB';
            } else if (bytes >= 1048576) {
                return (bytes / 1048576).toFixed(2) + ' MB';
            } else if (bytes >= 1024) {
                return (bytes / 1024).toFixed(2) + ' KB';
            } else {
                return bytes + ' bytes';
            }
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
        }

        // Initialize Year Selector
        function initYearSelector() {
            elements.yearSelector.innerHTML = '';
            const currentYear = new Date().getFullYear();
            const years = [];

            for (let i = currentYear; i >= currentYear - 15; i--) {
                years.push(i);
            }

            years.forEach(year => {
                const option = document.createElement('button');
                option.type = 'button';
                option.className = 'year-option';
                option.textContent = year;
                option.addEventListener('click', () => {
                    document.querySelectorAll('.year-option').forEach(opt => {
                        opt.classList.remove('active');
                    });
                    option.classList.add('active');
                    elements.tahunName.value = year;
                });
                elements.yearSelector.appendChild(option);
            });
        }

        // Load Stats
        async function loadStats() {
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/stats`);
                if (response.data.success && response.data.data) {
                    const data = response.data.data;
                    document.getElementById('totalTahun').textContent = data.total_tahun || 0;
                    document.getElementById('totalBerkas').textContent = data.total_berkas || 0;
                    document.getElementById('totalSize').textContent = data.total_size || '0 MB';
                    document.getElementById('latestUpload').textContent = data.latest_upload || '-';
                }
            } catch (error) {
                console.log('Stats API error:', error);
            }
        }

        // Load Tahun Details
        async function loadTahunDetails() {
            showLoading();
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun`);
                if (response.data.success) {
                    renderTahunDetails(response.data.data || []);
                } else {
                    renderEmptyState();
                }
            } catch (error) {
                console.error('Error loading tahun details:', error);
                showNotification('Gagal memuat data tahun', 'error');
                renderEmptyState();
            } finally {
                hideLoading();
            }
        }

        function renderTahunDetails(tahunList) {
            if (!tahunList || tahunList.length === 0) {
                renderEmptyState();
                return;
            }

            elements.tahunGrid.innerHTML = '';
            tahunList.forEach((tahun) => {
                const card = createTahunCard(tahun);
                elements.tahunGrid.appendChild(card);
            });
        }

        function createTahunCard(tahun) {
            const card = document.createElement('div');
            card.className = 'tahun-card';
            const userRole = '{{ $userRole }}';
            const canEdit = userRole === 'admin';

            const editButton = canEdit ? `
            <button class="btn-icon edit" data-id="${tahun.id}" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
            ` : ``;

            const deleteButton = canEdit ? `
            <button class="btn-icon delete" data-id="${tahun.id}" title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
            `: ``;

            const berkasCount = tahun.berkas_count || 0;
            const totalSize = tahun.total_size || 0;
            const berkasPreview = tahun.berkas ? tahun.berkas.slice(0, 5) : [];

            card.innerHTML = `
                <div class="tahun-card-header">
                    <div class="tahun-year">
                        <div class="year-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="year-info">
                            <h3>${tahun.name || 'N/A'}</h3>
                        </div>
                    </div>
                    <div class="tahun-actions">
                        ${editButton}
                        ${deleteButton}
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
                    ${berkasPreview.length > 0 ? `
                        <div class="berkas-list">
                            <div class="berkas-list-title">
                                <i class="fas fa-file-alt"></i>
                                File Terbaru
                            </div>
                            <div class="berkas-items">
                                ${berkasPreview.map(berkas => `
                                    <div class="berkas-item">
                                        <div class="berkas-item-icon">
                                            <i class="fas fa-file"></i>
                                        </div>
                                        <div class="berkas-item-info">
                                            <div class="berkas-item-name">${berkas.name || 'Untitled'}</div>
                                            <div class="berkas-item-meta">
                                                <span>${berkas.date ? formatDate(berkas.date) : '-'}</span>
                                                <span>•</span>
                                                <span>${formatSize(berkas.size || 0)}</span>
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    ` : '<div class="no-berkas">Belum ada berkas</div>'}
                </div>
            `;

            // Event listeners
            const editBtn = card.querySelector('.edit');
            if (editBtn) {
                editBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    openEditModal(tahun.id);
                });
            }

            const deleteBtn = card.querySelector('.delete');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    deleteTahun(tahun.id);
                });
            }

            card.addEventListener('click', (e) => {
                if (!e.target.closest('.tahun-actions')) {
                    // Navigate to berkas page
                    window.location.href = `/kategori/${kategoriId}/detail/${detailId}/tahun/${tahun.id}/berkas`;
                }
            });

            return card;
        }

        function renderEmptyState() {
            elements.tahunGrid.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>Belum Ada Data Tahun</h3>
                    <p>Mulai dengan menambahkan tahun pertama untuk menyimpan berkas.</p>
                </div>
            `;
        }

        // Modal Functions
        function openAddModal() {
            elements.modalTitle.textContent = 'Tambah Tahun Baru';
            resetForm();
            currentTahunId = null;

            // Set current year as default
            const currentYear = new Date().getFullYear();
            elements.tahunName.value = currentYear;

            document.querySelectorAll('.year-option').forEach((opt, index) => {
                opt.classList.remove('active');
                if (opt.textContent == currentYear) {
                    opt.classList.add('active');
                }
            });

            elements.tahunModal.style.display = 'flex';
        }

        async function openEditModal(tahunId) {
            showLoading();
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/edit`);
                if (response.data.success) {
                    const tahun = response.data.data;
                    elements.modalTitle.textContent = 'Edit Tahun';
                    document.getElementById('tahunId').value = tahun.id;
                    elements.tahunName.value = tahun.name;
                    currentTahunId = tahun.id;

                    document.querySelectorAll('.year-option').forEach(opt => {
                        opt.classList.remove('active');
                        if (opt.textContent == tahun.name) {
                            opt.classList.add('active');
                        }
                    });

                    elements.tahunModal.style.display = 'flex';
                }
            } catch (error) {
                console.error('Error loading tahun:', error);
                showNotification('Gagal memuat data tahun', 'error');
            } finally {
                hideLoading();
            }
        }

        function closeModal() {
            elements.tahunModal.style.display = 'none';
            resetForm();
            currentTahunId = null;
        }

        // Form Submission
        async function handleSubmit(e) {
            e.preventDefault();

            const formData = new FormData(elements.tahunForm);
            const data = Object.fromEntries(formData);

            const url = currentTahunId 
                ? `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${currentTahunId}` 
                : `/api/kategori/${kategoriId}/detail/${detailId}/tahun`;
            const method = currentTahunId ? 'put' : 'post';

            showLoading();

            try {
                const response = await axios({
                    method,
                    url,
                    data,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.data.success) {
                    showNotification(response.data.message, 'success');
                    loadStats();
                    loadTahunDetails();
                    closeModal();
                }
            } catch (error) {
                if (error.response?.status === 422) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(key => {
                        const errorElement = document.getElementById(`${key}Error`);
                        if (errorElement) {
                            errorElement.textContent = errors[key][0];
                            errorElement.style.display = 'block';
                        }
                    });
                    showNotification('Periksa kembali form Anda', 'error');
                } else {
                    showNotification(error.response?.data?.message || 'Terjadi kesalahan', 'error');
                }
            } finally {
                hideLoading();
            }
        }

        // Delete Tahun
        async function deleteTahun(tahunId) {
            if (!confirm('Apakah Anda yakin ingin menghapus tahun ini? Semua berkas di dalamnya juga akan terhapus.')) {
                return;
            }

            showLoading();
            try {
                const response = await axios.delete(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.data.success) {
                    showNotification(response.data.message, 'success');
                    loadStats();
                    loadTahunDetails();
                }
            } catch (error) {
                console.error('Error deleting tahun:', error);
                showNotification(error.response?.data?.message || 'Gagal menghapus tahun', 'error');
            } finally {
                hideLoading();
            }
        }

        // Initialize Everything
        function init() {
            initYearSelector();
            loadStats();
            loadTahunDetails();

            // Event Listeners
            elements.addTahunBtn.addEventListener('click', openAddModal);
            elements.fabBtn.addEventListener('click', openAddModal);
            elements.refreshBtn.addEventListener('click', () => {
                showNotification('Memperbarui data...', 'success');
                loadStats();
                loadTahunDetails();
            });

            elements.closeModalBtn.addEventListener('click', closeModal);
            elements.cancelBtn.addEventListener('click', closeModal);

            elements.tahunModal.addEventListener('click', (e) => {
                if (e.target === elements.tahunModal) {
                    closeModal();
                }
            });

            elements.tahunForm.addEventListener('submit', handleSubmit);

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                }
                if (e.ctrlKey && e.key === 'n') {
                    e.preventDefault();
                    openAddModal();
                }
            });
        }

        // Start the application
        document.addEventListener('DOMContentLoaded', init);
    </script>
@endsection