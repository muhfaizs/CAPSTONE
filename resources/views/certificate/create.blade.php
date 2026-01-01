<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.add_certificate') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
       
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        
        [data-theme="dark"] .sidebar .nav-link,
        [data-theme="dark"] .sidebar .dropdown-toggle,
        [data-theme="dark"] .sidebar .collapse {
            position: relative;
            z-index: 1031;
        }
        
        [data-theme="dark"] .sidebar hr {
            border-color: rgba(255, 255, 255, 0.1);
            opacity: 0.2;
        }

        body {
            background: #f7f9fb;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        .sidebar {
            min-height: 100vh;
            width: 230px;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            background: var(--sidebar-bg);
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
            z-index: 10;
            padding: 2rem 1.2rem 1.2rem 1.2rem;
        }
        .sidebar .logo {
            height: 40px;
            margin-bottom: 1.2rem;
        }
        .sidebar .brand {
            font-weight: bold;
            font-size: 1.2rem;
            margin-left: 0.5rem;
        }
        .sidebar .nav-link {
            color: var(--text-color);
            border-radius: 8px;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:focus {
            background: #e6f0fa;
            color: #0d6efd;
        }
        .sidebar .nav-link i {
            margin-right: 0.7rem;
        }
        .sidebar .dropdown-toggle::after {
            float: right;
            margin-top: 0.5rem;
        }
    
        .cert-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.13);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 900px;
            margin: 3rem auto;
            width: 100%;
        }
        .form-label { font-weight: 500; }
        .form-control, .form-select { border-radius: 8px; }
        .upload-box {
            border: 2px dashed #b0b8c1;
            border-radius: 12px;
            padding: 2rem 1rem;
            text-align: center;
            background: #f8fafc;
            margin-bottom: 1.5rem;
        }
        .btn-upload { background: #6b90b6; color: #fff; border-radius: 24px; font-weight: 600; font-size: 1.1rem; padding: 0.6rem 2.5rem; }
        .btn-upload:hover { background: #4d6a8a; }

        /* Theme Variables */
        :root {
            --text-color: #333;
            --bg-color: #fff;
            --card-bg: #fff;
            --border-color: #e0e0e0;
            --highlight-bg: #e6f0fa;
            --highlight-color: #0d6efd;
            --sidebar-bg: #fff;
        }

        [data-theme="dark"] {
            --text-color: #e0e0e0;
            --bg-color: #1a1a1a;
            --card-bg: #2d2d2d;
            --border-color: #404040;
            --highlight-bg: #1e3a5f;
            --highlight-color: #42a5f5;
            --sidebar-bg: #1a1a1a;
        }
        
        /* Dark theme form elements */
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #3a3a3a;
            border-color: #505050;
            color: #e0e0e0;
        }
        
        [data-theme="dark"] .form-label {
            color: #e0e0e0;
        }
        
        [data-theme="dark"] .cert-card {
            background-color: var(--card-bg);
            color: var(--text-color);
        }
        
        [data-theme="dark"] .upload-box {
            background-color: #3a3a3a;
            border-color: #505050;
        }
        
        [data-theme="dark"] .nav-tabs .nav-link {
            color: #e0e0e0;
        }
        
        [data-theme="dark"] .nav-tabs .nav-link.active {
            background-color: #3a3a3a;
            color: #42a5f5;
            border-color: #505050 #505050 #3a3a3a;
        }

        /* Dark theme body background */
        [data-theme="dark"] body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        /* Language Switcher */
        .lang-switcher {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin: 4px 0;
        }

        .lang-switcher a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .lang-switcher a:hover, .lang-switcher a.active {
            background: var(--highlight-bg);
            color: var(--highlight-color);
        }

        .lang-divider {
            width: 1px;
            height: 16px;
            background: var(--border-color);
        }

        /* Sidebar Color Picker */
        .sidebar-color-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 6px;
            position: relative;
            border: 2px solid transparent;
            transition: all 0.2s;
        }

        .sidebar-color-btn:hover {
            border-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .sidebar-color-btn.selected {
            border-color: #fff;
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
        }

        .sidebar-color-btn.selected .checkmark {
            display: block !important;
        }

        /* Folder Tab Styles */
        .folder-tab {
            padding: 0;
            position: relative;
            border-radius: 6px;
            overflow: hidden;
        }

        .folder-tab::before {
            content: '';
            display: block;
            width: 100%;
            height: 60%;
            background: var(--tab-color, #2196f3);
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .folder-tab::after {
            content: '';
            display: block;
            width: 100%;
            height: 40%;
            background: #fff;
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .folder-tab.selected::after {
            border: 2px solid #2196f3;
        }

        .folder-tab .checkmark {
            position: absolute;
            top: 4px;
            left: 4px;
            color: #2196f3;
            font-size: 18px;
            display: none;
        }

        .folder-tab.selected .checkmark {
            display: block !important;
        }

        /* Dark theme sidebar adjustments */
        [data-theme="dark"] .sidebar {
            color: #fff;
            background-color: var(--sidebar-bg, #1a1a2e);
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
            z-index: 1030;
        }

        [data-theme="dark"] .sidebar .nav-link {
            color: #fff;
            position: relative;
            z-index: 1031;
        }
        
        [data-theme="dark"] .sidebar .dropdown-toggle {
            position: relative;
            z-index: 1031;
        }
        
        [data-theme="dark"] .sidebar .collapse {
            position: relative;
            z-index: 1031;
        }
        
        [data-theme="dark"] .sidebar hr {
            border-color: var(--border-color);
            opacity: 0.5;
        }

        [data-theme="dark"] .sidebar .nav-link.active, [data-theme="dark"] .sidebar .nav-link:focus {
            color: #42a5f5;
        }

        [data-theme="dark"] .sidebar hr {
            border-color: var(--border-color);
            opacity: 1;
        }

        /* Dark theme folder tabs */
        [data-theme="dark"] .folder-tab::after {
            background: #2d2d2d;
        }

        /* Main content styling */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        /* Hamburger Menu Button for Mobile */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: var(--highlight-color, #0d6efd);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .sidebar { width: 200px; }
            .main-content { margin-left: 210px; padding: 1.5rem 1rem; }
        }

        @media (max-width: 768px) {
            .sidebar-toggle { display: block; }
            .sidebar-overlay.active { display: block; }
            .main-content {
                margin-left: 0;
                padding: 80px 1rem 1.5rem 1rem;
            }
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 260px;
                z-index: 1000;
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .cert-card {
                padding: 1.5rem 1rem;
                margin: 1rem auto;
            }
        }

        @media (max-width: 576px) {
            .main-content { padding: 70px 0.75rem 1rem 0.75rem; }
            .cert-card { padding: 1rem 0.75rem; }
            .form-control, .form-select { font-size: 14px; }
        }
    </style>
</head>
<body>

<!-- Hamburger Toggle Button -->
<button class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</button>
<!-- Overlay -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
<div class="sidebar d-flex flex-column">
        <div class="d-flex align-items-center mb-4">
            <img src="/images/EMP-Logo-removebg-preview.png" alt="Logo" class="logo">
            <span class="brand">Certification Monitoring</span>
        </div>
        <!-- Profile Sidebar -->
        <div class="text-center mb-4">
            @if(Auth::check())
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6b90b6&color=fff' }}" class="rounded-circle mb-2" width="80" height="80" style="object-fit:cover;">
                <div class="fw-bold">{{ Auth::user()->name }}</div>
                <div class="text-muted small">
                    <a class="text-decoration-none text-muted dropdown-toggle" data-bs-toggle="collapse" href="#hrMenu" role="button" aria-expanded="false" aria-controls="hrMenu">{{ Auth::user()->jabatan }}</a>
                    <div class="collapse" id="hrMenu">
                        <ul class="nav flex-column ms-3">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link border-0 bg-transparent text-start w-100">
                                        <i class="bi bi-box-arrow-right"></i> {{ __('messages.logout') }}
                                    </button>
                                </form>
                            </li>

                            <li>
                                <button id="themeToggle" class="nav-link border-0 bg-transparent text-start w-100">
                                    <span class="light-theme-icon"><i class="bi bi-moon"></i> {{ __('messages.dark_mode') }}</span>
                                    <span class="dark-theme-icon d-none"><i class="bi bi-sun"></i> {{ __('messages.light_mode') }}</span>
                                </button>
                            </li>
                            <li>
                                <div class="lang-switcher">
                                    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">
                                        <img src="https://flagcdn.com/24x18/us.png" width="24" height="18" class="me-1" alt="EN"/>
                                        EN
                                    </a>
                                    <div class="lang-divider"></div>
                                    <a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'active' : '' }}">
                                        <img src="https://flagcdn.com/24x18/id.png" width="24" height="18" class="me-1" alt="ID"/>
                                        ID
                                    </a>
                                </div>
                            </li>
                            <li class="mt-2">
                                <div class="text-start mb-2">
                                    <label class="small mb-1">{{ __('messages.sidebar') }}</label>
                                    <div id="sidebarColorPicker" class="d-grid" style="grid-template-columns: repeat(3, 36px); gap: 10px;">
                                        <button class="sidebar-color-btn folder-tab" data-color="#42a5f5" style="--tab-color:#42a5f5"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#90caf9" style="--tab-color:#90caf9"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#80cbc4" style="--tab-color:#80cbc4"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#b9f6ca" style="--tab-color:#b9f6ca"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#fff59d" style="--tab-color:#fff59d"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#ffe082" style="--tab-color:#ffe082"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#ffcc80" style="--tab-color:#ffcc80"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#f8bbd0" style="--tab-color:#f8bbd0"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#b39ddb" style="--tab-color:#b39ddb"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#f5f5f5" style="--tab-color:#f5f5f5"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#b2ebf2" style="--tab-color:#b2ebf2"><span class="checkmark" style="display:none">&#10003;</span></button>
                                        <button class="sidebar-color-btn folder-tab" data-color="#ffd180" style="--tab-color:#ffd180"><span class="checkmark" style="display:none">&#10003;</span></button>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            @else
                <img src="https://ui-avatars.com/api/?name=User&background=6b90b6&color=fff" class="rounded-circle mb-2" width="80" height="80" style="object-fit:cover;">
                <div class="fw-bold">{{ __('messages.user') }}</div>
                <div class="text-muted small"></div>
            @endif
        </div>
        <!-- End Profile Sidebar -->
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="/dashboard" class="nav-link"><i class="bi bi-house-door"></i>{{ __('messages.dashboard') }}</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#accountMenu" role="button" aria-expanded="false" aria-controls="accountMenu">
                    <i class="bi bi-person"></i>{{ __('messages.account') }}
                </a>
                <div class="collapse" id="accountMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('profile.show') }}" class="nav-link">{{ __('messages.profile') }}</a></li>
                        <li><a href="/edit-password" class="nav-link">{{ __('messages.edit_password') }}</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#certMenu" role="button" aria-expanded="false" aria-controls="certMenu">
                    <i class="bi bi-award"></i>{{ __('messages.certification') }}
                </a>
                <div class="collapse" id="certMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('certificate.search') }}" class="nav-link">{{ __('messages.search_certificate') }}</a></li>
                        <li><a href="{{ route('certificate.create') }}" class="nav-link">{{ __('messages.add_certificate') }}</a></li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
    
<div class="main-content">
<div class="cert-card">
        <h3 class="fw-bold mb-4">{{ __('messages.add_certificate') }}</h3>
    <ul class="nav nav-tabs mb-3" id="certTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab">{{ __('messages.input_manual') }}</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="excel-tab" data-bs-toggle="tab" data-bs-target="#excel" type="button" role="tab">{{ __('messages.import_excel') }}</button>
      </li>
    </ul>
    <div class="tab-content" id="certTabContent">
      <!-- Tab Manual -->
      <div class="tab-pane fade show active" id="manual" role="tabpanel">
        <form method="POST" action="{{ route('certificate.store') }}" enctype="multipart/form-data" id="certificateForm">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="name" class="form-label">{{ __('messages.name') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="name" name="name" required>
              <div class="invalid-feedback" id="name-error"></div>
            </div>
            <div class="col-md-6">
              <label for="company_name" class="form-label">{{ __('messages.company_name') }}</label>
              <div class="input-group">
                <select class="form-select" id="company_name" name="company_name">
                  <option value="">{{ __('messages.select_business_unit') }}</option>
                  @foreach($businessUnits as $unit)
                    <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                  @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary" id="addBusinessUnitBtn" title="{{ __('messages.add_business_unit') }}">
                  <i class="bi bi-plus"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="qualification" class="form-label">{{ __('messages.qualification') }}</label>
              <div class="input-group">
                <select class="form-select" id="qualification" name="qualification">
                  <option value="">{{ __('messages.select_qualification') }}</option>
                  @foreach($qualifications as $qual)
                    <option value="{{ $qual->name }}">{{ $qual->name }}</option>
                  @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary" id="addQualificationBtn" title="{{ __('messages.add_qualification') }}">
                  <i class="bi bi-plus"></i>
                </button>
              </div>
            </div>
            <div class="col-md-6">
              <label for="lsp" class="form-label">{{ __('messages.lsp') }}</label>
              <div class="input-group">
                <select class="form-select" id="lsp" name="lsp">
                  <option value="">{{ __('messages.select_lsp') }}</option>
                  @foreach($lsps as $lspItem)
                    <option value="{{ $lspItem->name }}">{{ $lspItem->name }}</option>
                  @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary" id="addLspBtn" title="{{ __('messages.add_lsp') }}">
                  <i class="bi bi-plus"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="certificate_registration_number" class="form-label">{{ __('messages.registration_number') }}</label>
              <input type="text" class="form-control" id="certificate_registration_number" name="certificate_registration_number">
            </div>
            <div class="col-md-6">
              <label for="issue_date" class="form-label">{{ __('messages.issued_date') }}</label>
              <input type="date" class="form-control" id="issue_date" name="issue_date">
              <div class="invalid-feedback" id="issue_date-error"></div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="expiry_date" class="form-label">{{ __('messages.valid_until') }}</label>
              <input type="date" class="form-control" id="expiry_date" name="expiry_date">
              <div class="invalid-feedback" id="expiry_date-error"></div>
            </div>
            <div class="col-md-6">
              <label for="certificate_file" class="form-label">{{ __('messages.certificate_file') }} (PDF) <span class="text-danger">*</span></label>
              <input type="file" class="form-control" id="certificate_file" name="certificate_file" accept=".pdf" required>
              <div class="invalid-feedback" id="certificate_file-error"></div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" id="submitBtn">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            {{ __('messages.submit') }}
          </button>
        </form>
      </div>
      <!-- Tab Excel -->
      <div class="tab-pane fade" id="excel" role="tabpanel">
        <form method="POST" action="{{ route('certificate.importExcel') }}" enctype="multipart/form-data" id="excelImportForm">
          @csrf
          <div 
            id="excelDropzone"
            style="border: 2px dashed #bdbdbd; border-radius: 12px; min-height: 180px; display: flex; align-items: center; justify-content: center; background: #fafafa; cursor: pointer; margin-bottom: 1rem; font-size: 1.2rem; color: #388e3c;"
          >
            <div style="text-align:center;width:100%">
              <i class="bi bi-file-earmark-excel" style="font-size: 2.5rem;"></i><br>
              <span>Drag & drop Excel file here<br>or click to choose file</span>
              <input type="file" id="excel_file" name="excel_file" accept=".xls,.xlsx" style="display:none;">
              <div id="excelFileName" class="mt-2 text-success"></div>
            </div>
          </div>
          <button type="submit" class="btn btn-success">{{ __('messages.import_excel') }}</button>
        </form>
      </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="successModalLabel">
          <i class="bi bi-check-circle-fill me-2"></i>Berhasil!
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
        <h5 class="mt-3" id="successMessage">Data berhasil ditambahkan!</h5>
        <p class="text-muted">Sertifikat telah berhasil disimpan ke database.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <a href="{{ route('certificate.search') }}" class="btn btn-primary">Lihat Daftar Sertifikat</a>
      </div>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="errorModalLabel">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>Error!
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center py-4">
        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
        <h5 class="mt-3" id="errorMessage">Terjadi kesalahan!</h5>
        <p class="text-muted" id="errorDetails">Silakan coba lagi.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Script Drag & Drop -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('excelDropzone');
    const fileInput = document.getElementById('excel_file');
    const fileNameDiv = document.getElementById('excelFileName');

    // Click on dropzone opens file dialog
    dropzone.addEventListener('click', () => fileInput.click());

    // Show file name when selected
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            fileNameDiv.textContent = this.files[0].name;
        }
    });

    // Drag over
    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropzone.style.background = '#f0f0f0';
        dropzone.style.borderColor = '#757575';
    });

    // Drag leave
    dropzone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropzone.style.background = '#fafafa';
        dropzone.style.borderColor = '#bdbdbd';
    });

    // Drop
    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropzone.style.background = '#fafafa';
        dropzone.style.borderColor = '#bdbdbd';
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            fileNameDiv.textContent = e.dataTransfer.files[0].name;
        }
    });
});
</script>

