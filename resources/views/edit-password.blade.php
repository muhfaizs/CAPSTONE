<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Edit Password - Certification Monitoring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --body-bg: #f7f9fb;
            --sidebar-bg: #fff;
            --card-bg: #fff;
            --text-color: #333;
            --text-muted: #6c757d;
            --link-color: #0d6efd;
            --link-hover-color: #0a58ca;
            --active-nav-bg: #e6f0fa;
            --active-nav-color: #0d6efd;
            --border-color: #dee2e6;
            --shadow-color: rgba(0,0,0,0.04);
        }
        
        [data-theme="dark"] {
            --body-bg: #121212;
            --sidebar-bg: #1e1e1e;
            --card-bg: #2d2d2d;
            --text-color: #e0e0e0;
            --text-muted: #adb5bd;
            --link-color: #8ab4f8;
            --link-hover-color: #aecbfa;
            --active-nav-bg: #3a3a3a;
            --active-nav-color: #8ab4f8;
            --border-color: #444;
            --shadow-color: rgba(0,0,0,0.2);
        }
        
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }

        body {
            background: var(--body-bg);
            color: var(--text-color);
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
            color: var(--text-color);
        }
        .sidebar .nav-link {
            color: var(--text-color);
            border-radius: 8px;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:focus {
            background: var(--active-nav-bg);
            color: var(--active-nav-color);
        }
        .sidebar .nav-link i {
            margin-right: 0.7rem;
        }
        .sidebar .dropdown-toggle::after {
            float: right;
            margin-top: 0.5rem;
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
        .edit-password-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.13);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 600px;
            margin: 3rem auto;
            width: 100%;
        }
        .form-label { font-weight: 500; }
        .form-control { border-radius: 8px; }
        .password-rules { color: #d9534f; font-size: 0.95rem; }
        .btn-submit { background: #6b90b6; color: #fff; border-radius: 24px; font-weight: 600; font-size: 1.1rem; padding: 0.6rem 2.5rem; }
        .btn-submit:hover { background: #4d6a8a; }

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
        .toggle-password {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 0.5rem;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .toggle-password:focus {
            outline: none;
            box-shadow: none;
        }
        .toggle-password i {
            font-size: 1.7rem;
            line-height: 1;
        }
        .sidebar hr {
            border-color: var(--border-color);
            opacity: 1;
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
        .sidebar label,
        .sidebar .small,
        .sidebar .brand,
        .sidebar .nav-link,
        .sidebar .dropdown-toggle,
        .sidebar .nav-link i {
            color: inherit !important;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:focus {
            background: var(--active-nav-bg);
            color: var(--active-nav-color) !important;
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
        .edit-password-card {
            background: var(--card-bg);
            color: var(--text-color);
        }
        .edit-password-card label,
        .edit-password-card .form-label,
        .edit-password-card .form-control,
        .edit-password-card .form-text,
        .edit-password-card .btn-submit,
        .edit-password-card .toggle-password,
        .edit-password-card .password-rules,
        .edit-password-card ul#password-rules li {
            color: var(--text-color) !important;
        }
        .edit-password-card .form-control {
            background: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-color);
        }
        .edit-password-card .form-control:focus {
            background: var(--card-bg);
            color: var(--text-color);
        }
        .edit-password-card .btn-submit {
            background: #6b90b6;
            color: #fff !important;
        }
        [data-theme="dark"] .edit-password-card .btn-submit {
            background: #4d6a8a;
            color: #fff !important;
        }

        /* ====================== RESPONSIVE CSS ====================== */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: var(--highlight-color);
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
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 260px;
                z-index: 1000;
            }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 80px 1rem 1.5rem 1rem; }
            .edit-password-card { padding: 1.5rem 1rem; margin: 1rem auto; }
        }

        @media (max-width: 576px) {
            .main-content { padding: 70px 0.75rem 1rem 0.75rem; }
            .edit-password-card { padding: 1rem 0.75rem; }
            .form-control { font-size: 14px; }
        }
        /* ====================== END RESPONSIVE CSS ====================== */
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
                <div class="fw-bold">User</div>
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
                    <i class="bi bi-person"></i>Account
                </a>
                <div class="collapse" id="accountMenu">
                    <ul class="nav flex-column ms-3">
                        <li><a href="{{ route('profile.show') }}" class="nav-link">Profile</a></li>
                        <li><a href="/edit-password" class="nav-link">Edit Password</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#certMenu" role="button" aria-expanded="false" aria-controls="certMenu">
                    <i class="bi bi-award"></i>Certification
                </a>
                <div class="collapse" id="certMenu">
                    <ul class="nav flex-column ms-3">
                        @if(Auth::user()->role === 'HRD')
                        <li><a href="{{ route('certificate.search') }}" class="nav-link">Search Certificate</a></li>
                        <li><a href="{{ route('certificate.create') }}" class="nav-link">Add Certificate</a></li>
                        @else
                        <li><a href="{{ route('employee.certificate.search') }}" class="nav-link">Search Certificate</a></li>
                        <li><a href="{{ route('employee.certificate.create') }}" class="nav-link">Add Certificate</a></li>
                        @endif
                    </ul>
                </div>
            </li>
          
        </ul>
    </div>
    <div class="edit-password-card">
        <h3 class="fw-bold mb-4">{{ __('messages.change_password') }}</h3>
        <form method="POST" action="{{ route('password.edit.update') }}">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('messages.current_password') }}</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                    <button class="toggle-password" type="button" data-target="current_password"><i class="bi bi-eye"></i></button>
                </div>
            </div>
            <div class="mb-3">
                    <label for="new_password" class="form-label">{{ __('messages.new_password') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <button class="toggle-password" type="button" data-target="new_password"><i class="bi bi-eye"></i></button>
                    </div>
                    <div class="form-text">{{ __('messages.password_must_be_8_chars') }}</div>
                    <ul class="small text-muted mb-3" id="password-rules" style="list-style: none; padding-left: 0;">
                        <li id="rule-length"><span class="rule-icon">&#9675;</span> {{ __('messages.use_8_or_more_chars') }}</li>
                        <li id="rule-upper"><span class="rule-icon">&#9675;</span> {{ __('messages.one_uppercase_char') }}</li>
                        <li id="rule-lower"><span class="rule-icon">&#9675;</span> {{ __('messages.one_lowercase_char') }}</li>
                        <li id="rule-number"><span class="rule-icon">&#9675;</span> {{ __('messages.one_number') }}</li>
                        <li id="rule-special"><span class="rule-icon">&#9675;</span> {{ __('messages.one_special_char') }}</li>
                    </ul>
                </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">{{ __('messages.confirm_password') }}*</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    <button class="toggle-password" type="button" data-target="confirm_password"><i class="bi bi-eye"></i></button>
                </div>
                <div class="text-danger mt-2" id="confirm-password-error"></div>
            </div>
            <button type="submit" class="btn btn-submit">{{ __('messages.update_password') }}</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Jika sudah di halaman /edit-password, klik Edit Password akan reload
        document.addEventListener('DOMContentLoaded', function() {
            var editPasswordLink = document.getElementById('edit-password-link');
            if (window.location.pathname === '/edit-password') {
                editPasswordLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.reload();
                });
            }
        });
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const pass = document.getElementById('new_password').value;
            const conf = this.value;
            document.getElementById('confirm-password-error').textContent = pass !== conf ? '{{ __("messages.confirm_password") }}' : '';
        });
        // Password rules validation for edit password
        const passwordInput = document.getElementById('new_password');
        const rules = [
            { id: 'rule-length', test: v => v.length >= 8 },
            { id: 'rule-upper', test: v => /[A-Z]/.test(v) },
            { id: 'rule-lower', test: v => /[a-z]/.test(v) },
            { id: 'rule-number', test: v => /[0-9]/.test(v) },
            { id: 'rule-special', test: v => /[@$!%*#?&]/.test(v) },
        ];
        passwordInput.addEventListener('input', function() {
            const val = passwordInput.value;
            rules.forEach(rule => {
                const li = document.getElementById(rule.id);
                const icon = li.querySelector('.rule-icon');
                if (rule.test(val)) {
                    icon.innerHTML = '&#10003;';
                    icon.style.color = 'green';
                    li.style.color = 'green';
                } else {
                    icon.innerHTML = '&#9675;';
                    icon.style.color = '';
                    li.style.color = '';
                }
            });
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
    </script>
    <script>
        // Toggle show/hide password
        document.querySelectorAll('.toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const target = document.getElementById(this.getAttribute('data-target'));
                const icon = this.querySelector('i');
                if (target.type === 'password') {
                    target.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    target.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
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