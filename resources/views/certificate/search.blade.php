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
            --notification-bg: #fff;
            --notification-border: #dee2e6;
        }
        
        [data-theme="dark"] {
    --bg-color: #0f0f23;
    --sidebar-bg: #121212; /* Ubah dari #1a1a2e menjadi #121212 */
    --text-color: #e0e0e0;
    --card-bg: #1e1e1e; /* Ubah dari #16213e menjadi #1e1e1e untuk kontras dengan sidebar hitam */
    --border-color: rgba(255,255,255,0.125);
    --shadow-color: rgba(0,0,0,0.3);
    --highlight-bg: #333333; /* Ubah dari #0f3460 menjadi #333333 */
    --highlight-color: #5e9eff;
    --input-border: #404040;
    --input-focus: #5e9eff;
    --btn-primary: #5e9eff;
    --btn-primary-hover: #4a7cff;
}
        
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        
        body { 
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: var(--text-color);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        
        [data-theme="dark"] body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 100%);
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
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            max-width: calc(100vw - 250px);
            overflow-x: hidden;
        }

          /* Tambahan style untuk ikon aksi */
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

        .icon-edit {
            background-color: #e6f0ff;
            color: #0d6efd;
        }

        .icon-edit:hover {
            background-color: #d0e2ff;
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

        
        [data-theme="dark"] .main-content {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 100%);
        }
        
        /* Fix for sidebar in dark mode */
        [data-theme="dark"] .sidebar {
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            z-index: 1030;
        }
        
        [data-theme="dark"] .sidebar .nav-link {
            color: var(--text-color);
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
        .card {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.95) 100%);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }
        
        .card-header, .card-footer {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.95) 100%);
            border-color: var(--border-color);
            border-radius: 20px 20px 0 0;
        }
        .table {
            color: var(--text-color);
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            color: #495057;
        }
        
        .table tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        [data-theme="dark"] .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(94, 158, 255, 0.05);
        }
        
        [data-theme="dark"] .table thead th {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%);
            color: #e0e0e0;
        }
        
        [data-theme="dark"] .table tbody tr:hover {
            background: linear-gradient(135deg, rgba(94, 158, 255, 0.1) 0%, rgba(15, 52, 96, 0.1) 100%);
        }
        
        /* Dark Theme Card Enhancements */
        [data-theme="dark"] .card {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(22, 33, 62, 0.9) 100%);
            border-color: rgba(94, 158, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }
        
        [data-theme="dark"] .card-header,
        [data-theme="dark"] .card-footer {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(22, 33, 62, 0.9) 100%);
        }
        
        [data-theme="dark"] .search-container {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(22, 33, 62, 0.95) 100%);
            border-color: rgba(94, 158, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }
        
        [data-theme="dark"] .search-title {
            border-bottom-color: var(--highlight-color);
        }
        /* Modern Button Styling */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
            height: auto;
            line-height: 1.2;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6b90b6 0%, #5a7a9a 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-size: 0.9rem;
        }
        /* Styling khusus untuk modal edit */
.modal-content {
    background: var(--card-bg);
    color: var(--text-color);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

.modal-header {
    border-bottom: 1px solid var(--border-color);
    background: var(--card-bg);
    border-radius: 20px 20px 0 0;
}

.modal-footer {
    border-top: 1px solid var(--border-color);
    background: var(--card-bg);
    border-radius: 0 0 20px 20px;
}

.modal-title {
    color: var(--text-color);
    font-weight: 600;
}

.modal-body .form-label {
    color: var(--text-color);
    font-weight: 500;
}

.modal-body .form-control,
.modal-body .form-select {
    background-color: var(--card-bg);
    color: var(--text-color);
    border: 1px solid var(--border-color);
}

.modal-body .form-control:focus,
.modal-body .form-select:focus {
    background-color: var(--card-bg);
    color: var(--text-color);
    border-color: var(--highlight-color);
    box-shadow: 0 0 0 0.2rem rgba(94, 158, 255, 0.25);
}

/* Untuk memastikan placeholder text juga terlihat */
.modal-body .form-control::placeholder {
    color: rgba(108, 117, 125, 0.7);
}

[data-theme="dark"] .modal-body .form-control::placeholder {
    color: rgba(200, 200, 200, 0.7);
}

/* Styling khusus untuk modal delete */
#deleteConfirmModal .modal-content {
    background: var(--card-bg);
    color: var(--text-color);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

#deleteConfirmModal .modal-header {
    border-bottom: 1px solid var(--border-color);
    background: var(--card-bg);
    border-radius: 20px 20px 0 0;
}

