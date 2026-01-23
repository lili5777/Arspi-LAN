@extends('admin.partials.layout')

@section('title', 'Detail Arsip - ' . $kategori->name)
@section('page-title', $kategori->name)
@section('page-subtitle', 'Manajemen Detail Arsip • ' . $kategori->desc)

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

        /* Kategori Header */
        .kategori-header {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .kategori-header-icon {
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

        .kategori-header-info h1 {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
        }

        .kategori-header-info p {
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

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 60px;
        }

        .detail-card {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            padding: 22px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .detail-card:hover {
            border-color: rgba(67, 97, 238, 0.3);
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .detail-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-light);
            font-size: 18px;
            transition: transform 0.2s ease;
        }

        .detail-card:hover .detail-icon {
            transform: scale(1.1);
        }

        .card-actions {
            display: flex;
            gap: 6px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .detail-card:hover .card-actions {
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

        .detail-info h3 {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .detail-info p {
            font-size: 13px;
            color: var(--gray);
            line-height: 1.5;
            margin-bottom: 18px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .detail-id {
            font-size: 11px;
            color: var(--gray);
            font-weight: 500;
            padding: 4px 8px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: var(--radius-full);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .detail-stats {
            font-size: 11px;
            color: var(--success);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
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

        textarea.form-input {
            resize: vertical;
            min-height: 90px;
        }

        .icon-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }

        .icon-option {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .icon-option:hover,
        .icon-option.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border-color: var(--primary);
            transform: translateY(-1px);
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

            .details-grid {
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

            .kategori-header {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
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
        <span class="breadcrumb-current">{{ $kategori->name }}</span>
    </nav>

    <!-- Kategori Header -->
    <div class="kategori-header">
        <div class="kategori-header-icon">
            <i class="{{ $kategori->icon ?? 'fas fa-folder' }}"></i>
        </div>
        <div class="kategori-header-info">
            <h1>{{ $kategori->name }}</h1>
            <p>{{ $kategori->desc }}</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
            <div class="stat-value" id="totalDetails">{{ $totalDetails }}</div>
            <div class="stat-label">Total Detail</div>
        </div>
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
            <div class="stat-value" id="totalSize">0 MB</div>
            <div class="stat-label">Total Penyimpanan</div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="section-header">
        <h2 class="section-title">Detail Arsip</h2>
        <div class="action-buttons">
            <button class="btn btn-secondary" id="refreshBtn">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
            <button class="btn btn-primary" id="addDetailBtn">
                <i class="fas fa-plus"></i>
                Tambah Detail
            </button>
        </div>
    </div>

    <div class="details-grid" id="detailsGrid">
        <!-- Details will be loaded via AJAX -->
    </div>

    <!-- FAB -->
    <button class="fab" id="fabBtn" title="Tambah Detail">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Modal -->
    <div class="modal-overlay" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Detail Baru</h3>
                <button class="btn-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="detailForm">
                @csrf
                <input type="hidden" id="detailId" name="id">
                <div class="form-group">
                    <label class="form-label" for="detailName">
                        Nama Detail
                    </label>
                    <input type="text" class="form-input" id="detailName" name="name" required
                        placeholder="Masukkan nama detail">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="detailDesc">
                        Deskripsi
                    </label>
                    <textarea class="form-input" id="detailDesc" name="desc" rows="3"
                        placeholder="Masukkan deskripsi detail" required></textarea>
                    <div class="invalid-feedback" id="descError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        Icon
                    </label>
                    <input type="hidden" id="detailIcon" name="icon" value="fas fa-folder">
                    <div class="icon-options" id="iconOptions">
                        <!-- Icons will be added here -->
                    </div>
                    <div class="invalid-feedback" id="iconError"></div>
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

        // Icons
        const iconOptions = [
            'fas fa-folder', 'fas fa-folder-open', 'fas fa-file-alt', 'fas fa-file-pdf',
            'fas fa-file-excel', 'fas fa-file-word', 'fas fa-file-image', 'fas fa-file-video',
            'fas fa-archive', 'fas fa-database', 'fas fa-box', 'fas fa-book',
            'fas fa-book-open', 'fas fa-clipboard', 'fas fa-sticky-note', 'fas fa-certificate',
            'fas fa-star', 'fas fa-tag', 'fas fa-tags', 'fas fa-filter'
        ];

        // Global variables
        let currentDetailId = null;

        // DOM Elements
        const elements = {
            detailsGrid: document.getElementById('detailsGrid'),
            addDetailBtn: document.getElementById('addDetailBtn'),
            refreshBtn: document.getElementById('refreshBtn'),
            fabBtn: document.getElementById('fabBtn'),
            detailModal: document.getElementById('detailModal'),
            closeModalBtn: document.getElementById('closeModalBtn'),
            cancelBtn: document.getElementById('cancelBtn'),
            detailForm: document.getElementById('detailForm'),
            modalTitle: document.getElementById('modalTitle'),
            iconOptionsContainer: document.getElementById('iconOptions')
        };

        // Utility Functions
        function clearFormErrors() {
            ['nameError', 'descError', 'iconError'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.style.display = 'none';
                    element.textContent = '';
                }
            });
        }

        function resetForm() {
            elements.detailForm.reset();
            document.getElementById('detailId').value = '';
            clearFormErrors();
        }

        // Initialize Icon Options
        function initIconOptions() {
            elements.iconOptionsContainer.innerHTML = '';
            iconOptions.forEach(icon => {
                const option = document.createElement('button');
                option.type = 'button';
                option.className = 'icon-option';
                option.innerHTML = `<i class="${icon}"></i>`;
                option.addEventListener('click', () => {
                    document.querySelectorAll('.icon-option').forEach(opt => {
                        opt.classList.remove('active');
                    });
                    option.classList.add('active');
                    document.getElementById('detailIcon').value = icon;
                });
                elements.iconOptionsContainer.appendChild(option);
            });

            if (elements.iconOptionsContainer.firstChild) {
                elements.iconOptionsContainer.firstChild.classList.add('active');
                document.getElementById('detailIcon').value = iconOptions[0];
            }
        }

        // Load Stats
        async function loadStats() {
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/stats`);
                if (response.data.success && response.data.data) {
                    const data = response.data.data;
                    document.getElementById('totalDetails').textContent = data.total_details || 0;
                    document.getElementById('totalTahun').textContent = data.total_tahun || 0;
                    document.getElementById('totalBerkas').textContent = data.total_berkas || 0;
                    document.getElementById('totalSize').textContent = data.total_size || '0 MB';
                }
            } catch (error) {
                console.log('Stats API error:', error);
            }
        }

        // Load Details
        async function loadDetails() {
            showLoading();
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail`);
                if (response.data.success) {
                    renderDetails(response.data.data || []);
                } else {
                    renderEmptyState();
                }
            } catch (error) {
                console.error('Error loading details:', error);
                showNotification('Gagal memuat detail', 'error');
                renderEmptyState();
            } finally {
                hideLoading();
            }
        }

        function renderDetails(details) {
            if (!details || details.length === 0) {
                renderEmptyState();
                return;
            }

            elements.detailsGrid.innerHTML = '';
            details.forEach((detail) => {
                const card = createDetailCard(detail);
                elements.detailsGrid.appendChild(card);
            });
        }

        function createDetailCard(detail) {
            const card = document.createElement('div');
            card.className = 'detail-card';

            const totalBerkas = detail.berkas_count ||
                (detail.tahun_kategori_details ?
                    detail.tahun_kategori_details.reduce((sum, tahun) =>
                        sum + (tahun.berkas_count || 0), 0
                    ) : 0);

            card.innerHTML = `
                    <div class="card-header">
                        <div class="detail-icon">
                            <i class="${detail.icon || 'fas fa-folder'}"></i>
                        </div>
                        <div class="card-actions">
                            <button class="btn-icon edit" data-id="${detail.id}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" data-id="${detail.id}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="detail-info">
                        <h3>${detail.name || 'Untitled Detail'}</h3>
                        <p>${detail.desc || 'No description'}</p>
                    </div>
                    <div class="card-footer">
                        <span class="detail-id">ID: ${detail.id || 'N/A'}</span>
                        <span class="detail-stats">
                            <i class="fas fa-file"></i>
                            ${totalBerkas} berkas
                        </span>
                    </div>
                `;

            card.querySelector('.edit').addEventListener('click', (e) => {
                e.stopPropagation();
                openEditModal(detail.id);
            });

            card.querySelector('.delete').addEventListener('click', (e) => {
                e.stopPropagation();
                deleteDetail(detail.id);
            });

            card.addEventListener('click', (e) => {
                if (!e.target.closest('.card-actions')) {
                    // Navigate to tahun kategori detail page
                    window.location.href = `/kategori/${kategoriId}/detail/${detail.id}/tahun`;
                }
            });

            return card;
        }

        function renderEmptyState() {
            elements.detailsGrid.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h3>Belum Ada Detail</h3>
                        <p>Mulai dengan menambahkan detail pertama untuk kategori ini.</p>
                    </div>
                `;
        }

        // Modal Functions
        function openAddModal() {
            elements.modalTitle.textContent = 'Tambah Detail Baru';
            resetForm();
            currentDetailId = null;

            document.querySelectorAll('.icon-option').forEach((opt, index) => {
                opt.classList.remove('active');
                if (index === 0) {
                    opt.classList.add('active');
                    document.getElementById('detailIcon').value = iconOptions[0];
                }
            });

            elements.detailModal.style.display = 'flex';
        }

        async function openEditModal(detailId) {
            showLoading();
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/edit`);
                if (response.data.success) {
                    const detail = response.data.data;
                    elements.modalTitle.textContent = 'Edit Detail';
                    document.getElementById('detailId').value = detail.id;
                    document.getElementById('detailName').value = detail.name;
                    document.getElementById('detailDesc').value = detail.desc;
                    currentDetailId = detail.id;

                    document.querySelectorAll('.icon-option').forEach(opt => {
                        const iconClass = opt.querySelector('i').className;
                        opt.classList.remove('active');
                        if (iconClass === detail.icon) {
                            opt.classList.add('active');
                            document.getElementById('detailIcon').value = detail.icon;
                        }
                    });

                    elements.detailModal.style.display = 'flex';
                }
            } catch (error) {
                console.error('Error loading detail:', error);
                showNotification('Gagal memuat data detail', 'error');
            } finally {
                hideLoading();
            }
        }

        function closeModal() {
            elements.detailModal.style.display = 'none';
            resetForm();
            currentDetailId = null;
        }

        // Form Submission
        async function handleSubmit(e) {
            e.preventDefault();

            const formData = new FormData(elements.detailForm);
            const data = Object.fromEntries(formData);

            const url = currentDetailId
                ? `/api/kategori/${kategoriId}/detail/${currentDetailId}`
                : `/api/kategori/${kategoriId}/detail`;
            const method = currentDetailId ? 'put' : 'post';

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
                    loadDetails();
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

        // Delete Detail
        async function deleteDetail(detailId) {
            if (!confirm('Apakah Anda yakin ingin menghapus detail ini?')) {
                return;
            }

            showLoading();
            try {
                const response = await axios.delete(`/api/kategori/${kategoriId}/detail/${detailId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.data.success) {
                    showNotification(response.data.message, 'success');
                    loadStats();
                    loadDetails();
                }
            } catch (error) {
                console.error('Error deleting detail:', error);
                showNotification(error.response?.data?.message || 'Gagal menghapus detail', 'error');
            } finally {
                hideLoading();
            }
        }

        // Initialize Everything
        function init() {
            initIconOptions();
            loadStats();
            loadDetails();

            // Event Listeners
            elements.addDetailBtn.addEventListener('click', openAddModal);
            elements.fabBtn.addEventListener('click', openAddModal);
            elements.refreshBtn.addEventListener('click', () => {
                showNotification('Memperbarui data...', 'success');
                loadStats();
                loadDetails();
            });

            elements.closeModalBtn.addEventListener('click', closeModal);
            elements.cancelBtn.addEventListener('click', closeModal);

            elements.detailModal.addEventListener('click', (e) => {
                if (e.target === elements.detailModal) {
                    closeModal();
                }
            });

            elements.detailForm.addEventListener('submit', handleSubmit);

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