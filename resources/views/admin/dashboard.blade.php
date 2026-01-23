@extends('admin.partials.layout')

@section('title', 'Kategori')
@section('page-title', 'Digital Archive')
@section('page-subtitle', 'Manajemen Kategori Arsip • Dashboard Admin')

@section('styles')
    <style>
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
            position: relative;
            overflow: hidden;
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

        .stat-trend {
            font-size: 11px;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: var(--radius-full);
            background: rgba(76, 201, 240, 0.1);
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-trend.negative {
            background: rgba(247, 37, 133, 0.1);
            color: var(--danger);
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

        /* Categories Grid */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 60px;
        }

        .category-card {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            padding: 22px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .category-card:hover {
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

        .category-icon {
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

        .category-card:hover .category-icon {
            transform: scale(1.1);
        }

        .card-actions {
            display: flex;
            gap: 6px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .category-card:hover .card-actions {
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

        .category-info h3 {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .category-info p {
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

        .category-id {
            font-size: 11px;
            color: var(--gray);
            font-weight: 500;
            padding: 4px 8px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: var(--radius-full);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .category-stats {
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
        @media (max-width: 1024px) {
            .categories-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .categories-grid {
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
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
                gap: 8px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Stats -->
    <div class="stats-grid" id="statsContainer">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    +0
                </div>
            </div>
            <div class="stat-value" id="totalKategori">0</div>
            <div class="stat-label">Total Kategori</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    +0
                </div>
            </div>
            <div class="stat-value" id="totalDokumen">0</div>
            <div class="stat-label">Total Dokumen</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    +0
                </div>
            </div>
            <div class="stat-value" id="totalUsers">1</div>
            <div class="stat-label">Pengguna Aktif</div>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-database"></i>
                </div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    +0 MB
                </div>
            </div>
            <div class="stat-value" id="totalSize">0 MB</div>
            <div class="stat-label">Total Penyimpanan</div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="section-header">
        <h2 class="section-title">Kategori Arsip</h2>
        <div class="action-buttons">
            <button class="btn btn-secondary" id="refreshBtn">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
            <button class="btn btn-primary" id="addCategoryBtn">
                <i class="fas fa-plus"></i>
                Tambah Kategori
            </button>
        </div>
    </div>

    <div class="categories-grid" id="categoriesGrid">
        <!-- Categories will be loaded via AJAX -->
    </div>

    <!-- FAB -->
    <button class="fab" id="fabBtn" title="Tambah Kategori">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Modal -->
    <div class="modal-overlay" id="categoryModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Kategori Baru</h3>
                <button class="btn-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="categoryForm">
                @csrf
                <input type="hidden" id="categoryId" name="id">
                <div class="form-group">
                    <label class="form-label" for="categoryName">
                        Nama Kategori
                    </label>
                    <input type="text" class="form-input" id="categoryName" name="name" required
                        placeholder="Masukkan nama kategori">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="categoryDesc">
                        Deskripsi
                    </label>
                    <textarea class="form-input" id="categoryDesc" name="desc" rows="3"
                        placeholder="Masukkan deskripsi kategori" required></textarea>
                    <div class="invalid-feedback" id="descError"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        Icon
                    </label>
                    <input type="hidden" id="categoryIcon" name="icon" value="fas fa-folder">
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



        // Icons
        const iconOptions = [
            'fas fa-folder', 'fas fa-folder-open', 'fas fa-file-alt', 'fas fa-file-pdf',
            'fas fa-file-excel', 'fas fa-file-word', 'fas fa-file-image', 'fas fa-file-video',
            'fas fa-archive', 'fas fa-database', 'fas fa-box', 'fas fa-book',
            'fas fa-book-open', 'fas fa-clipboard', 'fas fa-sticky-note', 'fas fa-certificate',
            'fas fa-star', 'fas fa-tag', 'fas fa-tags', 'fas fa-filter'
        ];

        // Global variables
        let currentCategoryId = null;

        // DOM Elements
        const elements = {
            categoriesGrid: document.getElementById('categoriesGrid'),
            addCategoryBtn: document.getElementById('addCategoryBtn'),
            refreshBtn: document.getElementById('refreshBtn'),
            fabBtn: document.getElementById('fabBtn'),
            categoryModal: document.getElementById('categoryModal'),
            closeModalBtn: document.getElementById('closeModalBtn'),
            cancelBtn: document.getElementById('cancelBtn'),
            categoryForm: document.getElementById('categoryForm'),
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
            elements.categoryForm.reset();
            document.getElementById('categoryId').value = '';
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
                    document.getElementById('categoryIcon').value = icon;
                });
                elements.iconOptionsContainer.appendChild(option);
            });

            if (elements.iconOptionsContainer.firstChild) {
                elements.iconOptionsContainer.firstChild.classList.add('active');
                document.getElementById('categoryIcon').value = iconOptions[0];
            }
        }

        // Load Stats
        async function loadStats() {
            try {
                const response = await axios.get('/api/kategori/stats');
                if (response.data.success && response.data.data) {
                    const data = response.data.data;
                    document.getElementById('totalKategori').textContent = data.total_kategori || 0;
                    document.getElementById('totalDokumen').textContent = data.total_dokumen || 0;
                    document.getElementById('totalUsers').textContent = data.total_users || 1;
                    document.getElementById('totalSize').textContent = data.total_size || '0 MB';
                }
            } catch (error) {
                console.log('Stats API not available, using default values');
            }
        }

        // Load Categories
        async function loadCategories() {
            showLoading();
            try {
                const response = await axios.get('/api/kategori');
                if (response.data.success) {
                    renderCategories(response.data.kategoris || response.data.data || []);
                } else {
                    renderEmptyState();
                }
            } catch (error) {
                console.error('Error loading categories:', error);
                showNotification('Gagal memuat kategori', 'error');
                renderEmptyState();
            } finally {
                hideLoading();
            }
        }

        function renderCategories(categories) {
            if (!categories || categories.length === 0) {
                renderEmptyState();
                return;
            }

            elements.categoriesGrid.innerHTML = '';
            categories.forEach((category, index) => {
                const card = createCategoryCard(category, index);
                elements.categoriesGrid.appendChild(card);
            });
        }

        function createCategoryCard(category, index) {
            const userRole = '{{ $userRole }}';
            const canEdit = userRole === 'admin';
            const card = document.createElement('div');
            card.className = 'category-card';

            const editButton = canEdit ? `
            <button class="btn-icon edit" data-id="${category.id}" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
            ` :``;

            const deleteButton = canEdit ? `
            <button class="btn-icon delete" data-id="${category.id}" title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
            `:``;

            const totalDocs = category.total_documents ||
                (category.documents_count ||
                    (category.kategori_details ?
                        category.kategori_details.reduce((sum, detail) => {
                            return sum + (detail.tahun_kategori_details_count || 0);
                        }, 0) : 0));

            card.innerHTML = `
                <div class="card-header">
                    <div class="category-icon">
                        <i class="${category.icon || 'fas fa-folder'}"></i>
                    </div>
                    <div class="card-actions">
                        ${editButton}
                        ${deleteButton}
                    </div>
                </div>
                <div class="category-info">
                    <h3>${category.name || 'Untitled Category'}</h3>
                    <p>${category.desc || 'No description'}</p>
                </div>
                <div class="card-footer">
                    <span class="category-id">ID: ${category.id || 'N/A'}</span>
                    <span class="category-stats">
                        <i class="fas fa-file"></i>
                        ${totalDocs} dokumen
                    </span>
                </div>
            `;

            const editBtn = card.querySelector('.edit');
            if (editBtn) {
                editBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    openEditModal(category.id);
                });
            }

            const deleteBtn = card.querySelector('.delete');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    deleteCategory(category.id);
                });
            }

            card.addEventListener('click', (e) => {
                if (!e.target.closest('.card-actions')) {
                    window.location.href = `/kategori/${category.id}`;
                }
            });

            return card;
        }

        function renderEmptyState() {
            elements.categoriesGrid.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>Belum Ada Kategori</h3>
                    <p>Mulai dengan menambahkan kategori pertama untuk mengelola arsip digital Anda.</p>
                </div>
            `;
        }

        // Modal Functions
        function openAddModal() {
            elements.modalTitle.textContent = 'Tambah Kategori Baru';
            resetForm();
            currentCategoryId = null;

            document.querySelectorAll('.icon-option').forEach((opt, index) => {
                opt.classList.remove('active');
                if (index === 0) {
                    opt.classList.add('active');
                    document.getElementById('categoryIcon').value = iconOptions[0];
                }
            });

            elements.categoryModal.style.display = 'flex';
        }

        async function openEditModal(categoryId) {
            showLoading();
            try {
                const response = await axios.get(`/api/kategori/${categoryId}/edit`);
                if (response.data.success) {
                    const category = response.data.data || response.data.kategori;
                    elements.modalTitle.textContent = 'Edit Kategori';
                    document.getElementById('categoryId').value = category.id;
                    document.getElementById('categoryName').value = category.name;
                    document.getElementById('categoryDesc').value = category.desc;
                    currentCategoryId = category.id;

                    document.querySelectorAll('.icon-option').forEach(opt => {
                        const iconClass = opt.querySelector('i').className;
                        opt.classList.remove('active');
                        if (iconClass === category.icon) {
                            opt.classList.add('active');
                            document.getElementById('categoryIcon').value = category.icon;
                        }
                    });

                    elements.categoryModal.style.display = 'flex';
                }
            } catch (error) {
                console.error('Error loading category:', error);
                showNotification('Gagal memuat data kategori', 'error');
            } finally {
                hideLoading();
            }
        }

        function closeModal() {
            elements.categoryModal.style.display = 'none';
            resetForm();
            currentCategoryId = null;
        }

        // Form Submission
        async function handleSubmit(e) {
            e.preventDefault();

            const formData = new FormData(elements.categoryForm);
            const data = Object.fromEntries(formData);

            const url = currentCategoryId ? `/api/kategori/${currentCategoryId}` : '/api/kategori';
            const method = currentCategoryId ? 'put' : 'post';

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
                    loadCategories();
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

        // Delete Category
        async function deleteCategory(categoryId) {
            if (!confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                return;
            }

            showLoading();
            try {
                const response = await axios.delete(`/api/kategori/${categoryId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.data.success) {
                    showNotification(response.data.message, 'success');
                    loadStats();
                    loadCategories();
                }
            } catch (error) {
                console.error('Error deleting category:', error);
                showNotification(error.response?.data?.message || 'Gagal menghapus kategori', 'error');
            } finally {
                hideLoading();
            }
        }

        // Initialize Everything
        function init() {
            initIconOptions();
            loadStats();
            loadCategories();

            // Event Listeners
            elements.addCategoryBtn.addEventListener('click', openAddModal);
            elements.fabBtn.addEventListener('click', openAddModal);
            elements.refreshBtn.addEventListener('click', () => {
                showNotification('Memperbarui data...', 'success');
                loadStats();
                loadCategories();
            });

            elements.closeModalBtn.addEventListener('click', closeModal);
            elements.cancelBtn.addEventListener('click', closeModal);

            elements.categoryModal.addEventListener('click', (e) => {
                if (e.target === elements.categoryModal) {
                    closeModal();
                }
            });

            elements.categoryForm.addEventListener('submit', handleSubmit);

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