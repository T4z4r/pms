<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flex Workspace - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .wrapper {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #ffffff;
            color: #212529;
            flex-shrink: 0;
            transition: all 0.3s ease;
            border-right: 1px solid #dee2e6;
        }

        .sidebar.collapsed {
            width: 60px;
            overflow: hidden;
        }

        .sidebar.collapsed h4,
        .sidebar.collapsed a span {
            display: none;
        }

        .sidebar.collapsed a {
            justify-content: center;
        }

        .sidebar h4 {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            margin: 0;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sidebar a {
            color: #495057;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: background 0.2s ease, border-color 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #e9ecef;
            color: #212529;
            border-left: 3px solid #0d6efd;
        }

        .sidebar i {
            margin-right: 10px;
        }

        .content {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .alert {
            margin-bottom: 20px;
        }

        .theme-toggle {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .collapse-toggle {
            cursor: pointer;
            padding: 15px 20px;
            text-align: center;
        }

        /* Card styles for light mode */
        .card {
            background-color: #ffffff;
            color: #212529;
            border: 1px solid #dee2e6;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        /* Table styles for light mode */
        .table {
            background-color: #ffffff;
            color: #212529;
            border: 1px solid #dee2e6;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .table.table-bordered th,
        .table.table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table.table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        .table thead,
        .table-light {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr {
            border-bottom: 1px solid #dee2e6;
        }

        /* Badge styles for light mode */
        .badge {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Button styles for light mode */
        .btn {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Modal styles for light mode */
        .modal-content {
            background-color: #ffffff;
            color: #212529;
            border: 1px solid #dee2e6;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .form-control,
        .form-select {
            background-color: #ffffff;
            color: #212529;
            border: 1px solid #ced4da;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #ffffff;
            color: #212529;
            border-color: #86b7fe;
        }

        /* Loader styles */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(248, 249, 250, 0.3); /* Semi-transparent light background */
            backdrop-filter: blur(5px); /* Blur effect */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .loader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #dee2e6;
            border-top: 5px solid #0d6efd;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loader-text {
            margin-top: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #212529;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .dark-mode {
            background-color: #212529;
            color: #fff;
        }

        .dark-mode .sidebar {
            background-color: #212529;
            color: #fff;
            border-right: 1px solid #343a40;
        }

        .dark-mode .sidebar h4 {
            background-color: #343a40;
            color: #fff;
        }

        .dark-mode .sidebar a {
            color: #adb5bd;
        }

        .dark-mode .sidebar a:hover,
        .dark-mode .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }

        .dark-mode .content {
            background-color: #212529;
            color: #fff;
        }

        /* Card styles for dark mode */
        .dark-mode .card {
            background-color: #343a40;
            color: #adb5bd;
            border: 1px solid #495057;
        }

        .dark-mode .card-header {
            background-color: #495057;
            border-bottom: 1px solid #495057;
        }

        .dark-mode .card-footer {
            background-color: #495057;
            border-top: 1px solid #495057;
        }

        /* Table styles for dark mode */
        .dark-mode .table {
            background-color: #343a40;
            color: #adb5bd;
            border: 1px solid #495057;
        }

        .dark-mode .table.table-bordered th,
        .dark-mode .table.table-bordered td {
            border: 1px solid #495057;
        }

        .dark-mode .table.table-hover tbody tr:hover {
            background-color: #495057;
        }

        .dark-mode .table thead,
        .dark-mode .table-light {
            background-color: #495057;
            border-bottom: 1px solid #495057;
        }

        .dark-mode .table tbody tr {
            border-bottom: 1px solid #495057;
        }

        /* Badge styles for dark mode */
        .dark-mode .badge.bg-success {
            background-color: #2e7d32;
        }

        .dark-mode .badge.bg-secondary {
            background-color: #616161;
        }

        .dark-mode .badge.bg-warning {
            background-color: #ff8f00;
            color: #212529;
        }

        /* Button styles for dark mode */
        .dark-mode .btn-info {
            background-color: #0288d1;
            border-color: #0288d1;
        }

        .dark-mode .btn-warning {
            background-color: #ff8f00;
            border-color: #ff8f00;
            color: #212529;
        }

        .dark-mode .btn-danger {
            background-color: #c62828;
            border-color: #c62828;
        }

        .dark-mode .btn-success {
            background-color: #2e7d32;
            border-color: #2e7d32;
        }

        .dark-mode .btn-secondary {
            background-color: #616161;
            border-color: #616161;
        }

        /* Modal styles for dark mode */
        .dark-mode .modal-content {
            background-color: #343a40;
            color: #adb5bd;
            border: 1px solid #495057;
        }

        .dark-mode .modal-header {
            background-color: #495057;
            border-bottom: 1px solid #495057;
        }

        .dark-mode .modal-footer {
            background-color: #495057;
            border-top: 1px solid #495057;
        }

        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: #495057;
            color: #adb5bd;
            border: 1px solid #6c757d;
        }

        .dark-mode .form-control:focus,
        .dark-mode .form-select:focus {
            background-color: #495057;
            color: #adb5bd;
            border-color: #86b7fe;
        }

        .dark-mode .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Loader styles for dark mode */
        .dark-mode .loader {
            background-color: rgba(33, 37, 41, 0.8); /* Semi-transparent dark background */
            backdrop-filter: blur(5px); /* Blur effect */
        }

        .dark-mode .loader-spinner {
            border: 5px solid #495057;
            border-top: 5px solid #0d6efd;
        }

        .dark-mode .loader-text {
            color: #adb5bd;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 1030;
                left: -250px;
                top: 0;
                height: 100%;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                padding: 15px;
            }

            .sidebar-toggle {
                display: inline-block;
                margin: 10px;
            }

            .sidebar.collapsed {
                width: 250px;
            }
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div class="loader" id="loader">
        <div class="loader-spinner"></div>
        <div class="loader-text">Flex Workspace</div>
    </div>

    <nav class="navbar navbar-dark bg-dark d-md-none">
        <div class="container-fluid">
            <button class="btn btn-outline-light sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand">Flex Workspace</span>
        </div>
    </nav>

    <div class="wrapper">
        <div class="sidebar" id="sidebar">
            <h4>Flex Workspace</h4>
            <div class="theme-toggle">
                <span>Theme</span>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="themeSwitch" onchange="toggleTheme()">
                    <label class="form-check-label" for="themeSwitch"></label>
                </div>
            </div>
            <div class="collapse-toggle" onclick="toggleCollapse()">
                <i class="fas fa-chevron-left"></i>
            </div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa fa-home"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <i class="fa fa-project-diagram"></i> <span>Projects</span>
            </a>
            <a href="{{ route('tasks.index') }}" class="{{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                <i class="fa fa-clipboard-list"></i> <span>Task Management</span>
            </a>
            <a href="{{ route('project_types.index') }}"
                class="{{ request()->routeIs('project_types.*') ? 'active' : '' }}">
                <i class="fa fa-list"></i> <span>Project Types</span>
            </a>
            <a href="{{ route('project_priorities.index') }}"
                class="{{ request()->routeIs('project_priorities.*') ? 'active' : '' }}">
                <i class="fa fa-sort"></i> <span>Priorities</span>
            </a>
            <a href="{{ route('project_roles.index') }}"
                class="{{ request()->routeIs('project_roles.*') ? 'active' : '' }}">
                <i class="fa fa-users"></i> <span>Roles</span>
            </a>
            <a href="{{ route('project_tags.index') }}"
                class="{{ request()->routeIs('project_tags.*') ? 'active' : '' }}">
                <i class="fa fa-tags"></i> <span>Tags</span>
            </a>
            <a href="{{ route('ratings.index') }}" class="{{ request()->routeIs('ratings.*') ? 'active' : '' }}">
                <i class="fa fa-star"></i> <span>Ratings</span>
            </a>
            <a href="{{ route('trace_metrics.index') }}"
                class="{{ request()->routeIs('trace_metrics.*') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> <span>Metrics</span>
            </a>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt"></i> <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        }

        function toggleCollapse() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }

        // Load saved theme and sidebar state
        window.onload = function () {
            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
                document.getElementById('themeSwitch').checked = true;
            }
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }

            // Loader logic
            const loader = document.getElementById('loader');
            // Hide loader after 1.5 seconds or when content is loaded
            setTimeout(() => {
                loader.classList.add('hidden');
            }, 1500);
        };
    </script>
</body>

</html>
