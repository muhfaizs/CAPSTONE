<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome - Certification Monitoring System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
            --primary-blue: #1e3a8a;
            --accent-red: #dc2626;
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
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: var(--highlight-bg);
            color: var(--highlight-color);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active, .sidebar .nav-link:focus {
            background: var(--highlight-bg);
            color: var(--highlight-color);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.7rem;
            font-size: 1.1rem;
        }
        
        .sidebar .dropdown-toggle::after {
            float: right;
            margin-top: 0.5rem;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 2.5rem 3rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .welcome-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .welcome-text {
            flex: 1;
            padding-right: 4rem;
            position: relative;
            z-index: 2;
        }
        
        .welcome-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-blue) 0%, #3b82f6 50%, #1d4ed8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1.1;
            animation: fadeInUp 1s ease-out;
            transition: all 0.3s ease;
            cursor: default;
            text-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
        }
        
        .welcome-title:hover {
            transform: scale(1.02);
            filter: brightness(1.1);
            text-shadow: 0 0 40px rgba(59, 130, 246, 0.5);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        

        
        .welcome-illustration {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 500px;
            position: relative;
            z-index: 2;
        }
        
        .simple-icon {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
            position: relative;
            animation: float 3s ease-in-out infinite;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .simple-icon::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shine 3s ease-in-out infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
            100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        }
        
        .simple-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.6);
        }
        
        .simple-icon::before {
            content: '';
            position: absolute;
            width: 160px;
            height: 160px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .simple-icon i {
            font-size: 4rem;
            color: white;
            z-index: 2;
            position: relative;
            animation: bounce 2s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 0.1; transform: scale(1); }
            50% { opacity: 0.2; transform: scale(1.05); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            animation: particleFloat 4s ease-in-out infinite;
        }
        
        .particle:nth-child(1) {
            top: 20%;
            left: 20%;
            animation-delay: 0s;
        }
        
        .particle:nth-child(2) {
            top: 30%;
            right: 25%;
            animation-delay: 1s;
        }
        
        .particle:nth-child(3) {
            bottom: 30%;
            left: 30%;
            animation-delay: 2s;
        }
        
        .particle:nth-child(4) {
            bottom: 20%;
            right: 20%;
            animation-delay: 3s;
        }
        
        .particle:nth-child(5) {
            top: 50%;
            left: 50%;
            animation-delay: 1.5s;
        }
        
        @keyframes particleFloat {
            0%, 100% { 
                transform: translateY(0px) scale(1);
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-20px) scale(1.2);
                opacity: 1;
            }
        }
        

        
        .sidebar hr {
            border-color: var(--border-color);
            opacity: 1;
            margin: 1.5rem 0;
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
        
        .sidebar-lang-open {
            margin-bottom: 70px !important;
        }
        
        @media (max-width: 600px) {
            .sidebar-lang-open {
                margin-bottom: 100px !important;
            }
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
        
        .lang-switcher .lang-divider {
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
        
        @media (max-width: 1200px) {
            .welcome-container {
                flex-direction: column;
                text-align: center;
            }
            
            .welcome-text {
                padding-right: 0;
                margin-bottom: 3rem;
            }
            
            .welcome-title {
                font-size: 2.5rem;
            }
            
            .main-content {
                padding: 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .welcome-title {
                font-size: 2rem;
            }
            
            .simple-icon {
                width: 150px;
                height: 150px;
            }
            
            .simple-icon i {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <div class="d-flex align-items-center mb-4">
            <img src="/images/EMP-Logo-removebg-preview.png" alt="Logo" class="logo">
            <span class="brand">Certification Monitoring </span>
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
                <div class="welcome-container">
            <div class="welcome-text">
                <h1 class="welcome-title">{{ __('messages.welcome_to_certification') }}</h1>
            </div>
            
            <div class="welcome-illustration">
                <div class="particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                </div>
                <div class="simple-icon">
                    <i class="bi bi-award"></i>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Language switcher links
            const langLinks = document.querySelectorAll('.lang-switcher a');
            langLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const language = this.getAttribute('href').split('/').pop();
                    
                    // Show loading state
                    this.style.opacity = '0.5';
                    
                    // Make AJAX request
                    axios.post('/switch-language-ajax', {
                        language: language
                    })
                    .then(response => {
                        if (response.data.success) {
                            // Reload page to apply new language
                            window.location.reload();
                        } else {
                            console.error('Language switch failed:', response.data.message);
                            this.style.opacity = '1';
                        }
                    })
                    .catch(error => {
                        console.error('Error switching language:', error);
                        this.style.opacity = '1';
                        // Fallback to regular link
                        window.location.href = this.getAttribute('href');
                    });
                });
            });
        });
        
        var langDropdown = document.getElementById('langDropdown');
        var sidebar = document.querySelector('.sidebar');
        if (langDropdown && sidebar) {
            langDropdown.addEventListener('show.bs.dropdown', function () {
                sidebar.classList.add('sidebar-lang-open');
            });
            langDropdown.addEventListener('hide.bs.dropdown', function () {
                sidebar.classList.remove('sidebar-lang-open');
            });
        }
    </script>
</body>
</html>