<!-- Script Bootstrap (jika ada) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script untuk AJAX Form Submission dan Validasi -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('certificateForm');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    // Validasi client-side untuk tanggal
    const issueDateInput = document.getElementById('issue_date');
    const expiryDateInput = document.getElementById('expiry_date');
    
    function validateDates() {
        const issueDate = issueDateInput.value;
        const expiryDate = expiryDateInput.value;
        const today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
        
        // Clear previous validation states
        issueDateInput.classList.remove('is-invalid');
        expiryDateInput.classList.remove('is-invalid');
        
        if (issueDate && expiryDate) {
            if (new Date(expiryDate) <= new Date(issueDate)) {
                expiryDateInput.setCustomValidity('Tanggal berlaku harus lebih besar dari tanggal dikeluarkan');
                expiryDateInput.classList.add('is-invalid');
                return false;
            } else {
                expiryDateInput.setCustomValidity('');
                expiryDateInput.classList.remove('is-invalid');
            }
        }
        
        // Optional: Validate that issue date is not in the future
        if (issueDate && issueDate > today) {
            issueDateInput.setCustomValidity('Tanggal dikeluarkan tidak boleh di masa depan');
            issueDateInput.classList.add('is-invalid');
            return false;
        } else {
            issueDateInput.setCustomValidity('');
            issueDateInput.classList.remove('is-invalid');
        }
        
        return true;
    }
    
    issueDateInput.addEventListener('change', validateDates);
    expiryDateInput.addEventListener('change', validateDates);

    // File size validation
    const fileInput = document.getElementById('certificate_file');
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file && file.size > 7 * 1024 * 1024) { // 7MB
            this.value = '';
            // Tampilkan modal error
            document.getElementById('errorMessage').textContent = 'File terlalu besar';
            document.getElementById('errorDetails').textContent = 'Ukuran file maksimal 7MB.';
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }
    });
    
    // AJAX Form Submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous error states
        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        // Validate dates
        if (!validateDates()) {
            return;
        }

        // Validate file size
