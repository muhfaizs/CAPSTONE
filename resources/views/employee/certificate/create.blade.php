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
        
        :root {
            --text-color: #333;
            --bg-color: #f7f9fb;
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

        body {
            background: var(--bg-color);
            color: var(--text-color);
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
            overflow-y: auto;
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
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover {
            background: var(--highlight-bg);
            color: var(--highlight-color);
        }
        .sidebar .nav-link.active, .sidebar .nav-link:focus {
            background: var(--highlight-bg);
            color: var(--highlight-color);
        }
        .sidebar .nav-link i {
            margin-right: 0.7rem;
        }
        .sidebar .dropdown-toggle::after {
            float: right;
            margin-top: 0.5rem;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .cert-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.13);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 900px;
            margin: 3rem auto;
            width: 100%;
        }
        .form-label { font-weight: 500; }
        .form-control, .form-select { 
            border-radius: 8px;
            background-color: var(--bg-color);
            border-color: var(--border-color);
            color: var(--text-color);
        }
        .btn-primary { 
            background: #6b90b6; 
            color: #fff; 
            border-radius: 24px; 
            font-weight: 600; 
            font-size: 1.1rem; 
            padding: 0.6rem 2.5rem;
            border: none;
        }
        .btn-primary:hover { background: #4d6a8a; }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #3a3a3a;
            border-color: #505050;
            color: #e0e0e0;
        }

        .lang-switcher {
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border-radius: 8px;
            padding: 4px 0;
            margin: 10px 0;
        }
        
        .lang-switcher a {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 60px;
            padding: 4px 10px;
            text-decoration: none;
            color: #222;
            font-weight: 500;
            border-radius: 0;
            background: transparent;
            border: none;
            transition: background 0.2s, color 0.2s;
        }
        
        .lang-switcher a.active {
            color: #0d6efd;
            font-weight: bold;
            background: #e6f0fa;
        }
        
        .lang-divider {
            width: 2px;
            height: 28px;
            background: #222;
            margin: 0 8px;
            border-radius: 2px;
            opacity: 0.7;
        }

        .folder-tab {
            width: 36px;
            height: 36px;
            border: none;
            background: transparent;
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

        [data-theme="dark"] .folder-tab::after {
            background: #2d2d2d;
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
                position: fixed;
                min-height: 100vh;
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }

        @media (max-width: 576px) {
            .main-content { padding: 70px 0.75rem 1rem 0.75rem; }
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
                <a class="text-decoration-none text-muted dropdown-toggle" data-bs-toggle="collapse" href="#empMenu" role="button" aria-expanded="false" aria-controls="empMenu">{{ Auth::user()->jabatan ?? 'Employee' }}</a>
                <div class="collapse" id="empMenu">
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
        @endif
    </div>
    <!-- End Profile Sidebar -->
    
    <ul class="nav flex-column">
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
                    <li><a href="{{ route('employee.certificate.search') }}" class="nav-link">{{ __('messages.search_certificate') }}</a></li>
                    <li><a href="{{ route('employee.certificate.create') }}" class="nav-link active">{{ __('messages.add_certificate') }}</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>

<div class="main-content">
    <div class="cert-card">
        <h3 class="fw-bold mb-4">{{ __('messages.add_certificate') }}</h3>
        
        <form method="POST" action="{{ route('employee.certificate.store') }}" enctype="multipart/form-data" id="certificateForm">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">{{ __('messages.name') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                    <div class="invalid-feedback" id="name-error"></div>
                </div>
                <div class="col-md-6">
                    <label for="company_name" class="form-label">{{ __('messages.company_name') }}</label>
                    <select class="form-select" id="company_name" name="company_name">
                        <option value="">{{ __('messages.select_business_unit') }}</option>
                        @foreach($businessUnits as $unit)
                            <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="qualification" class="form-label">{{ __('messages.qualification') }}</label>
                    <select class="form-select" id="qualification" name="qualification">
                        <option value="">{{ __('messages.select_qualification') }}</option>
                        @foreach($qualifications as $qual)
                            <option value="{{ $qual->name }}">{{ $qual->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="lsp" class="form-label">{{ __('messages.lsp') }}</label>
                    <select class="form-select" id="lsp" name="lsp">
                        <option value="">{{ __('messages.select_lsp') }}</option>
                        @foreach($lsps as $lspItem)
                            <option value="{{ $lspItem->name }}">{{ $lspItem->name }}</option>
                        @endforeach
                    </select>
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
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Berhasil!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Data berhasil ditambahkan!</h5>
                <p class="text-muted">Sertifikat telah berhasil disimpan.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('employee.certificate.search') }}" class="btn btn-primary">Lihat Daftar Sertifikat</a>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Error!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle
    const themeToggle = document.getElementById('themeToggle');
    const lightThemeIcon = document.querySelector('.light-theme-icon');
    const darkThemeIcon = document.querySelector('.dark-theme-icon');
    const sidebar = document.querySelector('.sidebar');
    const colorBtns = document.querySelectorAll('.sidebar-color-btn');

    function isColorDark(hex) {
        if (!hex) return false;
        hex = hex.replace('#', '');
        if (hex.length === 3) hex = hex.split('').map(x => x + x).join('');
        const r = parseInt(hex.substr(0,2),16);
        const g = parseInt(hex.substr(2,2),16);
        const b = parseInt(hex.substr(4,2),16);
        return ((r*299)+(g*587)+(b*114))/1000 < 128;
    }

    const savedTheme = localStorage.getItem('theme') || 'light';
    const savedSidebarColor = localStorage.getItem('sidebarColor');
    
    function applySidebarColor(theme, color) {
        if (theme === 'dark') {
            sidebar.style.background = '';
            sidebar.style.color = '';
            sidebar.querySelectorAll('*').forEach(el => el.style.color = '');
        } else {
            if (color) {
                sidebar.style.background = color;
                const fontColor = isColorDark(color) ? '#fff' : '#333';
                sidebar.style.color = fontColor;
                sidebar.querySelectorAll('*').forEach(el => el.style.color = fontColor);
            } else {
                sidebar.style.background = '';
                sidebar.style.color = '';
                sidebar.querySelectorAll('*').forEach(el => el.style.color = '');
            }
        }
    }
    
    document.documentElement.setAttribute('data-theme', savedTheme);
    if (savedTheme === 'dark') {
        lightThemeIcon.classList.add('d-none');
        darkThemeIcon.classList.remove('d-none');
    }
    applySidebarColor(savedTheme, savedSidebarColor);
    
    if (savedSidebarColor && savedTheme !== 'dark') {
        colorBtns.forEach(btn => {
            const check = btn.querySelector('.checkmark');
            if (btn.getAttribute('data-color') === savedSidebarColor) {
                btn.classList.add('selected');
                if (check) check.style.display = 'block';
            }
        });
    }
    
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
            if ((localStorage.getItem('theme') || 'light') === 'light') {
                applySidebarColor('light', color);
            }
        });
    });

    // Form submission
    const form = document.getElementById('certificateForm');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = submitBtn.querySelector('.spinner-border');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        
        // Show loading
        spinner.classList.remove('d-none');
        submitBtn.disabled = true;
        
        const formData = new FormData(form);
        
        axios.post('/employee/certificate', formData, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            spinner.classList.add('d-none');
            submitBtn.disabled = false;
            
            if (response.data.success) {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                form.reset();
            }
        })
        .catch(error => {
            spinner.classList.add('d-none');
            submitBtn.disabled = false;
            
            if (error.response && error.response.data) {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                document.getElementById('errorMessage').textContent = error.response.data.message || 'Terjadi kesalahan!';
                
                if (error.response.data.errors) {
                    let errorText = '';
                    Object.keys(error.response.data.errors).forEach(key => {
                        const input = document.getElementById(key);
                        if (input) {
                            input.classList.add('is-invalid');
                            const errorDiv = document.getElementById(key + '-error');
                            if (errorDiv) {
                                errorDiv.textContent = error.response.data.errors[key][0];
                            }
                        }
                        errorText += error.response.data.errors[key][0] + '\n';
                    });
                    document.getElementById('errorDetails').textContent = errorText;
                }
                errorModal.show();
            }
        });
    });

    // Language switcher
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const langLinks = document.querySelectorAll('.lang-switcher a');
    langLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const language = this.getAttribute('href').split('/').pop();
            this.style.opacity = '0.5';
            
            axios.post('/switch-language-ajax', { language: language })
            .then(response => {
                if (response.data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                this.style.opacity = '1';
                window.location.href = this.getAttribute('href');
            });
        });
    });
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
