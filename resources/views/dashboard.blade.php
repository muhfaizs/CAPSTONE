<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.dashboard') }} - Certification Monitoring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
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
            --notification-bg: #fff;
            --notification-border: #dee2e6;
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
            --notification-bg: #2d2d2d;
            --notification-border: #404040;
            --table-striped-bg: #252525;
            --table-hover-bg: #303030;
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
        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        [data-theme="dark"] .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: var(--table-striped-bg);
        }
        
        [data-theme="dark"] .table-hover > tbody > tr:hover {
            background-color: var(--table-hover-bg);
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
        [data-theme="dark"] .folder-tab::after {
            background: #2d2d2d;
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
        /* Dark theme comprehensive styling */
        [data-theme="dark"] .sidebar {
            color: var(--text-color);
        }

        [data-theme="dark"] .sidebar .nav-link {
            color: var(--text-color);
        }

        [data-theme="dark"] .sidebar .nav-link.active,
        [data-theme="dark"] .sidebar .nav-link:focus {
            color: var(--highlight-color);
            background: var(--highlight-bg);
        }

        [data-theme="dark"] .sidebar .dropdown-toggle {
            color: var(--text-color);
        }

        [data-theme="dark"] .sidebar .dropdown-toggle::after {
            border-top-color: var(--text-color);
        }

        [data-theme="dark"] .welcome-section {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(102, 126, 234, 0.05) 100%);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .card-stat {
            background: var(--card-bg);
            border-color: var(--border-color);
        }

        [data-theme="dark"] .card-table {
            background: var(--card-bg);
            border-color: var(--border-color);
        }
        
        [data-theme="dark"] .card-table h6 {
            color: #ffffff;
        }
        
        [data-theme="dark"] .card-table h6 i.bi-exclamation-triangle-fill {
            color: #ffc107;
        }
        
        [data-theme="dark"] .card-table h6 i.bi-x-circle-fill {
            color: #dc3545;
        }

        [data-theme="dark"] .table {
            color: var(--text-color);
        }
        
        [data-theme="dark"] .modal-title {
            color: #ffffff;
        }
        
        [data-theme="dark"] .modal-content {
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        [data-theme="dark"] .modal-content input,
        [data-theme="dark"] .modal-content select {
            background-color: #1e1e1e;
            border-color: #404040;
            color: #e0e0e0;
        }

        [data-theme="dark"] .modal-content label {
            color: #e0e0e0 !important;
        }

        [data-theme="dark"] .modal-content .form-control:focus {
            background-color: #1e1e1e;
            border-color: #5e9eff;
            color: #e0e0e0;
            box-shadow: 0 0 0 0.25rem rgba(94, 158, 255, 0.25);
        }

        [data-theme="dark"] .table thead th {
            background: var(--card-bg);
            border-color: var(--border-color);
            color: var(--text-color);
        }

        [data-theme="dark"] .table tbody td {
            background: var(--card-bg);
            border-color: var(--border-color);
            color: #e0e0e0;
        }

        [data-theme="dark"] .btn-outline-secondary {
            border-color: var(--border-color);
            color: #e0e0e0;
            background-color: #2d2d2d;
        }

        [data-theme="dark"] .btn-outline-secondary:hover {
            background: var(--highlight-bg);
            color: #ffffff;
            border-color: var(--highlight-color);
        }

        [data-theme="dark"] .btn-outline-secondary i {
            color: #e0e0e0;
        }

        [data-theme="dark"] .btn-outline-secondary:hover i {
            color: #ffffff;
        }

        [data-theme="dark"] .dropdown-menu {
            background: var(--notification-bg);
            border-color: var(--notification-border);
        }

        [data-theme="dark"] .dropdown-header {
            color: var(--text-color);
            border-bottom-color: var(--border-color);
        }

        [data-theme="dark"] .notification-item:hover {
            background: var(--highlight-bg);
        }

        /* Ensure all text is visible in dark mode */
        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] h4,
        [data-theme="dark"] h5,
        [data-theme="dark"] h6,
        [data-theme="dark"] p,
        [data-theme="dark"] span,
        [data-theme="dark"] div,
        [data-theme="dark"] label,
        [data-theme="dark"] td,
        [data-theme="dark"] th {
            color: var(--text-color) !important;
        }

        [data-theme="dark"] .text-muted {
            color: #d0d8e1 !important;
        }

        [data-theme="dark"] .badge {
            color: white !important;
        }
        .toggle-password {
            color: #333;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
        .toggle-password:focus {
            outline: none;
            box-shadow: none;
        }
        .toggle-password:hover {
            color: #333;
        }
        .input-group-text {
            background: transparent;
            border: none;
        }
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
        .sidebar-lang-open {
            margin-bottom: 70px !important; /* Atur sesuai tinggi dropdown */
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

        /* Interactive Dashboard Styles */
        .welcome-section {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(102, 126, 234, 0.05) 100%);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .quick-actions .btn {
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .quick-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .interactive-card {
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .interactive-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .interactive-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .interactive-card:hover::before {
            left: 100%;
        }

        .stat-number {
            transition: all 0.5s ease;
        }

        .animated-progress {
            transition: width 1.5s ease-in-out;
        }

        .interactive-table {
            transition: all 0.3s ease;
        }

        .interactive-table:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table-row-interactive {
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .table-row-interactive:hover {
            background-color: var(--highlight-bg) !important;
            transform: scale(1.01);
        }

        .table-count {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .activity-timeline {
            position: relative;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--border-color);
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            position: relative;
            padding-left: 50px;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            position: absolute;
            left: 0;
            top: 0;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .activity-item:hover .activity-icon {
            transform: scale(1.1);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-color);
        }

        .activity-time {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .badge {
            transition: all 0.3s ease;
        }

        .badge:hover {
            transform: scale(1.05);
        }

        /* Loading animation */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Chart Container Styling - Enhanced for better visibility */
        .chart-container {
            position: relative;
            height: 400px; /* Increased height for better visibility */
            width: 100%;
            margin: 0 auto;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: var(--border-color) transparent;
            scroll-behavior: smooth;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--card-bg);
        }

        .chart-container::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .chart-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .chart-container::-webkit-scrollbar-thumb {
            background: var(--highlight-color);
            border-radius: 10px;
            border: 1px solid transparent;
            background-clip: content-box;
        }

        .chart-container::-webkit-scrollbar-thumb:hover {
            background: var(--btn-primary);
            background-clip: content-box;
        }

        .chart-container::-webkit-scrollbar-corner {
            background: transparent;
        }

        /* For Firefox */
        .chart-container {
            scrollbar-width: thin;
            scrollbar-color: var(--highlight-color) rgba(0, 0, 0, 0.1);
        }

        /* Ensure chart canvas doesn't interfere with scrolling */
        .chart-container canvas {
            pointer-events: auto;
            max-width: 100%;
            height: auto !important;
            margin: 10px 0;
        }

        /* Make sure chart container can be scrolled even when chart is present */
        .chart-container:hover {
            cursor: default;
        }

        /* Enhanced chart legend styling */
        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            padding: 10px;
            max-height: 200px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--highlight-color) transparent;
        }

        .chart-legend::-webkit-scrollbar {
            width: 6px;
        }

        .chart-legend::-webkit-scrollbar-track {
            background: transparent;
        }

        .chart-legend::-webkit-scrollbar-thumb {
            background: var(--highlight-color);
            border-radius: 3px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            margin: 3px 0;
            padding: 5px 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            min-width: 120px;
            white-space: nowrap;
        }

        [data-theme="dark"] .legend-item {
            background: rgba(255, 255, 255, 0.05);
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 3px;
            margin-right: 8px;
            display: inline-block;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Notification Dropdown */
        .notification-dropdown {
            min-width: 350px;
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .notification-item:hover {
            background-color: var(--highlight-bg);
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .notification-content {
            flex: 1;
            margin-left: 12px;
        }

        .notification-title {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2px;
            color: var(--text-color);
        }

        .notification-time {
            font-size: 0.8rem;
            color: #6c757d;
        }

        [data-theme="dark"] .notification-time {
            color: #adb5bd;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Pie Chart Legends */
        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            margin: 2px 0;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 2px;
            margin-right: 6px;
            display: inline-block;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .welcome-section {
                padding: 1rem;
            }
            
            .chart-container {
                height: 350px;
                padding: 5px;
            }
            
            .chart-legend {
                max-height: 150px;
                gap: 10px;
            }
            
            .legend-item {
                font-size: 0.8rem;
                min-width: 100px;
                padding: 3px 8px;
            }
            
            .legend-color {
                width: 12px;
                height: 12px;
                margin-right: 6px;
            }
            
            .activity-item {
                padding-left: 40px;
            }
            
            .activity-icon {
                width: 30px;
                height: 30px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .chart-container {
                height: 300px;
                padding: 3px;
            }
            
            .chart-legend {
                max-height: 120px;
                gap: 8px;
            }
            
            .legend-item {
                font-size: 0.75rem;
                min-width: 80px;
                padding: 2px 6px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <div class="d-flex align-items-center mb-4">
            <img src="/EMP-Logo-removebg-preview.png" alt="Logo" class="logo">
            <span class="brand">Certification Monitoring</span>
        </div>
        <!-- Profile Sidebar -->
        <div class="text-center mb-4">
            @if(Auth::check())
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6b90b6&color=fff' }}" class="rounded-circle mb-2" width="80" height="80" style="object-fit:cover;" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent('{{ Auth::user()->name }}') + '&background=6b90b6&color=fff';">
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
        <!-- Welcome Section -->
        <div class="welcome-section mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">{{ __('messages.certification_overview') }}</h4>
                    <p class="text-muted mb-0">{{ __('messages.welcome_back') }} {{ Auth::user()->name }}! {{ __('messages.welcome_message') }}</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <!-- Notification Button -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                        </button>
                        <ul class="dropdown-menu notification-dropdown">
                            <li><h6 class="dropdown-header">{{ __('messages.notifications') }}</h6></li>
                            <li><a href="#" class="text-decoration-none open-expiring-modal" data-bs-toggle="modal" data-bs-target="#expiringSoonModal">
                                <div class="notification-item">
                                    <div class="notification-icon bg-warning">
                                        <i class="bi bi-exclamation-triangle text-white"></i>
            </div>
                                    <div class="notification-content">
                                        <div class="notification-title">{{ __('messages.certificates_expiring_soon') }}</div>
                                        <div class="notification-time">{{ __('messages.check_expiring_certificates') }}</div>
                                    </div>
                                </div>
                            </a></li>
                            <li><a href="#" class="text-decoration-none open-expired-modal" data-bs-toggle="modal" data-bs-target="#expiredModal">
                                <div class="notification-item">
                                    <div class="notification-icon bg-danger">
                                        <i class="bi bi-x-circle text-white"></i>
                                    </div>
                                    <div class="notification-content">
                                        <div class="notification-title">{{ __('messages.expired_certificates') }}</div>
                                        <div class="notification-time">{{ __('messages.check_expired_certificates') }}</div>
                                    </div>
                                </div>
                            </a></li>
                            <li><div class="notification-item">
                                <div class="notification-icon bg-success">
                                    <i class="bi bi-check-circle text-white"></i>
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">{{ __('messages.system_updated') }}</div>
                                    <div class="notification-time">{{ __('messages.today') }}</div>
                                </div>
                            </div></li>
                        </ul>
        </div>

                    <!-- Refresh Button -->
                    <button class="btn btn-primary btn-sm" onclick="refreshCharts()">
                        <i class="bi bi-arrow-clockwise me-1"></i>{{ __('messages.refresh') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Expiring Soon Modal -->
        <div class="modal fade" id="expiringSoonModal" tabindex="-1" aria-labelledby="expiringSoonModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="expiringSoonModalLabel">{{ __('messages.certificates_expiring_soon') }} (3 months)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.name') }}</th>
                                        <th>{{ __('messages.company_name') }}</th>
                                        <th>{{ __('messages.expiry_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="expiringSoonModalBody">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">{{ __('messages.no_certificates_expiring_soon') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                        <button type="button" class="btn btn-success" onclick="exportExpiringSoonToExcel()">{{ __('messages.export_excel') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired Modal -->
        <div class="modal fade" id="expiredModal" tabindex="-1" aria-labelledby="expiredModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="expiredModalLabel">{{ __('messages.expired_certificates') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.name') }}</th>
                                        <th>{{ __('messages.company_name') }}</th>
                                        <th>{{ __('messages.expiry_date') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="expiredModalBody">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">{{ __('messages.no_expired_certificates') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Summary Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card-stat text-center">
                    <div class="fs-2 fw-bold text-primary" id="totalCertificates">0</div>
                    <div class="text-muted">{{ __('messages.total_certificates') }}</div>
                    </div>
                            </div>
            <div class="col-md-3">
                <div class="card-stat text-center">
                    <div class="fs-2 fw-bold text-success" id="totalLsps">0</div>
                    <div class="text-muted">{{ __('messages.total_lsps') }}</div>
                        </div>
                            </div>
            <div class="col-md-3">
                <div class="card-stat text-center">
                    <div class="fs-2 fw-bold text-info" id="totalBusinessUnits">0</div>
                    <div class="text-muted">{{ __('messages.total_business_units') }}</div>
                        </div>
                    </div>
            <div class="col-md-3">
                <div class="card-stat text-center">
                    <div class="fs-2 fw-bold text-warning" id="totalQualifications">0</div>
                    <div class="text-muted">{{ __('messages.total_qualifications') }}</div>
                </div>
            </div>
                    </div>

        <!-- Pie Charts -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">{{ __('messages.lsp_distribution') }}</h6>
                        <span class="badge bg-success">{{ __('messages.certificates') }}</span>
                            </div>
                    <div class="chart-container">
                        <canvas id="lspChart" width="300" height="300"></canvas>
                        </div>
                            </div>
                        </div>
            <div class="col-md-4">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">{{ __('messages.business_unit_distribution') }}</h6>
                        <span class="badge bg-info">{{ __('messages.certificates') }}</span>
                            </div>
                    <div class="chart-container">
                        <canvas id="businessUnitChart" width="300" height="300"></canvas>
                        </div>
                    </div>
                </div>
            <div class="col-md-4">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">{{ __('messages.qualification_distribution') }}</h6>
                        <span class="badge bg-warning">{{ __('messages.certificates') }}</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="qualificationChart" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificate Expiration Alerts -->
        <div class="row g-4 mt-4">
            <div class="col-md-6">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">
                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                            {{ __('messages.certificates_expiring_soon') }}
                        </h6>
                        <div class="d-flex gap-2 align-items-center">
                            <button class="btn btn-success btn-sm export-expiring-btn" onclick="exportExpiringSoonToExcel()">
                                <i class="bi bi-file-earmark-excel me-1"></i>{{ __('messages.export_excel') }}
                            </button>
                            <span class="badge bg-warning" id="expiringCount">0</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.company_name') }}</th>
                                    <th>{{ __('messages.expiry_date') }}</th>
                                </tr>
                            </thead>
                            <tbody id="expiringCertificates">
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        {{ __('messages.no_certificates_expiring_soon') }}
                                            </td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">
                            <i class="bi bi-x-circle-fill text-danger me-2"></i>
                            {{ __('messages.expired_certificates') }}
                        </h6>
                        <div class="d-flex gap-2 align-items-center">
                            <button class="btn btn-success btn-sm export-expired-btn" onclick="exportExpiredToExcel()">
                                <i class="bi bi-file-earmark-excel me-1"></i>{{ __('messages.export_excel') }}
                            </button>
                            <span class="badge bg-danger" id="expiredCount">0</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.company_name') }}</th>
                                    <th>{{ __('messages.expiry_date') }}</th>
                                </tr>
                            </thead>
                            <tbody id="expiredCertificates">
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        {{ __('messages.no_expired_certificates') }}
                                            </td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Inject Expiring Soon Modal markup
        document.addEventListener('DOMContentLoaded', function() {
            const modalHtml = `
            <div class="modal fade" id="expiringSoonModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('messages.certificates_expiring_soon') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.name') }}</th>
                                            <th>{{ __('messages.company_name') }}</th>
                                            <th>{{ __('messages.expiry_date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="expiringSoonModalBody">
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">{{ __('messages.no_certificates_expiring_soon') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                            <button type="button" class="btn btn-success export-expiring-btn" onclick="exportExpiringSoonToExcel()"><i class="bi bi-file-earmark-excel me-1"></i>{{ __('messages.export_excel') }}</button>
                        </div>
                    </div>
                </div>
            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
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
                
                // Reinitialize charts with updated theme
                if (typeof initializeCharts === 'function' && 
                    typeof lspChart !== 'undefined' && 
                    typeof businessUnitChart !== 'undefined' && 
                    typeof qualificationChart !== 'undefined') {
                    
                    // Destroy existing charts
                    lspChart.destroy();
                    businessUnitChart.destroy();
                    qualificationChart.destroy();
                    
                    // Reinitialize charts with new theme
                    initializeCharts();
                    
                    // Reload data to update charts
                    loadDashboardData();
                }
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

        // Dashboard with Real-time Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts
            initializeCharts();

            // Load initial data
            loadDashboardData();

            // Set up auto-refresh every 30 seconds
            setInterval(loadDashboardData, 30000);
        });

        // Global chart variables
        let lspChart, businessUnitChart, qualificationChart;

        // Global data variables for export functionality
        let currentExpiringSoonData = [];
        let currentExpiredData = [];

        // Initialize Chart.js charts
        function initializeCharts() {
            // Detect current theme
            const isDarkMode = document.documentElement.getAttribute('data-theme') === 'dark';
            
            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true,
                            font: {
                                size: 11,
                                weight: '500'
                            },
                            color: isDarkMode ? '#e0e0e0' : '#333', // Adjust text color based on theme
                            boxWidth: 12,
                            boxHeight: 12,
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const dataset = data.datasets[0];
                                        const value = dataset.data[i];
                                        const total = dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return {
                                            text: `${label} (${value} - ${percentage}%)`,
                                            fillStyle: dataset.backgroundColor[i],
                                            strokeStyle: isDarkMode ? '#2d2d2d' : '#fff', // Adjust border color based on theme
                                            lineWidth: dataset.borderWidth || 2,
                                            pointStyle: 'circle',
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: isDarkMode ? 'rgba(45, 45, 45, 0.9)' : 'rgba(0, 0, 0, 0.8)', // Lighter background in dark mode
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: isDarkMode ? 'rgba(255, 255, 255, 0.3)' : 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 6,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            };

            // LSP Chart
            const lspCtx = document.getElementById('lspChart').getContext('2d');
            lspChart = new Chart(lspCtx, {
                type: 'pie',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                        ],
                        borderWidth: 2,
                        borderColor: isDarkMode ? '#2d2d2d' : '#fff'
                    }]
                },
                options: chartOptions
            });

            // Business Unit Chart
            const businessUnitCtx = document.getElementById('businessUnitChart').getContext('2d');
            businessUnitChart = new Chart(businessUnitCtx, {
                type: 'pie',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                        ],
                        borderWidth: 2,
                        borderColor: isDarkMode ? '#2d2d2d' : '#fff'
                    }]
                },
                options: chartOptions
            });

            // Qualification Chart with improved legend
            const qualificationCtx = document.getElementById('qualificationChart').getContext('2d');
            qualificationChart = new Chart(qualificationCtx, {
                type: 'pie',
                data: {
                    labels: [],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                        ],
                        borderWidth: 2,
                        borderColor: isDarkMode ? '#2d2d2d' : '#fff'
                    }]
                },
                options: chartOptions
            });
        }

        // Load dashboard data from API
        function loadDashboardData() {
            fetch('{{ route("dashboard.stats") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                updateSummaryCards(data.summary);
                updateCharts(data);
                console.log('Dashboard data loaded successfully');
            })
            .catch(error => {
                console.error('Error loading dashboard data:', error);
                showNotification('Failed to load dashboard data', 'danger');
            });
        }

        // Update summary cards with animation
        function updateSummaryCards(summary) {
            animateNumber(document.getElementById('totalCertificates'), parseInt(document.getElementById('totalCertificates').textContent) || 0, summary.total_certificates, 1000);
            animateNumber(document.getElementById('totalLsps'), parseInt(document.getElementById('totalLsps').textContent) || 0, summary.total_lsps, 1000);
            animateNumber(document.getElementById('totalBusinessUnits'), parseInt(document.getElementById('totalBusinessUnits').textContent) || 0, summary.total_business_units, 1000);
            animateNumber(document.getElementById('totalQualifications'), parseInt(document.getElementById('totalQualifications').textContent) || 0, summary.total_qualifications, 1000);

            // Update expiration counts
            animateNumber(document.getElementById('expiringCount'), parseInt(document.getElementById('expiringCount').textContent) || 0, summary.expiring_soon_count, 1000);
            animateNumber(document.getElementById('expiredCount'), parseInt(document.getElementById('expiredCount').textContent) || 0, summary.expired_count, 1000);

            // Update notification badge
            updateNotificationBadge(summary.expiring_soon_count, summary.expired_count);
        }

        // Update notification badge
        function updateNotificationBadge(expiringCount, expiredCount) {
            const badge = document.getElementById('notificationBadge');
            const totalNotifications = expiringCount + expiredCount;

            if (totalNotifications > 0) {
                badge.textContent = totalNotifications > 99 ? '99+' : totalNotifications;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        // Update all charts and tables
        function updateCharts(data) {
            updateLspChart(data.lsp_stats);
            updateBusinessUnitChart(data.business_unit_stats);
            updateQualificationChart(data.qualification_stats);
            updateExpirationTables(data);
        }

        // Update expiration tables
        function updateExpirationTables(data) {
            updateExpiringSoonTable(data.expiring_soon);
            updateExpiredTable(data.expired);
        }

        // Update expiring soon table
        function updateExpiringSoonTable(certificates) {
            const tbody = document.getElementById('expiringCertificates');
            const modalTbody = document.getElementById('expiringSoonModalBody');

            // Store data for export functionality
            currentExpiringSoonData = certificates || [];

            if (certificates && certificates.length > 0) {
                const rows = certificates.map(cert => `
                    <tr class="table-row-interactive">
                        <td>${cert.full_name || '-'}</td>
                        <td>${cert.company_name || '-'}</td>
                        <td><span class="badge bg-warning">${cert.expiry_date || '-'}</span></td>
                    </tr>
                `).join('');

                tbody.innerHTML = rows;
                if (modalTbody) modalTbody.innerHTML = rows;
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            {{ __('messages.no_certificates_expiring_soon') }}
                        </td>
                    </tr>
                `;
                if (modalTbody) modalTbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center text-muted">{{ __('messages.no_certificates_expiring_soon') }}</td>
                    </tr>
                `;
            }
        }

        // Update expired table
        function updateExpiredTable(certificates) {
            const tbody = document.getElementById('expiredCertificates');
            const modalTbody = document.getElementById('expiredModalBody');

            // Store data for export functionality
            currentExpiredData = certificates || [];

            if (certificates && certificates.length > 0) {
                const rows = certificates.map(cert => `
                    <tr class="table-row-interactive">
                        <td>${cert.full_name || '-'}</td>
                        <td>${cert.company_name || '-'}</td>
                        <td><span class="badge bg-danger">${cert.expiry_date || '-'}</span></td>
                    </tr>
                `).join('');

                tbody.innerHTML = rows;
                if (modalTbody) modalTbody.innerHTML = rows;
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            {{ __('messages.no_expired_certificates') }}
                        </td>
                    </tr>
                `;
                if (modalTbody) modalTbody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center text-muted">{{ __('messages.no_expired_certificates') }}</td>
                    </tr>
                `;
            }
        }

        // Update LSP chart
        function updateLspChart(lspStats) {
            const labels = lspStats.map(item => item.name);
            const data = lspStats.map(item => item.certificates_count);

            lspChart.data.labels = labels;
            lspChart.data.datasets[0].data = data;
            lspChart.update('active');
        }

        // Update Business Unit chart
        function updateBusinessUnitChart(businessUnitStats) {
            const labels = businessUnitStats.map(item => item.name);
            const data = businessUnitStats.map(item => item.certificates_count);

            businessUnitChart.data.labels = labels;
            businessUnitChart.data.datasets[0].data = data;
            businessUnitChart.update('active');
        }

        // Update Qualification chart
        function updateQualificationChart(qualificationStats) {
            const labels = qualificationStats.map(item => `${item.name} (${item.lsp_name})`);
            const data = qualificationStats.map(item => item.certificates_count);

            qualificationChart.data.labels = labels;
            qualificationChart.data.datasets[0].data = data;
            qualificationChart.update('active');
        }

        // Refresh charts manually
        function refreshCharts() {
            const refreshBtn = document.querySelector('button[onclick="refreshCharts()"]');
            const originalContent = refreshBtn.innerHTML;

            // Show loading state
            refreshBtn.innerHTML = '<span class="loading-spinner"></span> Refreshing...';
            refreshBtn.disabled = true;

            // Load fresh data
            loadDashboardData();

            // Reset button after 2 seconds
                    setTimeout(() => {
                refreshBtn.innerHTML = originalContent;
                refreshBtn.disabled = false;
                showNotification('Dashboard refreshed successfully!', 'success');
            }, 2000);
        }

        // Animate number counting
        function animateNumber(element, start, end, duration, suffix = '') {
            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= end) {
                    current = end;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current) + suffix;
            }, 16);
        }



        // Show notification
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }



        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + N for new certificate
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                window.location.href = '{{ route('certificate.create') }}';
            }
            
            // Ctrl/Cmd + S for search
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                window.location.href = '{{ route('certificate.search') }}';
            }
            
            // Ctrl/Cmd + R for refresh
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                refreshActivity();
            }
        });

        // Export functions for certificate lists
        function exportExpiringSoonToExcel() {
            if (currentExpiringSoonData.length === 0) {
                alert('{{ __("messages.no_data_to_export") }}');
                return;
            }

            const data = [['{{ __("messages.name") }}', '{{ __("messages.company_name") }}', '{{ __("messages.expiry_date") }}']];

            currentExpiringSoonData.forEach(cert => {
                data.push([
                    cert.full_name || '',
                    cert.company_name || '',
                    cert.expiry_date || ''
                ]);
            });

            exportToExcel(data, '{{ __("messages.certificates_expiring_soon") }}');
        }

        function exportExpiredToExcel() {
            if (currentExpiredData.length === 0) {
                alert('{{ __("messages.no_data_to_export") }}');
                return;
            }

            const data = [['{{ __("messages.name") }}', '{{ __("messages.company_name") }}', '{{ __("messages.expiry_date") }}']];

            currentExpiredData.forEach(cert => {
                data.push([
                    cert.full_name || '',
                    cert.company_name || '',
                    cert.expiry_date || ''
                ]);
            });

            exportToExcel(data, '{{ __("messages.expired_certificates") }}');
        }

        function exportToExcel(data, filename) {
            // Create workbook
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);

            // Set column widths
            ws['!cols'] = [
                { width: 25 }, // Name
                { width: 30 }, // Company
                { width: 15 }  // Expiry Date
            ];

            // Add worksheet to workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            // Generate filename with timestamp
            const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
            const fullFilename = `${filename.replace(/\s+/g, '_')}_${timestamp}.xlsx`;

            // Download file
            XLSX.writeFile(wb, fullFilename);
        }

        // Function to update export button text based on current language
        function updateExportButtonText() {
            const exportButtons = document.querySelectorAll('.export-expiring-btn, .export-expired-btn');
            const exportText = '{{ __("messages.export_excel") }}';
            const iconHtml = '<i class="bi bi-file-earmark-excel me-1"></i>';

            exportButtons.forEach(button => {
                button.innerHTML = iconHtml + exportText;
            });
        }

        // Add smooth scrolling for better UX
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Open modal when clicking notification item
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.open-expiring-modal').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modalEl = document.getElementById('expiringSoonModal');
                    if (modalEl) {
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    }
                });
            });
            document.querySelectorAll('.open-expired-modal').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modalEl = document.getElementById('expiredModal');
                    if (modalEl) {
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    }
                });
            });
        });
    </script>
</body>
</html>

