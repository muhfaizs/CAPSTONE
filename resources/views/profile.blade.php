<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.profile') }} - Certification Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f7f9fb;
            --sidebar-bg: #fff;
            --text-color: #333;
            --card-bg: #fff;
            --border-color: rgba(0,0,0,0.125);
            --shadow-color: rgba(0,0,0,0.04);
            --highlight-bg: #e6f0fa;
            --highlight-color: #0d6efd;
        }
        
        [data-theme="dark"] {
            --bg-color: #121212;
            --sidebar-bg: #1e1e1e;
            --text-color: #e0e0e0;
            --card-bg: #2d2d2d;
            --border-color: rgba(255,255,255,0.125);
            --shadow-color: rgba(0,0,0,0.2);
            --highlight-bg: #2c3e50;
            --highlight-color: #5e9eff;
        }
        
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        body {
            background: var(--bg-color);
            color: var(--text-color);
            padding: 40px 0;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        .sidebar {
            min-height: 100vh;
            width: 230px;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            background: var(--sidebar-bg);
            box-shadow: 2px 0 8px var(--shadow-color);
            z-index: 10;
            padding: 2rem 1.2rem 1.2rem 1.2rem;
            overflow-y: auto;
            max-height: 100vh;
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
            padding: 2.5rem 2rem;
        }
        .card {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
        .card-header, .card-footer {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
        .table {
            color: var(--text-color);
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        [data-theme="dark"] .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
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
        .card-stat {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 2px 8px var(--shadow-color);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
        }
        .card-table {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            padding: 1.2rem 1.5rem;
        }
        .stat-bar {
            height: 60px;
            background: #e6f0fa;
            border-radius: 8px;
            margin-top: 0.5rem;
        }
        .stat-bar-inner {
            background: #0d6efd;
            height: 100%;
            border-radius: 8px;
        }
        .stat-label {
            font-size: 0.95rem;
            color: #888;
            margin-top: 0.3rem;
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
        [data-theme="dark"] .sidebar {
            color: #fff;
        }
        [data-theme="dark"] .sidebar .nav-link {
            color: #fff;
        }
        [data-theme="dark"] .sidebar .nav-link.active, [data-theme="dark"] .sidebar .nav-link:focus {
            color: #42a5f5;
        }
        
        .profile-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 8px 24px var(--shadow-color);
            border-color: var(--border-color);
            max-width: 1100px;
            min-height: 700px;
            margin: 3rem auto;
            padding: 2.5rem 2rem 2rem 2rem;
            width: 100%;
        }
        .profile-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        .form-label { font-weight: 500; }
        .form-control, .form-select { border-radius: 8px; }
        .password-rules { color: #d9534f; font-size: 0.95rem; }
        .alert { margin-bottom: 1.5rem; }
        .sidebar hr {
            border-color: var(--border-color);
            opacity: 1;
        }
        .sidebar label,
        .sidebar .small,
        .sidebar .brand,
        .sidebar .nav-link,
        .sidebar .dropdown-toggle,
        .sidebar .nav-link i {
            color: inherit !important;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:focus {
            background: var(--highlight-bg);
            color: var(--highlight-color) !important;
        }
        .sidebar .dropdown-toggle::after {
            color: inherit !important;
        }
        .sidebar .btn, .sidebar button, .sidebar .folder-tab {
            color: inherit !important;
        }
        .sidebar .folder-tab .checkmark {
            color: #2196f3 !important;
        }
        .sidebar .folder-tab.selected::after {
            border: 2px solid #2196f3;
        }
        .profile-card, .card {
            background: var(--card-bg);
            color: var(--text-color);
        }
        .profile-card label,
        .profile-card .form-label,
        .profile-card .form-control,
        .profile-card .form-text,
        .profile-card .btn,
        .profile-card .toggle-password {
            color: var(--text-color) !important;
        }
        .profile-card .form-control {
            background: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-color);
        }
        .profile-card .form-control:focus {
            background: var(--card-bg);
            color: var(--text-color);
        }
        .profile-card .btn {
            background: #6b90b6;
            color: #fff !important;
        }
        [data-theme="dark"] .profile-card .btn {
            background: #4d6a8a;
            color: #fff !important;
        }
        .main-bg {
            background: var(--bg-color);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    
<div class="sidebar d-flex flex-column">
        <div class="d-flex align-items-center mb-4">
            <img src="/images/EMP-Logo-removebg-preview.png" alt="Logo" class="logo">
            <span class="brand">Certification Monitoring</span>
        </div>
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
            @if(Auth::user()->role === 'HRD')
            <li class="nav-item mb-2">
                <a href="/dashboard" class="nav-link"><i class="bi bi-house-door"></i>{{ __('messages.dashboard') }}</a>
            </li>
            @endif
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
                        @if(Auth::user()->role === 'HRD')
                        <li><a href="{{ route('certificate.search') }}" class="nav-link">{{ __('messages.search_certificate') }}</a></li>
                        <li><a href="{{ route('certificate.create') }}" class="nav-link">{{ __('messages.add_certificate') }}</a></li>
                        @else
                        <li><a href="{{ route('employee.certificate.search') }}" class="nav-link">{{ __('messages.search_certificate') }}</a></li>
                        <li><a href="{{ route('employee.certificate.create') }}" class="nav-link">{{ __('messages.add_certificate') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
          
        </ul>
    </div>
        <!-- End Sidebar -->
        <div class="flex-grow-1 d-flex align-items-center justify-content-center main-bg">
            <div class="profile-card">
                <h3 class="fw-bold mb-4">{{ __('messages.profile') }}</h3>
                
                {{-- Display success/error messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                {{-- Display validation errors --}}
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(Auth::check())
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'User') . '&background=6b90b6&color=fff' }}" 
                                 class="profile-photo" 
                                 id="photo-preview"
                                 alt="Profile Photo">
                            <div class="mb-2">
                                <input type="file" name="photo" id="photo" class="form-control" accept="image/*" onchange="previewPhoto(event)">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.name') }}*</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name ?? '') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.email_address') }}*</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.phone_number') }}*</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">{{ __('messages.address') }}*</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address', Auth::user()->address ?? '') }}" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.role') }}*</label>
                                <select class="form-select" name="role" required>
                                    <option value="">{{ __('messages.select_role') }}</option>
                                    <option value="Admin" {{ old('role', Auth::user()->role ?? '') == 'Admin' ? 'selected' : '' }}>{{ __('messages.admin') }}</option>
                                    <option value="User" {{ old('role', Auth::user()->role ?? '') == 'User' ? 'selected' : '' }}>{{ __('messages.user') }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.branch') }}*</label>
                                <input type="text" class="form-control" name="branch" value="{{ old('branch', Auth::user()->branch ?? '') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('messages.jabatan') }}*</label>
                                <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan', Auth::user()->jabatan ?? '') }}" required>
                            </div>
                        </div>
                        
                        
                        <button type="submit" class="btn btn-primary">{{ __('messages.update_profile') }}</button>
                    </form>
                @else
                    <div class="alert alert-warning">
                        <p>{{ __('messages.login_required') }}</p>
                        <a href="{{ route('login') }}" class="btn btn-primary">{{ __('messages.login') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(){
                    document.getElementById('photo-preview').src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const pass = document.getElementById('password').value;
            const conf = this.value;
            const errorDiv = document.getElementById('confirm-password-error');
            
            if (pass && conf && pass !== conf) {
                errorDiv.textContent = '{{ __('messages.passwords_do_not_match') }}';
            } else {
                errorDiv.textContent = '';
            }
        });
        
        // Password validation
        document.getElementById('password').addEventListener('input', function() {
            const conf = document.getElementById('password_confirmation').value;
            const pass = this.value;
            const errorDiv = document.getElementById('confirm-password-error');
            
            if (pass && conf && pass !== conf) {
                errorDiv.textContent = '{{ __('messages.passwords_do_not_match') }}';
            } else {
                errorDiv.textContent = '';
            }
        });
    </script>
    <script>
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
    </script>
</body>
</html>