const fileInput = document.getElementById('certificate_file');
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            if (file.size > 7 * 1024 * 1024) { // 7MB
                fileInput.value = '';
        // Tampilkan modal error
        document.getElementById('errorMessage').textContent = 'File terlalu besar';
        document.getElementById('errorDetails').textContent = 'Ukuran file maksimal 7MB.';
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
                return;
    }
        }

        // Show loading state
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
        
        const formData = new FormData(form);
        const csrfToken = document.querySelector('input[name="_token"]');

        console.log('Starting fetch request to:', form.action);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken ? csrfToken.value : ''
            }
        })
        .then(response => {
            console.log('Response status:', response.status);

            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Error response text:', text);
                    try {
                        const data = JSON.parse(text);
                    throw new Error(JSON.stringify(data));
                    } catch (e) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success modal
                document.getElementById('successMessage').textContent = data.message;
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                
                // Reset form
                form.reset();
            } else {
                // Show error modal
                document.getElementById('errorMessage').textContent = 'Gagal menambahkan data';
                document.getElementById('errorDetails').textContent = data.message || 'Terjadi kesalahan yang tidak diketahui';
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            }
        })
                .catch(error => {
            console.error('Error:', error);

            // Show specific error based on error type
            let errorTitle = 'Terjadi kesalahan';
            let errorDetails = 'Gagal mengirim data ke server. Silakan coba lagi.';

            try {
                // Try to parse error as JSON first
                const errorData = JSON.parse(error.message);

                if (errorData.errors) {
                    // Validation errors
                    showValidationErrors(errorData.errors);
                    return;
                } else if (errorData.message) {
                    errorDetails = errorData.message;
                }
            } catch (parseError) {
                // Not JSON, check if it's an HTTP error
                if (error.message.includes('HTTP')) {
                    errorTitle = 'Kesalahan Server';
                    errorDetails = error.message;
                } else if (error.message.includes('NetworkError') || error.message.includes('Failed to fetch')) {
                    errorTitle = 'Kesalahan Koneksi';
                    errorDetails = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                } else {
                    // Generic error
                    errorDetails = error.message || 'Terjadi kesalahan yang tidak diketahui.';
                }
            }
            
            // Show error modal
            document.getElementById('errorMessage').textContent = errorTitle;
            document.getElementById('errorDetails').textContent = errorDetails;
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        })
        .finally(() => {
            // Hide loading state
            submitBtn.disabled = false;
            spinner.classList.add('d-none');
        });
    });
    
    // Handle validation errors from server
    function showValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const input = document.getElementById(field);
            const errorDiv = document.getElementById(field + '-error');
            
            if (input && errorDiv) {
                input.classList.add('is-invalid');
                errorDiv.textContent = errors[field][0];
            }
        });
    }
});