#deleteConfirmModal .modal-footer {
    border-top: 1px solid var(--border-color);
    background: var(--card-bg);
    border-radius: 0 0 20px 20px;
}

#deleteConfirmModal .modal-title {
    color: var(--text-color);
    font-weight: 600;
}

#deleteConfirmModal .modal-body {
    color: var(--text-color);
}

/* Perbaikan khusus untuk tombol delete di modal */
#deleteConfirmModal .btn-delete {
    background: #dc3545;
    color: white !important;
    border: 1.5px solid #dc3545;
}

#deleteConfirmModal .btn-delete:hover {
    background: #bb2d3b;
    color: white !important;
    border-color: #bb2d3b;
}

[data-theme="dark"] #deleteConfirmModal .btn-delete {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white !important;
}

[data-theme="dark"] #deleteConfirmModal .btn-delete:hover {
    background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
    color: white !important;
}
        .btn-outline-secondary {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            height: 36px;
        }
        
        .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
        }
        
        /* Delete Button Specific Styling */
        .btn-delete {
            background: #fff;
            color: #dc3545;
            border: 1.5px solid #dc3545;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            height: 36px;
            line-height: 1;
            min-width: 120px;
        }
        
        .btn-delete:hover {
            background: #ffe6e9;
            color: #bb2d3b;
            border-color: #bb2d3b;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }
        
        /* Search Button Specific Styling */
        .btn-search {
            background: linear-gradient(135deg, #6b90b6 0%, #5a7a9a 100%);
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            height: 40px;
            line-height: 1;
            min-width: 80px;
        }
        
        .btn-search:hover {
            background: linear-gradient(135deg, #5a7a9a 0%, #4d6a8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Edit Button Specific Styling (outlined blue pill like screenshot) */
        .btn-edit {
            background: #fff;
            color: #0d6efd;
            border: 1.5px solid #0d6efd;
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
            height: auto;
            line-height: 1.1;
            min-width: 72px;
            background-clip: padding-box;
        }
        .btn-edit:hover {
            background: #e6f0ff;
            color: #0b5ed7;
            border-color: #0b5ed7;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.25);
        }
        
        /* Form Controls */
        .form-control, .form-select, .form-select-sm {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            height: 38px;
        }
        .form-select, .form-select-sm {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 2.25rem;
        }
        .form-control:focus, .form-select:focus, .form-select-sm:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            outline: 0;
        }
        .form-select-sm {
            padding: 0.25rem 2.25rem 0.25rem 0.75rem;
            font-size: 0.75rem;
        }
        .input-group .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            padding: 0.25rem 0.75rem;
        }
        .input-group .form-control:first-child {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        
        /* Search Form Specific Styling */
        .search-form .form-control {
            height: 40px;
            border-radius: 10px 0 0 10px;
            border-right: none;
        }
        
        .search-form .btn-search {
            border-radius: 0 10px 10px 0;
            height: 40px;
        }
        
        /* Dark Theme Button Enhancements */
        [data-theme="dark"] .btn-primary {
            background: linear-gradient(135deg, #5e9eff 0%, #0f3460 100%);
        }
        
        [data-theme="dark"] .btn-outline-secondary {
            border: 2px solid rgba(94, 158, 255, 0.3);
            color: #e0e0e0;
            background: rgba(94, 158, 255, 0.1);
        }
        
        [data-theme="dark"] .btn-outline-secondary:hover {
            background: rgba(94, 158, 255, 0.2);
            border-color: rgba(94, 158, 255, 0.5);
            color: #e0e0e0;
        }
        
        [data-theme="dark"] .btn-delete {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        
        [data-theme="dark"] .btn-delete:hover {
            background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }
        
        [data-theme="dark"] .btn-search {
            background: linear-gradient(135deg, #5e9eff 0%, #0f3460 100%);
        }
        
        [data-theme="dark"] .btn-search:hover {
            background: linear-gradient(135deg, #4a7cff 0%, #0d2b4d 100%);
        }
        
        [data-theme="dark"] .btn-edit {
            background: transparent;
            color: #5e9eff;
            border: 1.5px solid #5e9eff;
        }
        [data-theme="dark"] .btn-edit:hover {
            background: rgba(94, 158, 255, 0.1);
            color: #4a7cff;
            border-color: #4a7cff;
        }
        
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(94, 158, 255, 0.3);
            color: var(--text-color);
        }
        
        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            border-color: var(--highlight-color);
            box-shadow: 0 0 0 0.2rem rgba(94, 158, 255, 0.15);
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
        .cert-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.13);
            padding: 1.5rem;
            max-width: none;
            margin: 0;
            width: 100%;
            overflow: hidden;
        }
        
        /* Search Container Styling */
        .search-container {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(255, 255, 255, 0.95) 100%);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            max-width: 100%;
            overflow: hidden;
        }
        
        .search-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--highlight-color);
            padding-bottom: 0.75rem;
        }
        
        .filter-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .form-label { font-weight: 500; }
        .form-control, .form-select { border-radius: 8px; }
        .table-responsive {
            overflow-x: auto;
            border-radius: 8px;
            max-width: 100%;
            margin: 0;
        }
        
        .table {
            min-width: 800px;
            font-size: 0.9rem;
            width: 100%;
        }
        
        .table th, .table td {
            padding: 0.75rem 0.5rem;
            white-space: nowrap;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .table th:last-child, .table td:last-child {
            max-width: 120px;
        }
        
        .table th:nth-child(1), .table td:nth-child(1) {
            max-width: 50px;
        }
        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        @media (max-width: 1200px) {
            .cert-card {
                margin: 0.5rem;
                padding: 1rem;
            }
            
            .search-container {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .filter-section {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 0.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            
            .search-container {
                margin: 0.5rem;
                padding: 1rem;
            }
            
            .search-title {
                font-size: 1.5rem;
            }
            
            .filter-section {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .main-content {
                margin-left: 0;
                padding: 0.75rem;
                max-width: 100vw;
            }
            
            .cert-card {
                margin: 0;
                padding: 1rem;
                border-radius: 10px;
            }
            
            .table-responsive {
                font-size: 0.9rem;
            }
        }

        /* Search form styling */
        .search-form {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
        }

        .search-form .form-control,
        .search-form .form-select {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .search-form .form-control:focus,
        .search-form .form-select:focus {
            border-color: var(--highlight-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .search-form .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .search-form .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Loading spinner */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Subtle loading indicator */
        .table tbody tr:last-child .spinner-border-sm {
            opacity: 0.6;
            animation-duration: 0.8s;
        }

        /* Smooth table transitions */
        .table tbody {
            transition: opacity 0.2s ease;
        }

        /* Search input focus effect */
        .search-form .form-control:focus {
            border-color: var(--highlight-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            transform: translateY(-1px);
        }

        /* Table row hover effect */
        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--highlight-bg) !important;
        }

        /* Search input placeholder */
        .search-form .form-control::placeholder {
            color: #6c757d;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <div class="d-flex align-items-center mb-4">
            <img src="/EMP-Logo-removebg-preview.png" alt="Logo" class="logo">
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
                                <button id="themeToggle" type="button" class="nav-link border-0 bg-transparent text-start w-100"> 
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
            <h3 class="fw-bold mb-4">{{ __('messages.search_certificate') }}</h3>
            <form method="GET" action="{{ route('certificate.search') }}" class="mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" 
                                   name="q" 
                                   id="searchInput" 
                                   class="form-control" 
                                   placeholder="{{ __('messages.search_placeholder') }}" 
                                   value="{{ request('q') }}"
                                   style="height: 38px; border-radius: 0.25rem 0 0 0.25rem;">
                            <button type="submit" class="btn btn-primary" style="height: 38px;">
                                <i class="bi bi-search"></i> {{ __('messages.search') }}
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="lsp" class="form-select form-select-sm" id="lsp" style="height: 38px;">
                            <option value="">{{ __('messages.all') }} {{ __('messages.lsp') }}</option>
                            @foreach($lsps ?? [] as $lspItem)
                                <option value="{{ $lspItem->name }}" {{ request('lsp') == $lspItem->name ? 'selected' : '' }}>{{ $lspItem->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="business_unit" class="form-select form-select-sm" id="business_unit" style="height: 38px;">
                            <option value="">{{ __('messages.all') }} {{ __('messages.company_name') }}</option>
                            @foreach($businessUnits ?? [] as $unit)
                                <option value="{{ $unit->name }}" {{ request('business_unit') == $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="qualification" class="form-select form-select-sm" id="qualification" style="height: 38px;">
                            <option value="">{{ __('messages.all') }} {{ __('messages.qualification') }}</option>
                            @foreach($qualifications ?? [] as $qual)
                                <option value="{{ $qual->name }}" {{ request('qualification') == $qual->name ? 'selected' : '' }}>{{ $qual->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <select name="status" class="form-select form-select-sm" id="status" style="height: 38px;">
                            <option value="">{{ __('messages.all') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('messages.valid') }}</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('messages.expired') }}</option>
                            <option value="expiring" {{ (request('status') == 'expiring' || request('status') == 'expiring_soon') ? 'selected' : '' }}>{{ __('messages.expiring_soon') }}</option>
                </select>
                    </div>
                    <div class="col-md-1">
                        <select name="sort" class="form-select form-select-sm" id="sort" style="height: 38px;">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>{{ __('messages.newest') }}</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>{{ __('messages.oldest') }}</option>
                </select>
                    </div>
                </div>
            </form>
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif


            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="certTable" style="font-size:1.1rem;">
                    <thead>
                        <tr>
                            <th style="min-width:200px;">{{ __('messages.name') }}</th>
                            <th style="min-width:250px;">{{ __('messages.company_name') }}</th>
                            <th style="min-width:160px;">{{ __('messages.qualification') }}</th>
                            <th style="min-width:160px;">{{ __('messages.lsp') }}</th>
                            <th style="min-width:200px;">{{ __('messages.registration_number') }}</th>
                            <th style="min-width:120px;">{{ __('messages.issued_date') }}</th>
                            <th style="min-width:120px;">{{ __('messages.valid_until') }}</th>
                            <th style="min-width:110px;">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody id="certTableBody">
                        @forelse($certificates ?? [] as $i => $cert)
                            <tr>
                                <td>{{ $cert->full_name ?? '-' }}</td>
                                <td>{{ $cert->company_name ?? '-' }}</td>
                                <td>{{ $cert->qualification ?? '-' }}</td>
                                <td>{{ $cert->lsp ?? '-' }}</td>
                                <td>{{ $cert->certificate_registration_number ?? '-' }}</td>
                                <td>{{ $cert->issue_date ? (is_string($cert->issue_date) ? \Carbon\Carbon::parse($cert->issue_date)->format('d-M-y') : $cert->issue_date->format('d-M-y')) : '-' }}</td>
                                <td
                                    @php
                                        $expiry = $cert->expiry_date ? \Carbon\Carbon::parse($cert->expiry_date) : null;
                                        $now = \Carbon\Carbon::now();
                                        $color = '';
                                        if ($expiry) {
                                            if ($expiry->isPast()) {
                                                $color = 'color:#b30000;font-weight:bold;'; // Red font only
                                            } elseif ($expiry->isFuture() && $expiry->lte($now->copy()->addMonths(3))) {
                                                $color = 'color:#856404;font-weight:bold;'; // Yellow font only
                                            } else {
                                                $color = 'color:#155724;font-weight:bold;'; // Green font only
                                            }
                                        }
                                    @endphp
                                    style="{{ $color }}"
                                >
                                    @php
                                        try {
                                            echo $cert->expiry_date ? \Carbon\Carbon::parse($cert->expiry_date)->format('d-M-y') : '-';
                                        } catch (\Exception $e) {
                                            echo $cert->expiry_date ?? '-';
                                        }
                                    @endphp
                                </td>
                                <td class="text-center">
                                    <div class="action-icons">
                                        @if(!empty($cert->file_path))
                                            <a href="{{ asset('storage/' . $cert->file_path) }}" target="_blank" class="action-icon icon-view" title="{{ __('messages.view') }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ asset('storage/' . $cert->file_path) }}" download class="action-icon icon-download" title="{{ __('messages.download') }}">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @endif
                                        <button type="button" class="action-icon icon-edit" 
                                            data-id="{{ $cert->id }}"
                                            data-full_name="{{ $cert->full_name }}"
                                            data-company_name="{{ $cert->company_name }}"
                                            data-qualification="{{ $cert->qualification }}"
                                            data-lsp="{{ $cert->lsp }}"
                                            data-registration="{{ $cert->certificate_registration_number }}"
                                            data-issue_date="{{ $cert->issue_date }}"
                                            data-expiry_date="{{ $cert->expiry_date }}"
                                            data-bs-toggle="modal" data-bs-target="#editCertificateModal"
                                            onclick="openEdit(this)" title="{{ __('messages.edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="action-icon icon-delete" 
                                            data-id="{{ $cert->id }}" 
                                            data-action="{{ route('certificate.destroy', $cert) }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteConfirmModal" 
                                            onclick="openDelete(this)" 
                                            title="{{ __('messages.delete') }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="text-center">{{ __('messages.no_certificates_found') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editCertificateModal" tabindex="-1" aria-labelledby="editCertificateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCertificateModalLabel">{{ __('messages.edit_certificate') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCertificateForm" method="POST" enctype="multipart/form-data" data-update-action="{{ route('certificate.update.post') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="certificate_id" id="edit_certificate_id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_full_name" class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" class="form-control" id="edit_full_name" name="full_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_company_name" class="form-label">{{ __('messages.company_name') }}</label>
                                <select class="form-select" id="edit_company_name" name="company_name">
                                    <option value="">Select Business Unit</option>
                                    @foreach($businessUnits as $businessUnit)
                                        <option value="{{ $businessUnit->name }}">{{ $businessUnit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_qualification" class="form-label">{{ __('messages.qualification') }}</label>
                                <select class="form-select" id="edit_qualification" name="qualification">
                                    <option value="">Select Qualification</option>
                                    @foreach($qualifications as $qualification)
                                        <option value="{{ $qualification->name }}">{{ $qualification->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_lsp" class="form-label">{{ __('messages.lsp') }}</label>
                                <select class="form-select" id="edit_lsp" name="lsp">
                                    <option value="">Select LSP</option>
                                    @foreach($lsps as $lsp)
                                        <option value="{{ $lsp->name }}">{{ $lsp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_certificate_registration_number" class="form-label">{{ __('messages.registration_number') }}</label>
                                <input type="text" class="form-control" id="edit_certificate_registration_number" name="certificate_registration_number">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_issue_date" class="form-label">{{ __('messages.issued_date') }}</label>
                                <input type="date" class="form-control" id="edit_issue_date" name="issue_date">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_expiry_date" class="form-label">{{ __('messages.valid_until') }}</label>
                                <input type="date" class="form-control" id="edit_expiry_date" name="expiry_date">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_certificate_file" class="form-label">{{ __('messages.certificate_file') }} (PDF)</label>
                                <input type="file" class="form-control" id="edit_certificate_file" name="certificate_file" accept=".pdf">
                                <small class="text-muted">{{ __('messages.leave_blank_to_keep_existing_file') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this task?
                    <input type="hidden" id="delete_target_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="#">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-delete" id="confirmDeleteBtn">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
// Fungsi untuk membuka modal edit
window.openEdit = function(btn) {
    try {
        const certificateId = btn.getAttribute('data-id');
        const modalEl = document.getElementById('editCertificateModal');
        const editForm = document.getElementById('editCertificateForm');
        
        // Ambil data dari atribut data
        document.getElementById('edit_certificate_id').value = certificateId;
        document.getElementById('edit_full_name').value = btn.getAttribute('data-full_name') || '';
        document.getElementById('edit_company_name').value = btn.getAttribute('data-company_name') || '';
        document.getElementById('edit_qualification').value = btn.getAttribute('data-qualification') || '';
        document.getElementById('edit_lsp').value = btn.getAttribute('data-lsp') || '';
        document.getElementById('edit_certificate_registration_number').value = btn.getAttribute('data-registration') || '';
        
        // Format tanggal dengan benar
        const formatDateForInput = (dateString) => {
            if (!dateString) return '';
            try {
                const date = new Date(dateString);
                return date.toISOString().split('T')[0];
            } catch (e) {
                return dateString;
            }
        };
        
        document.getElementById('edit_issue_date').value = formatDateForInput(btn.getAttribute('data-issue_date'));
        document.getElementById('edit_expiry_date').value = formatDateForInput(btn.getAttribute('data-expiry_date'));
        
        // Set action form dengan route yang benar
        editForm.action = "{{ route('certificate.update.post') }}";
        
        // Tampilkan modal
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    } catch (err) {
        console.error('Error opening edit modal:', err);
        alert('Terjadi error saat membuka form edit');
    }
};

// Handle form submission
document.getElementById('editCertificateForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    try {
        // Tampilkan loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
        
        // Pastikan certificate_id ada dalam formData
        const certificateId = document.getElementById('edit_certificate_id').value;
        formData.append('certificate_id', certificateId);
        
        // Kirim data ke server
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Tampilkan pesan sukses
            alert('Data berhasil disimpan!');
            
            // Tutup modal dan reload halaman
            const modal = bootstrap.Modal.getInstance(document.getElementById('editCertificateModal'));
            modal.hide();
            
            // Reload halaman setelah 1 detik
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            // Tampilkan error validasi
            let errorMessage = 'Terjadi kesalahan saat menyimpan data';
            if (data.errors) {
                errorMessage = Object.values(data.errors).join('\n');
            } else if (data.message) {
                errorMessage = data.message;
            }
            alert(errorMessage);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
    } finally {
        // Kembalikan state button
        submitButton.disabled = false;
        submitButton.innerHTML = originalText;
    }
});

// Pastikan CSRF token ditambahkan ke header semua request AJAX
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Set header default untuk Axios
    if (typeof axios !== 'undefined') {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    }
    
    // Set header default untuk Fetch API
    if (typeof fetch !== 'undefined') {
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            if (args[1] && args[1].headers) {
                args[1].headers['X-CSRF-TOKEN'] = csrfToken;
            } else if (args[1]) {
                args[1].headers = {
                    'X-CSRF-TOKEN': csrfToken
                };
            }
            return originalFetch.apply(this, args);
        };
    }
});


// Global openDelete to show Bootstrap confirm modal then submit form
window.openDelete = function(btn) {
    try {
        const id = btn && btn.getAttribute('data-id');
        if (!id) return;
        
        // Dapatkan action dari data-action attribute
        const action = btn.getAttribute('data-action') || `/certificate/${id}`;
        
        // Set form action dan tampilkan modal
        const deleteForm = document.getElementById('deleteForm');
        if (deleteForm) {
            deleteForm.action = action;
            
            // Tampilkan modal confirm
            const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            modal.show();
        }
    } catch (err) {
        console.error('openDelete error:', err);
    }
}

// Handle form delete submission
document.getElementById('deleteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Submit form secara normal
    this.submit();
});

// Alternatif: handle delete tanpa modal (langsung confirm)
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-btn-direct')) {
        e.preventDefault();
        const id = e.target.getAttribute('data-id');
        const action = e.target.getAttribute('data-action') || `/certificate/${id}`;
        
        if (confirm('Are you sure to delete this certificate?')) {
            // Buat form dan submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = action;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
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

</script>
</body>
</html>