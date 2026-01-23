@extends('admin.partials.layout')

@section('title', 'Berkas - ' . $tahunDetail->name)
@section('page-title', 'Berkas ' . $tahunDetail->name)
@section('page-subtitle', 'Manajemen File • ' . $kategoriDetail->name)

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

        /* Header */
        .berkas-header {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            padding: 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
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

        .header-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
        }

        .header-text p {
            font-size: 14px;
            color: var(--gray);
            margin: 0;
        }

        /* Stats */
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

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        /* Search Bar */
        .search-bar {
            position: relative;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-md);
            color: white;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 14px;
        }

        /* Table */
        .table-container {
            background: var(--dark-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: var(--radius-lg);
            overflow: hidden;
            margin-bottom: 60px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .table th {
            padding: 16px 20px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 14px;
            color: white;
        }

        .table tbody tr {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .table tbody tr:hover {
            background: rgba(67, 97, 238, 0.05);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .file-name {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .file-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-light);
            font-size: 14px;
            flex-shrink: 0;
        }

        .file-info {
            flex: 1;
            min-width: 0;
        }

        .file-title {
            font-weight: 500;
            color: white;
            margin-bottom: 2px;
        }

        .file-meta {
            font-size: 12px;
            color: var(--gray);
        }

        .file-size {
            font-size: 13px;
            color: var(--gray);
        }

        .file-date {
            font-size: 13px;
            color: var(--gray);
        }

        .table-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
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

        .btn-icon.download:hover {
            color: var(--primary-light);
            border-color: rgba(67, 97, 238, 0.2);
            background: rgba(67, 97, 238, 0.08);
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 30px;
        }

        .empty-state i {
            font-size: 48px;
            color: var(--primary-light);
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .empty-state h3 {
            font-size: 18px;
            font-weight: 600;
            color: white;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--gray);
            max-width: 400px;
            margin: 0 auto 24px;
            line-height: 1.6;
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
            max-width: 500px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: var(--shadow-xl);
            max-height: 90vh;
            overflow-y: auto;
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

        .file-upload-area {
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-md);
            padding: 30px 20px;
            text-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.02);
        }

        .file-upload-area:hover {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.05);
        }

        .file-upload-area.dragover {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.1);
        }

        .upload-icon {
            font-size: 36px;
            color: var(--primary-light);
            margin-bottom: 12px;
        }

        .upload-text {
            font-size: 14px;
            color: white;
            margin-bottom: 4px;
        }

        .upload-subtext {
            font-size: 12px;
            color: var(--gray);
        }

        .file-input {
            display: none;
        }

        .selected-file {
            margin-top: 12px;
            padding: 10px 14px;
            background: rgba(67, 97, 238, 0.1);
            border: 1px solid rgba(67, 97, 238, 0.2);
            border-radius: var(--radius-md);
            display: none;
            align-items: center;
            gap: 10px;
        }

        .selected-file.active {
            display: flex;
        }

        .selected-file-icon {
            color: var(--primary-light);
        }

        .selected-file-info {
            flex: 1;
        }

        .selected-file-name {
            font-size: 13px;
            color: white;
            font-weight: 500;
        }

        .selected-file-size {
            font-size: 11px;
            color: var(--gray);
        }

        .remove-file {
            color: var(--danger);
            cursor: pointer;
            padding: 4px;
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
            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .action-buttons {
                width: 100%;
            }

            .berkas-header {
                flex-direction: column;
                gap: 16px;
            }

            .header-info {
                flex-direction: column;
                text-align: center;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table th,
            .table td {
                padding: 12px 16px;
                font-size: 13px;
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
        <a href="{{ route('kategori.detail.tahun.index', [$kategori->id, $kategoriDetail->id]) }}">
            {{ $kategoriDetail->name }}
        </a>
        <span class="breadcrumb-separator">
            <i class="fas fa-chevron-right"></i>
        </span>
        <span class="breadcrumb-current">{{ $tahunDetail->name }}</span>
    </nav>

    <!-- Header -->
    <div class="berkas-header">
        <div class="header-info">
            <div class="header-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="header-text">
                <h1>Berkas Tahun {{ $tahunDetail->name }}</h1>
                <p>{{ $kategoriDetail->name }} • {{ $kategori->name }}</p>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
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
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
            <div class="stat-value" id="oldestDate">-</div>
            <div class="stat-label">Tanggal Tertua</div>
        </div>
    </div>

    <!-- Section -->
    <div class="section-header">
        <h2 class="section-title">Daftar Berkas</h2>
        <div class="action-buttons">
            <button class="btn btn-secondary" id="refreshBtn">
                <i class="fas fa-sync-alt"></i>
                Refresh
            </button>
            <button class="btn btn-primary" id="addBerkasBtn">
                <i class="fas fa-cloud-upload-alt"></i>
                Upload Berkas
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
        <i class="fas fa-search search-icon"></i>
        <input type="text" class="search-input" id="searchInput" placeholder="Cari berkas...">
    </div>

    <!-- Table -->
    <div class="table-container">
        <table class="table" id="berkasTable">
            <thead>
                <tr>
                    <th style="width: 50%;">Nama File</th>
                    <th style="width: 15%;">Ukuran</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 20%; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody id="berkasTableBody">
                <!-- Data will be loaded via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- FAB -->
    <button class="fab" id="fabBtn" title="Upload Berkas">
        <i class="fas fa-cloud-upload-alt"></i>
    </button>

    <!-- Modal -->
    <div class="modal-overlay" id="berkasModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Upload Berkas Baru</h3>
                <button class="btn-close" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="berkasForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="berkasId" name="id">
                <input type="hidden" id="isEdit" value="0">

                <div class="form-group">
                    <label class="form-label" for="berkasName">
                        Nama Berkas
                    </label>
                    <input type="text" class="form-input" id="berkasName" name="name" required
                        placeholder="Masukkan nama berkas">
                    <div class="invalid-feedback" id="nameError"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="berkasDate">
                        Tanggal
                    </label>
                    <input type="date" class="form-input" id="berkasDate" name="date" required>
                    <div class="invalid-feedback" id="dateError"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        File <span id="fileOptional" style="display:none;">(Opsional - biarkan kosong jika tidak ingin
                            mengganti)</span>
                    </label>
                    <div class="file-upload-area" id="fileUploadArea">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">
                            Klik atau drag & drop file di sini
                        </div>
                        <div class="upload-subtext">
                            Maksimal ukuran file: 50MB
                        </div>
                    </div>
                    <input type="file" class="file-input" id="berkasFile" name="file" accept="*/*">
                    <div class="selected-file" id="selectedFile">
                        <i class="fas fa-file selected-file-icon"></i>
                        <div class="selected-file-info">
                            <div class="selected-file-name" id="selectedFileName"></div>
                            <div class="selected-file-size" id="selectedFileSize"></div>
                        </div>
                        <i class="fas fa-times remove-file" id="removeFile"></i>
                    </div>
                    <div class="invalid-feedback" id="fileError"></div>
                </div>

                <div class="form-footer">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i>
                        <span id="submitText">Upload</span>
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
        const tahunId = {{ $tahunDetail->id }};

        // Global variables
        let currentBerkasId = null;
        let selectedFile = null;
        let allBerkas = [];

        // DOM Elements
        const elements = {
            berkasTableBody: document.getElementById('berkasTableBody'),
            searchInput: document.getElementById('searchInput'),
            addBerkasBtn: document.getElementById('addBerkasBtn'),
            refreshBtn: document.getElementById('refreshBtn'),
            fabBtn: document.getElementById('fabBtn'),
            berkasModal: document.getElementById('berkasModal'),
            closeModalBtn: document.getElementById('closeModalBtn'),
            cancelBtn: document.getElementById('cancelBtn'),
            berkasForm: document.getElementById('berkasForm'),
            modalTitle: document.getElementById('modalTitle'),
            fileUploadArea: document.getElementById('fileUploadArea'),
            berkasFile: document.getElementById('berkasFile'),
            selectedFileDiv: document.getElementById('selectedFile'),
            removeFile: document.getElementById('removeFile'),
            submitText: document.getElementById('submitText'),
            fileOptional: document.getElementById('fileOptional'),
            isEdit: document.getElementById('isEdit')
        };

        // Utility Functions
        function clearFormErrors() {
            ['nameError', 'dateError', 'fileError'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.style.display = 'none';
                    element.textContent = '';
                }
            });
        }

        function resetForm() {
            elements.berkasForm.reset();
            document.getElementById('berkasId').value = '';
            elements.isEdit.value = '0';
            selectedFile = null;
            elements.selectedFileDiv.classList.remove('active');
            elements.fileOptional.style.display = 'none';
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

        function getFileIcon(filename) {
            const ext = filename.split('.').pop().toLowerCase();
            const iconMap = {
                pdf: 'fa-file-pdf',
                doc: 'fa-file-word',
                docx: 'fa-file-word',
                xls: 'fa-file-excel',
                xlsx: 'fa-file-excel',
                ppt: 'fa-file-powerpoint',
                pptx: 'fa-file-powerpoint',
                jpg: 'fa-file-image',
                jpeg: 'fa-file-image',
                png: 'fa-file-image',
                gif: 'fa-file-image',
                zip: 'fa-file-archive',
                rar: 'fa-file-archive',
                txt: 'fa-file-alt',
                csv: 'fa-file-csv'
            };
            return iconMap[ext] || 'fa-file';
        }

        // File Upload Handling
        function handleFileSelect(file) {
            if (!file) return;

            if (file.size > 52428800) { // 50MB
                showNotification('Ukuran file maksimal 50MB', 'error');
                return;
            }

            selectedFile = file;
            document.getElementById('selectedFileName').textContent = file.name;
            document.getElementById('selectedFileSize').textContent = formatSize(file.size);
            elements.selectedFileDiv.classList.add('active');
        }

        elements.fileUploadArea.addEventListener('click', () => {
            elements.berkasFile.click();
        });

        elements.berkasFile.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) handleFileSelect(file);
        });

        elements.removeFile.addEventListener('click', (e) => {
            e.stopPropagation();
            selectedFile = null;
            elements.berkasFile.value = '';
            elements.selectedFileDiv.classList.remove('active');
        });

        // Drag and drop
        elements.fileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            elements.fileUploadArea.classList.add('dragover');
        });

        elements.fileUploadArea.addEventListener('dragleave', () => {
            elements.fileUploadArea.classList.remove('dragover');
        });

        elements.fileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            elements.fileUploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) {
                elements.berkasFile.files = e.dataTransfer.files;
                handleFileSelect(file);
            }
        });

        // Load Stats
        async function loadStats() {
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/berkas/stats`);
                if (response.data.success && response.data.data) {
                    const data = response.data.data;
                    document.getElementById('totalBerkas').textContent = data.total_berkas || 0;
                    document.getElementById('totalSize').textContent = data.total_size || '0 MB';
                    document.getElementById('latestUpload').textContent = data.latest_upload || '-';
                    document.getElementById('oldestDate').textContent = data.oldest_date || '-';
                }
            } catch (error) {
                console.log('Stats API error:', error);
            }
        }

        // Load Berkas
        async function loadBerkas() {
            showLoading();
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/berkas`);
                if (response.data.success) {
                    allBerkas = response.data.data || [];
                    renderBerkas(allBerkas);
                } else {
                    renderEmptyState();
                }
            } catch (error) {
                console.error('Error loading berkas:', error);
                showNotification('Gagal memuat berkas', 'error');
                renderEmptyState();
            } finally {
                hideLoading();
            }
        }

        function renderBerkas(berkasList) {
            if (!berkasList || berkasList.length === 0) {
                renderEmptyState();
                return;
            }

            elements.berkasTableBody.innerHTML = '';
            berkasList.forEach((berkas) => {
                const row = createBerkasRow(berkas);
                elements.berkasTableBody.appendChild(row);
            });
        }

        function createBerkasRow(berkas) {
            const row = document.createElement('tr');
            const fileIcon = getFileIcon(berkas.name);

            row.innerHTML = `
                    <td>
                        <div class="file-name">
                            <div class="file-icon">
                                <i class="fas ${fileIcon}"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-title">${berkas.name}</div>
                                <div class="file-meta">Diupload: ${berkas.created_at}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="file-size">${berkas.size_formatted}</span>
                    </td>
                    <td>
                        <span class="file-date">${berkas.date_formatted}</span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-icon download" data-id="${berkas.id}" title="Download">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-icon edit" data-id="${berkas.id}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-icon delete" data-id="${berkas.id}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;

            // Event listeners
            row.querySelector('.download').addEventListener('click', (e) => {
                e.stopPropagation();
                downloadBerkas(berkas.id);
            });

            row.querySelector('.edit').addEventListener('click', (e) => {
                e.stopPropagation();
                openEditModal(berkas.id);
            });

            row.querySelector('.delete').addEventListener('click', (e) => {
                e.stopPropagation();
                deleteBerkas(berkas.id);
            });

            return row;
        }

        function renderEmptyState() {
            elements.berkasTableBody.innerHTML = `
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <h3>Belum Ada Berkas</h3>
                                <p>Mulai dengan mengupload berkas pertama untuk tahun ini.</p>
                                <button class="btn btn-primary" onclick="document.getElementById('addBerkasBtn').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    Upload Berkas
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
        }

        // Search Functionality
        elements.searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const filteredBerkas = allBerkas.filter(berkas =>
                berkas.name.toLowerCase().includes(searchTerm) ||
                berkas.date_formatted.toLowerCase().includes(searchTerm)
            );
            renderBerkas(filteredBerkas);
        });

        // Modal Functions
        function openAddModal() {
            elements.modalTitle.textContent = 'Upload Berkas Baru';
            elements.submitText.textContent = 'Upload';
            resetForm();
            currentBerkasId = null;

            // Set today as default date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('berkasDate').value = today;

            elements.berkasModal.style.display = 'flex';
        }

        async function openEditModal(berkasId) {
            showLoading();
            try {
                const response = await axios.get(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/berkas/${berkasId}/edit`);
                if (response.data.success) {
                    const berkas = response.data.data;
                    elements.modalTitle.textContent = 'Edit Berkas';
                    elements.submitText.textContent = 'Update';
                    document.getElementById('berkasId').value = berkas.id;
                    document.getElementById('berkasName').value = berkas.name;
                    document.getElementById('berkasDate').value = berkas.date;
                    elements.isEdit.value = '1';
                    currentBerkasId = berkas.id;

                    // Show optional file text
                    elements.fileOptional.style.display = 'inline';

                    elements.berkasModal.style.display = 'flex';
                }
            } catch (error) {
                console.error('Error loading berkas:', error);
                showNotification('Gagal memuat data berkas', 'error');
            } finally {
                hideLoading();
            }
        }

        function closeModal() {
            elements.berkasModal.style.display = 'none';
            resetForm();
            currentBerkasId = null;
        }

        // Form Submission
        async function handleSubmit(e) {
            e.preventDefault();

            const isEdit = elements.isEdit.value === '1';

            // Validate file for new upload
            if (!isEdit && !selectedFile) {
                document.getElementById('fileError').textContent = 'File wajib diupload';
                document.getElementById('fileError').style.display = 'block';
                return;
            }

            const formData = new FormData(elements.berkasForm);

            const url = currentBerkasId
                ? `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/berkas/${currentBerkasId}`
                : `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/berkas`;

            showLoading();

            try {
                const response = await axios.post(url, formData, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.success) {
                    showNotification(response.data.message, 'success');
                    loadStats();
                    loadBerkas();
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

        // Download Berkas
        async function downloadBerkas(berkasId) {
            showLoading();
            try {
                window.location.href = `/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/berkas/${berkasId}/download`;
                showNotification('File sedang diunduh...', 'success');
            } catch (error) {
                console.error('Error downloading berkas:', error);
                showNotification('Gagal mengunduh file', 'error');
            } finally {
                hideLoading();
            }
        }

        // Delete Berkas
        async function deleteBerkas(berkasId) {
            if (!confirm('Apakah Anda yakin ingin menghapus berkas ini?')) {
                return;
            }

            showLoading();
            try {
                const response = await axios.delete(`/api/kategori/${kategoriId}/detail/${detailId}/tahun/${tahunId}/berkas/${berkasId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.data.success) {
                    showNotification(response.data.message, 'success');
                    loadStats();
                    loadBerkas();
                }
            } catch (error) {
                console.error('Error deleting berkas:', error);
                showNotification(error.response?.data?.message || 'Gagal menghapus berkas', 'error');
            } finally {
                hideLoading();
            }
        }

        // Initialize Everything
        function init() {
            loadStats();
            loadBerkas();

            // Event Listeners
            elements.addBerkasBtn.addEventListener('click', openAddModal);
            elements.fabBtn.addEventListener('click', openAddModal);
            elements.refreshBtn.addEventListener('click', () => {
                showNotification('Memperbarui data...', 'success');
                loadStats();
                loadBerkas();
            });

            elements.closeModalBtn.addEventListener('click', closeModal);
            elements.cancelBtn.addEventListener('click', closeModal);

            elements.berkasModal.addEventListener('click', (e) => {
                if (e.target === elements.berkasModal) {
                    closeModal();
                }
            });

            elements.berkasForm.addEventListener('submit', handleSubmit);

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeModal();
                }
                if (e.ctrlKey && e.key === 'u') {
                    e.preventDefault();
                    openAddModal();
                }
            });
        }

        // Start the application
        document.addEventListener('DOMContentLoaded', init);
    </script>
@endsection