// Theme toggle & sidebar color picker functionality
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const lightThemeIcon = document.querySelector('.light-theme-icon');
    const darkThemeIcon = document.querySelector('.dark-theme-icon');
    const sidebar = document.querySelector('.sidebar');
    const colorBtns = document.querySelectorAll('.sidebar-color-btn');

    // Helper: check if color is light or dark
    function isColorDark(hex) {
        if (!hex) return false;
        hex = hex.replace('#', '');
        if (hex.length === 3) hex = hex.split('').map(x => x + x).join('');
        const r = parseInt(hex.substr(0,2),16);
        const g = parseInt(hex.substr(2,2),16);
        const b = parseInt(hex.substr(4,2),16);
        // Perceived brightness
        return ((r*299)+(g*587)+(b*114))/1000 < 128;
    }

    // Set theme from localStorage or default
    const savedTheme = localStorage.getItem('theme') || 'light';
    const savedSidebarColor = localStorage.getItem('sidebarColor');
    function applySidebarColor(theme, color) {
        if (theme === 'dark') {
            sidebar.style.background = '';
            sidebar.style.color = '';
            sidebar.classList.add('sidebar-dark');
            // Reset all sidebar children font color to inherit (so CSS takes over)
            sidebar.querySelectorAll('*').forEach(el => {
                el.style.color = '';
            });
        } else {
            sidebar.classList.remove('sidebar-dark');
            if (color) {
                sidebar.style.background = color;
                // Set font color for contrast
                const fontColor = isColorDark(color) ? '#fff' : '#333';
                sidebar.style.color = fontColor;
                sidebar.querySelectorAll('*').forEach(el => {
                    el.style.color = fontColor;
                });
            } else {
                sidebar.style.background = '';
                sidebar.style.color = '';
                sidebar.querySelectorAll('*').forEach(el => {
                    el.style.color = '';
                });
            }
        }
    }
    document.documentElement.setAttribute('data-theme', savedTheme);
    if (savedTheme === 'dark') {
        lightThemeIcon.classList.add('d-none');
        darkThemeIcon.classList.remove('d-none');
    } else {
        lightThemeIcon.classList.remove('d-none');
        darkThemeIcon.classList.add('d-none');
    }
    applySidebarColor(savedTheme, savedSidebarColor);
    // Restore selected color button
    if (savedSidebarColor && savedTheme !== 'dark') {
        colorBtns.forEach(btn => {
            const check = btn.querySelector('.checkmark');
            if (btn.getAttribute('data-color') === savedSidebarColor) {
                btn.classList.add('selected');
                if (check) check.style.display = 'block';
            } else {
                btn.classList.remove('selected');
                if (check) check.style.display = 'none';
            }
        });
    }
    // Toggle theme
    themeToggle.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        if (newTheme === 'dark') {
            lightThemeIcon.classList.add('d-none');
            darkThemeIcon.classList.remove('d-none');
        } else {
            lightThemeIcon.classList.remove('d-none');
            darkThemeIcon.classList.add('d-none');
        }
        applySidebarColor(newTheme, localStorage.getItem('sidebarColor'));
    });
    // Sidebar color picker functionality
    colorBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            colorBtns.forEach(b => {
                b.classList.remove('selected');
                const check = b.querySelector('.checkmark');
                if (check) check.style.display = 'none';
            });
            this.classList.add('selected');
            const check = this.querySelector('.checkmark');
            if (check) check.style.display = 'block';
            const color = this.getAttribute('data-color');
            localStorage.setItem('sidebarColor', color);
            // Only apply if in light mode
            if ((localStorage.getItem('theme') || 'light') === 'light') {
                applySidebarColor('light', color);
            }
        });
    });
});

