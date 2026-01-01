<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.search_certificate') }} - Certification Monitoring</title>
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
        }
        
        [data-theme="dark"] {
            --bg-color: #0f0f23;
            --sidebar-bg: #121212;
            --text-color: #e0e0e0;
            --card-bg: #1e1e1e;
            --border-color: rgba(255,255,255,0.125);
            --shadow-color: rgba(0,0,0,0.3);
            --highlight-bg: #333333;
            --highlight-color: #5e9eff;
        }
        
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
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
            box-shadow: 2px 0 8px var(--shadow-color);
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
        .main-content {
            margin-left: 250px;
            padding: 2rem 1.5rem;
            min-height: 100vh;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .table {
            color: var(--text-color);
        }

        [data-theme="dark"] .table {
            --bs-table-bg: #1e1e1e;
            --bs-table-striped-bg: #252525;
            --bs-table-hover-bg: #2a2a2a;
        }

        .form-control, .form-select {
            background-color: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-color);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #2a2a2a;
            border-color: #404040;
        }

        .action-icons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .action-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .action-icon:hover {
            transform: scale(1.1);
        }

        .icon-view {
            background-color: #e6f7ff;
            color: #17a2b8;
        }

        .icon-view:hover {
            background-color: #ccefff;
        }

        .icon-download {
            background-color: #e6fff0;
            color: #198754;
        }

        .icon-download:hover {
            background-color: #ccffdd;
        }

        .icon-delete {
            background-color: #ffe6e9;
            color: #dc3545;
        }

        .icon-delete:hover {
            background-color: #ffccd1;
        }

        .badge {
            padding: 0.5rem 1rem;
            font-weight: 500;
        }

        /* Pagination Styling */
        .pagination-custom {
            gap: 5px;
        }

        .pagination-custom .page-item .page-link {
            min-width: 80px;
            text-align: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            color: var(--text-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination-custom .page-item.active .page-link {
            background: var(--highlight-color);
            color: #fff;
            border-color: var(--highlight-color);
        }

        .pagination-custom .page-item:not(.active):not(.disabled) .page-link:hover {
            background: var(--highlight-bg);
            color: var(--highlight-color);
            border-color: var(--highlight-color);
        }

        .pagination-custom .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
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
            color: var(--text-color);
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }
        
        .lang-switcher a.active {
            color: var(--highlight-color);
            font-weight: bold;
            background: var(--highlight-bg);
        }
        
        .lang-divider {
            width: 2px;
            height: 28px;
            background: var(--text-color);
            margin: 0 8px;
            border-radius: 2px;
            opacity: 0.3;
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

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    
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
                    <li><a href="{{ route('employee.certificate.search') }}" class="nav-link active">{{ __('messages.search_certificate') }}</a></li>
                    <li><a href="{{ route('employee.certificate.create') }}" class="nav-link">{{ __('messages.add_certificate') }}</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>

<div class="main-content">
    <div class="card p-4 mb-4">
        <h3 class="fw-bold mb-4">{{ __('messages.search_certificate') }}</h3>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('employee.certificate.search') }}" id="searchForm">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">{{ __('messages.search') }}</label>
                    <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Search...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('messages.lsp') }}</label>
                    <select class="form-select" name="lsp">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach($lsps as $lsp)
                            <option value="{{ $lsp->name }}" {{ request('lsp') == $lsp->name ? 'selected' : '' }}>{{ $lsp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('messages.qualification') }}</label>
                    <select class="form-select" name="qualification">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach($qualifications as $qual)
                            <option value="{{ $qual->name }}" {{ request('qualification') == $qual->name ? 'selected' : '' }}>{{ $qual->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> {{ __('messages.search') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results -->
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">{{ __('messages.certificate_list') }}</h5>
            <span class="badge bg-primary">{{ $certificates->total() }} {{ __('messages.certificates') }}</span>
        </div>
        
        @if($certificates->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>{{ __('messages.name') }}</th>
                            <th>{{ __('messages.qualification') }}</th>
                            <th>{{ __('messages.lsp') }}</th>
                            <th>{{ __('messages.registration_number') }}</th>
                            <th>{{ __('messages.issued_date') }}</th>
                            <th>{{ __('messages.valid_until') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificates as $index => $cert)
                            <tr>
                                <td>{{ $certificates->firstItem() + $index }}</td>
                                <td>{{ $cert->full_name }}</td>
                                <td>{{ $cert->qualification }}</td>
                                <td>{{ $cert->lsp }}</td>
                                <td>{{ $cert->certificate_registration_number }}</td>
                                <td>{{ $cert->issue_date ? \Carbon\Carbon::parse($cert->issue_date)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $cert->expiry_date ? \Carbon\Carbon::parse($cert->expiry_date)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($cert->expiry_date && \Carbon\Carbon::parse($cert->expiry_date)->isPast())
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif($cert->expiry_date && \Carbon\Carbon::parse($cert->expiry_date)->diffInDays(now()) <= 30)
                                        <span class="badge bg-warning">Expiring Soon</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-icons">
                                        @if($cert->file_content || $cert->file_path)
                                            <a href="{{ route('certificate.file', $cert->id) }}" target="_blank" class="action-icon icon-view" title="View PDF">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('certificate.file', $cert->id) }}" download class="action-icon icon-download" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @endif
                                        <button type="button" class="action-icon icon-delete" onclick="deleteCertificate({{ $cert->id }})" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-custom">
                        {{-- Previous Button --}}
                        @if ($certificates->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $certificates->previousPageUrl() }}" rel="prev">Previous</a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($certificates->getUrlRange(1, $certificates->lastPage()) as $page => $url)
                            @if ($page == $certificates->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($certificates->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $certificates->nextPageUrl() }}" rel="next">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">{{ __('messages.no_certificates_found') }}</p>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this certificate?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
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

// Delete certificate
let deleteId = null;
function deleteCertificate(id) {
    deleteId = id;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (deleteId) {
        axios.delete(`/employee/certificate/${deleteId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            alert('Error deleting certificate');
        });
    }
});
</script>
</body>
</html>