// Language switcher functionality
document.addEventListener('DOMContentLoaded', function() {
    // Set CSRF token for AJAX requests
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (csrfMeta) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfMeta.getAttribute('content');
    }

    // Language switcher links
    const langLinks = document.querySelectorAll('.lang-switcher a');
    langLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const lang = this.getAttribute('href').split('/').pop();
            // Simple redirect for language switching
            window.location.href = this.getAttribute('href');
        });
    });
});

// Modal functionality for adding new options
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing modals...');

    // Business Unit Modal
    const businessUnitModal = new bootstrap.Modal(document.getElementById('businessUnitModal'));
    console.log('Business Unit Modal initialized');

    const addBusinessUnitBtn = document.getElementById('addBusinessUnitBtn');
    if (addBusinessUnitBtn) {
        addBusinessUnitBtn.addEventListener('click', function() {
            console.log('Add Business Unit button clicked');
            businessUnitModal.show();
        });
        console.log('Business Unit button event listener attached');
    } else {
        console.error('Business Unit button not found');
    }

    // Qualification Modal
    const qualificationModal = new bootstrap.Modal(document.getElementById('qualificationModal'));
    console.log('Qualification Modal initialized');

    document.getElementById('addQualificationBtn').addEventListener('click', function() {
        console.log('Add Qualification button clicked');

        // Auto-select LSP in modal based on main dropdown selection
        const selectedLspId = getSelectedLspId();
        const qualLspSelect = document.getElementById('qual_lsp');
        if (qualLspSelect && selectedLspId > 0) {
            qualLspSelect.value = selectedLspId;
            console.log('Auto-selected LSP in qualification modal:', selectedLspId);
        }

        qualificationModal.show();
    });

    // LSP Modal
    const lspModal = new bootstrap.Modal(document.getElementById('lspModal'));
    console.log('LSP Modal initialized');

    document.getElementById('addLspBtn').addEventListener('click', function() {
        console.log('Add LSP button clicked');
        lspModal.show();
    });

    // Handle Business Unit Form Submission
    const businessUnitForm = document.getElementById('businessUnitForm');
    if (businessUnitForm) {
        businessUnitForm.addEventListener('submit', function(e) {
            console.log('Business Unit form event listener attached and triggered');
            e.preventDefault();
            console.log('Business Unit form submitted');

            const formData = new FormData(this);

            // Add CSRF token to form data
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                formData.append('_token', csrfToken.getAttribute('content'));
                console.log('CSRF token added:', csrfToken.getAttribute('content'));
            }

            // Debug: Log form data
            console.log('Form data being sent:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            fetch('{{ route("business-units.store") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Add new option to dropdown
                    const select = document.getElementById('company_name');
                    const option = new Option(data.data.name, data.data.name);
                    select.appendChild(option);
                    select.value = data.data.name;

                    // Close modal and reset form
                    businessUnitModal.hide();

                    // Reset form and set checkbox to checked
                    this.reset();
                    setTimeout(() => {
                        document.getElementById('bu_active').checked = true;
                    }, 100);

                    // Show success message with same style as search.blade.php
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    successAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    successAlert.innerHTML = `
                        <strong>{{ __('messages.success') }}!</strong> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(successAlert);

                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        if (successAlert.parentNode) {
                            successAlert.remove();
                        }
                    }, 5000);
                } else {
                    // Show validation errors if any
                    if (data.errors) {
                        let errorMessage = 'Validation errors:\n';
                        for (let field in data.errors) {
                            errorMessage += field + ': ' + data.errors[field].join(', ') + '\n';
                        }
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                        errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                        errorAlert.innerHTML = `
                            <strong>{{ __('messages.error') }}!</strong> ${errorMessage.replace(/\n/g, '<br>')}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.body.appendChild(errorAlert);

                        setTimeout(() => {
                            if (errorAlert.parentNode) {
                                errorAlert.remove();
                            }
                        }, 7000);
                    } else {
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                        errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                        errorAlert.innerHTML = `
                            <strong>{{ __('messages.error') }}!</strong> ${data.message || 'Unknown error'}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.body.appendChild(errorAlert);

                        setTimeout(() => {
                            if (errorAlert.parentNode) {
                                errorAlert.remove();
                            }
                        }, 7000);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding business unit: ' + error.message);
            });
        });
        console.log('Business Unit form event listener attached');
    } else {
        console.error('Business Unit form not found');
    }

    // Handle Qualification Form Submission
    document.getElementById('qualificationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route("qualifications.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Qualification Response data:', data);
            if (data.success) {
                // Close modal and reset form first
                qualificationModal.hide();
                this.reset();
                setTimeout(() => {
                    document.getElementById('qual_active').checked = true;
                }, 100);

                // Update qualification dropdown based on current LSP selection
                updateQualificationDropdown();

                // If no LSP is selected, add the new qualification to the dropdown
                const currentLspId = getSelectedLspId();
                if (currentLspId === 0) {
                    const select = document.getElementById('qualification');
                    const option = new Option(data.data.name, data.data.name);
                    // Check if option already exists
                    const existingOption = Array.from(select.options).find(opt => opt.value === data.data.name);
                    if (!existingOption) {
                        select.appendChild(option);
                        select.value = data.data.name;
                    }
                }

                // Show success message with same style as search.blade.php
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                successAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                successAlert.innerHTML = `
                    <strong>{{ __('messages.success') }}!</strong> ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(successAlert);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (successAlert.parentNode) {
                        successAlert.remove();
                    }
                }, 5000);
            } else {
                // Show validation errors if any
                if (data.errors) {
                    let errorMessage = 'Validation errors:\n';
                    for (let field in data.errors) {
                        errorMessage += field + ': ' + data.errors[field].join(', ') + '\n';
                    }
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    errorAlert.innerHTML = `
                        <strong>{{ __('messages.error') }}!</strong> ${errorMessage.replace(/\n/g, '<br>')}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(errorAlert);

                    setTimeout(() => {
                        if (errorAlert.parentNode) {
                            errorAlert.remove();
                        }
                    }, 7000);
                } else {
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    errorAlert.innerHTML = `
                        <strong>{{ __('messages.error') }}!</strong> ${data.message || 'Unknown error'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(errorAlert);

                    setTimeout(() => {
                        if (errorAlert.parentNode) {
                            errorAlert.remove();
                        }
                    }, 7000);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            errorAlert.innerHTML = `
                <strong>{{ __('messages.error') }}!</strong> Error adding qualification
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(errorAlert);

            setTimeout(() => {
                if (errorAlert.parentNode) {
                    errorAlert.remove();
                }
            }, 7000);
        });
    });

    // Handle LSP Form Submission
    document.getElementById('lspForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('{{ route("lsps.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('LSP Response data:', data);
            if (data.success) {
                // Add new option to dropdown
                const select = document.getElementById('lsp');
                const option = new Option(data.data.name, data.data.name);
                select.appendChild(option);
                select.value = data.data.name;

                // Close modal and reset form
                lspModal.hide();

                // Reset form and set checkbox to checked
                this.reset();
                setTimeout(() => {
                    document.getElementById('lsp_active').checked = true;
                }, 100);

                // Show success message with same style as search.blade.php
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                successAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                successAlert.innerHTML = `
                    <strong>{{ __('messages.success') }}!</strong> ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(successAlert);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (successAlert.parentNode) {
                        successAlert.remove();
                    }
                }, 5000);
            } else {
                // Show validation errors if any
                if (data.errors) {
                    let errorMessage = 'Validation errors:\n';
                    for (let field in data.errors) {
                        errorMessage += field + ': ' + data.errors[field].join(', ') + '\n';
                    }
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    errorAlert.innerHTML = `
                        <strong>{{ __('messages.error') }}!</strong> ${errorMessage.replace(/\n/g, '<br>')}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(errorAlert);

                    setTimeout(() => {
                        if (errorAlert.parentNode) {
                            errorAlert.remove();
                        }
                    }, 7000);
                } else {
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    errorAlert.innerHTML = `
                        <strong>{{ __('messages.error') }}!</strong> ${data.message || 'Unknown error'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(errorAlert);

                    setTimeout(() => {
                        if (errorAlert.parentNode) {
                            errorAlert.remove();
                        }
                    }, 7000);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            errorAlert.innerHTML = `
                <strong>{{ __('messages.error') }}!</strong> Error adding LSP
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(errorAlert);

            setTimeout(() => {
                if (errorAlert.parentNode) {
                    errorAlert.remove();
                }
            }, 7000);
        });
    });

    // Function to load qualifications based on selected LSP
    function loadQualificationsByLsp(lspId) {
        console.log('Loading qualifications for LSP:', lspId);

        fetch(`{{ url('/qualifications-by-lsp') }}/${lspId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Qualifications response:', data);
            if (data.success) {
                const qualificationSelect = document.getElementById('qualification');
                const currentValue = qualificationSelect.value;

                // Clear current options except the first one
                qualificationSelect.innerHTML = '<option value="">Select Qualification</option>';

                // Add new options
                data.qualifications.forEach(qualification => {
                    const option = document.createElement('option');
                    option.value = qualification.name;
                    option.textContent = qualification.name;
                    if (currentValue === qualification.name) {
                        option.selected = true;
                    }
                    qualificationSelect.appendChild(option);
                });

                console.log('Qualifications loaded successfully');
            } else {
                console.error('Error loading qualifications:', data.message);
            }
        })
        .catch(error => {
            console.error('Error fetching qualifications:', error);
        });
    }

    // Function to get selected LSP ID
    function getSelectedLspId() {
        const lspSelect = document.getElementById('lsp');
        const selectedValue = lspSelect.value;

        if (selectedValue) {
            const lsps = @json($lsps);
            const selectedLsp = lsps.find(lsp => lsp.name === selectedValue);
            return selectedLsp ? selectedLsp.id : 0;
        }
        return 0;
    }

    // Function to update qualification dropdown based on selected LSP
    function updateQualificationDropdown() {
        const lspId = getSelectedLspId();
        console.log('Updating qualification dropdown for LSP ID:', lspId);
        loadQualificationsByLsp(lspId);
    }

    // Add event listener for LSP selection change
    const lspSelect = document.getElementById('lsp');
    if (lspSelect) {
        lspSelect.addEventListener('change', function() {
            console.log('LSP selection changed');
            updateQualificationDropdown();
        });
        console.log('LSP change event listener attached');
    }

    // Initialize qualification dropdown on page load if LSP is already selected
    document.addEventListener('DOMContentLoaded', function() {
        const initialLspValue = document.getElementById('lsp').value;
        if (initialLspValue) {
            console.log('LSP already selected on page load:', initialLspValue);
            updateQualificationDropdown();
        }
    });
});
</script>

<!-- Business Unit Modal -->
<div class="modal fade" id="businessUnitModal" tabindex="-1" aria-labelledby="businessUnitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="businessUnitModalLabel">{{ __('messages.add_business_unit') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="businessUnitForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="bu_name" class="form-label">{{ __('messages.name') }} *</label>
            <input type="text" class="form-control" id="bu_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="bu_code" class="form-label">{{ __('messages.code') }}</label>
            <input type="text" class="form-control" id="bu_code" name="code" maxlength="10">
          </div>
          <div class="mb-3">
            <label for="bu_abbreviation" class="form-label">{{ __('messages.abbreviation') }}</label>
            <input type="text" class="form-control" id="bu_abbreviation" name="abbreviation" maxlength="50">
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="bu_active" name="is_active" value="1" checked>
              <label class="form-check-label" for="bu_active">
                {{ __('messages.active') }}
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.add_business_unit') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Qualification Modal -->
<div class="modal fade" id="qualificationModal" tabindex="-1" aria-labelledby="qualificationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qualificationModalLabel">{{ __('messages.add_qualification') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="qualificationForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="qual_name" class="form-label">{{ __('messages.name') }} *</label>
            <input type="text" class="form-control" id="qual_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="qual_code" class="form-label">{{ __('messages.code') }}</label>
            <input type="text" class="form-control" id="qual_code" name="code" maxlength="10">
          </div>
          <div class="mb-3">
            <label for="qual_lsp" class="form-label">{{ __('messages.related_lsp') }}</label>
            <select class="form-select" id="qual_lsp" name="lsp_id">
              <option value="">{{ __('messages.select_lsp') }}</option>
              @foreach($lsps as $lspItem)
                <option value="{{ $lspItem->id }}">{{ $lspItem->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="qual_active" name="is_active" value="1" checked>
              <label class="form-check-label" for="qual_active">
                {{ __('messages.active') }}
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.add_qualification') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- LSP Modal -->
<div class="modal fade" id="lspModal" tabindex="-1" aria-labelledby="lspModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lspModalLabel">{{ __('messages.add_lsp') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="lspForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="lsp_name" class="form-label">{{ __('messages.name') }} *</label>
            <input type="text" class="form-control" id="lsp_name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="lsp_abbreviation" class="form-label">{{ __('messages.abbreviation') }}</label>
            <input type="text" class="form-control" id="lsp_abbreviation" name="abbreviation" maxlength="50">
          </div>
          <div class="mb-3">
            <label for="lsp_email" class="form-label">{{ __('messages.email_address') }}</label>
            <input type="email" class="form-control" id="lsp_email" name="email">
          </div>
          <div class="mb-3">
            <label for="lsp_phone" class="form-label">{{ __('messages.phone_number') }}</label>
            <input type="text" class="form-control" id="lsp_phone" name="phone" maxlength="20">
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="lsp_active" name="is_active" value="1" checked>
              <label class="form-check-label" for="lsp_active">
                {{ __('messages.active') }}
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
          <button type="submit" class="btn btn-primary">{{ __('messages.add_lsp') }}</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Script for Excel Import with Elegant Notifications -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const excelForm = document.getElementById('excelImportForm');

    if (excelForm) {
        excelForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Debug: Log FormData contents
            console.log('FormData contents:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            // Ensure file is included
            const fileInput = document.getElementById('excel_file');
            if (!fileInput || fileInput.files.length === 0) {
                alert('{{ __("messages.select_excel_file_first") }}');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }

            const file = fileInput.files[0];
            console.log('File selected:', file);

            // Validate file type
            const allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            if (!allowedTypes.includes(file.type) && !file.name.match(/\.(xls|xlsx)$/i)) {
                alert('{{ __("messages.invalid_excel_file") }}');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }

            // Validate file size (max 10MB)
            const maxSize = 10 * 1024 * 1024; // 10MB
            if (file.size > maxSize) {
                alert('{{ __("messages.file_too_large") }}');
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                return;
            }

            // Show loading state
            const submitBtn = excelForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>{{ __("messages.loading") }}...';

            fetch(`{{ route('certificate.importExcel') }}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    // Don't set Content-Type header for FormData, let browser set it with boundary
                }
            })
            .then(response => response.json())
            .then(data => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;

                if (data.success) {
                    // Show success message with same style as other notifications
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    successAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    successAlert.innerHTML = `
                        <strong>{{ __('messages.success') }}!</strong> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(successAlert);

                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        if (successAlert.parentNode) {
                            successAlert.remove();
                        }
                    }, 5000);

                    // Reset form
                    excelForm.reset();
                    document.getElementById('excelFileName').textContent = '';

                    // Optionally redirect to search page after successful import
                    setTimeout(() => {
                        window.location.href = '{{ route("certificate.search") }}';
                    }, 2000);

                } else {
                    // Show error message
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    errorAlert.innerHTML = `
                        <strong>{{ __('messages.error') }}!</strong> ${data.message || '{{ __("messages.import_failed") }}'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.body.appendChild(errorAlert);

                    setTimeout(() => {
                        if (errorAlert.parentNode) {
                            errorAlert.remove();
                        }
                    }, 7000);
                }
            })
            .catch(error => {
                console.error('Import error:', error);

                // Reset button state
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;

                // Show error message
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                errorAlert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                errorAlert.innerHTML = `
                    <strong>{{ __('messages.error') }}!</strong> {{ __("messages.import_failed") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(errorAlert);

                setTimeout(() => {
                    if (errorAlert.parentNode) {
                        errorAlert.remove();
                    }
                }, 7000);
            });
        });
    }
});

// Sidebar toggle for mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

// Close sidebar when clicking a link (mobile)
document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link:not(.dropdown-toggle)');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                const sidebar = document.querySelector('.sidebar');
                const overlay = document.querySelector('.sidebar-overlay');
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    });
});
</script>
</body>
</html>