<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'MikroPay') - Billing System</title>
    
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DASHBOARD ENHANCEMENT CSS -->
    <!-- Hanya di-load di halaman dashboard untuk performa -->
    @if(request()->is('dashboard') || request()->is('/') || request()->routeIs('dashboard*'))
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    @endif
    
    <style>
        :root {
            --primary-color: #1a56db;
            --primary-dark: #1e429f;
            --primary-light: #ebf5ff;
            --secondary-color: #6b7280;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f9fafb;
            --dark-color: #111827;
            --sidebar-width: 260px;
            
            /* Tambahan untuk dashboard enhancement */
            --primary-color-rgb: 26, 86, 219;
            --success-color-rgb: 16, 185, 129;
            --warning-color-rgb: 245, 158, 11;
            --danger-color-rgb: 239, 68, 68;
            --info-color: #0ea5e9;
            --info-color-rgb: 14, 165, 233;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            color: #374151;
            overflow-x: hidden;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            position: fixed;
            height: 100vh;
            padding: 0;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .logo-text {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-menu {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 0.2rem 0.8rem;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .nav-item.active {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: white;
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        /* Top Bar */
        .top-bar {
            background-color: white;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.2rem;
        }
        
        .page-title p {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin: 0;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .notification-btn {
            position: relative;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--secondary-color);
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        /* Cards & Components */
        .stat-card { background: white; border-radius: 15px; padding: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: transform 0.3s; height: 100%; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .stat-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
        .stat-icon.primary { background-color: var(--primary-light); color: var(--primary-color); }
        .stat-icon.success { background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); }
        .stat-icon.warning { background-color: rgba(245, 158, 11, 0.1); color: var(--warning-color); }
        .stat-icon.danger { background-color: rgba(239, 68, 68, 0.1); color: var(--danger-color); }
        .stat-number { font-size: 2rem; font-weight: 700; color: var(--dark-color); line-height: 1; margin-bottom: 0.5rem; }
        .stat-title { color: var(--secondary-color); font-size: 0.9rem; font-weight: 500; }
        
        /* Tables */
        .custom-table { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .custom-table thead { background-color: var(--primary-light); }
        .custom-table th { border: none; padding: 1rem 1.5rem; font-weight: 600; color: var(--dark-color); }
        .custom-table td { padding: 1rem 1.5rem; vertical-align: middle; border-color: #f3f4f6; }
        
        /* Buttons & Badges */
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); padding: 0.5rem 1.5rem; border-radius: 10px; font-weight: 500; }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); border-radius: 10px; font-weight: 500; }
        .btn-outline-primary:hover { background-color: var(--primary-color); border-color: var(--primary-color); }
        
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: 500; display: inline-block; }
        .status-active { background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); }
        .status-pending { background-color: rgba(245, 158, 11, 0.1); color: var(--warning-color); }
        .status-expired { background-color: rgba(239, 68, 68, 0.1); color: var(--danger-color); }
        .status-paid { background-color: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        
        .form-control, .form-select { border-radius: 10px; padding: 0.75rem 1rem; border: 1px solid #d1d5db; }
        .form-control:focus, .form-select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.1); }
        
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
        
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        /* ===== DASHBOARD ENHANCEMENT UTILITY CLASSES ===== */
        /* Background Opacity Utilities */
        .bg-primary-opacity-10 { background-color: rgba(26, 86, 219, 0.1) !important; }
        .bg-success-opacity-10 { background-color: rgba(16, 185, 129, 0.1) !important; }
        .bg-warning-opacity-10 { background-color: rgba(245, 158, 11, 0.1) !important; }
        .bg-danger-opacity-10 { background-color: rgba(239, 68, 68, 0.1) !important; }
        .bg-info-opacity-10 { background-color: rgba(14, 165, 233, 0.1) !important; }
        
        /* Border Opacity Utilities */
        .border-primary-opacity-25 { border-color: rgba(26, 86, 219, 0.25) !important; }
        .border-success-opacity-25 { border-color: rgba(16, 185, 129, 0.25) !important; }
        .border-warning-opacity-25 { border-color: rgba(245, 158, 11, 0.25) !important; }
        .border-danger-opacity-25 { border-color: rgba(239, 68, 68, 0.25) !important; }
        
        /* Animasi tambahan untuk dashboard */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in-up { animation: fadeInUp 0.5s ease forwards; }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .slide-in-left { animation: slideInLeft 0.5s ease forwards; }
        
        /* Hover effect untuk table rows */
        .table-hover-custom tbody tr:hover {
            background-color: rgba(26, 86, 219, 0.03);
        }
        
        /* Dashboard welcome alert khusus */
        .dashboard-welcome-alert {
            background: linear-gradient(135deg, rgba(26, 86, 219, 0.05), rgba(26, 86, 219, 0.1));
            border: 1px solid rgba(26, 86, 219, 0.2);
            border-radius: 15px;
            color: var(--primary-color);
            border-left: 4px solid var(--primary-color);
        }
        
        /* Animation delays untuk grid items */
        .dashboard-grid-delay-1 { animation-delay: 0.1s; }
        .dashboard-grid-delay-2 { animation-delay: 0.2s; }
        .dashboard-grid-delay-3 { animation-delay: 0.3s; }
        .dashboard-grid-delay-4 { animation-delay: 0.4s; }
        .dashboard-grid-delay-5 { animation-delay: 0.5s; }
        .dashboard-grid-delay-6 { animation-delay: 0.6s; }
        
        /* Quick action button styling */
        .quick-action-btn {
            height: 85px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.3s ease;
            border: none;
            color: white;
            text-decoration: none;
        }
        
        .quick-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            color: white;
        }
        
        .quick-action-btn i {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }
        
        .quick-action-btn span {
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        /* Avatar circle */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 600;
        }
        
        .avatar-circle-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        
        /* Dashboard card khusus */
        .dashboard-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .dashboard-card .card-header {
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
            border-radius: 15px 15px 0 0 !important;
        }
        
        .dashboard-card .card-body {
            padding: 1.5rem;
        }
        
        /* Dashboard stat card enhancement */
        .dashboard-stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            border: 1px solid #e5e7eb;
        }
        
        .dashboard-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(26, 86, 219, 0.1);
            border-color: #c7d2fe;
        }
        
        /* Dashboard stat icons */
        .dashboard-stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .dashboard-stat-icon-primary {
            background: linear-gradient(135deg, rgba(26, 86, 219, 0.1), rgba(26, 86, 219, 0.2));
            color: var(--primary-color);
        }
        
        .dashboard-stat-icon-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.2));
            color: var(--success-color);
        }
        
        .dashboard-stat-icon-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.2));
            color: var(--warning-color);
        }
        
        .dashboard-stat-icon-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.2));
            color: var(--danger-color);
        }
        
        .dashboard-stat-icon-info {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(14, 165, 233, 0.2));
            color: var(--info-color);
        }
        
        /* Dashboard stat numbers & titles */
        .dashboard-stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }
        
        .dashboard-stat-title {
            color: var(--secondary-color);
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        /* Dashboard progress bar */
        .dashboard-progress {
            height: 6px;
            background-color: #f1f5f9;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .dashboard-progress .progress-bar {
            border-radius: 3px;
        }
        
        /* Dashboard status badges */
        .dashboard-status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            border: 1px solid transparent;
        }
        
        .dashboard-status-badge i {
            font-size: 8px;
            margin-right: 5px;
        }
        
        /* Dashboard list group */
        .dashboard-list-group .list-group-item {
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 0;
            color: var(--dark-color);
        }
        
        .dashboard-list-group .list-group-item:last-child {
            border-bottom: none;
        }
        
        /* Dashboard table enhancement */
        .dashboard-table {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(0, 0, 0, 0.02);
            --bs-table-hover-bg: rgba(26, 86, 219, 0.03);
            margin-bottom: 0;
        }
        
        .dashboard-table thead th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--secondary-color);
            background-color: var(--primary-light);
            border-bottom: 2px solid #e5e7eb;
            padding: 1rem 1.25rem;
            white-space: nowrap;
        }
        
        .dashboard-table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-color: #f3f4f6;
            color: var(--dark-color);
        }
        
        .dashboard-table tbody tr {
            transition: background-color 0.2s ease;
        }
        
        /* Responsive untuk dashboard components */
        @media (max-width: 768px) {
            .dashboard-stat-card {
                padding: 1.25rem;
            }
            
            .dashboard-stat-icon {
                width: 56px;
                height: 56px;
                margin-bottom: 0.75rem;
            }
            
            .dashboard-stat-icon i {
                font-size: 1.25rem;
            }
            
            .dashboard-stat-number {
                font-size: 1.75rem;
            }
            
            .avatar-circle {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
            
            .dashboard-table thead th,
            .dashboard-table tbody td {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
            
            .quick-action-btn {
                height: 75px;
            }
            
            .quick-action-btn i {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .dashboard-stat-card {
                padding: 1rem;
            }
            
            .dashboard-stat-icon {
                width: 48px;
                height: 48px;
            }
            
            .dashboard-stat-number {
                font-size: 1.5rem;
            }
            
            .dashboard-card .card-header,
            .dashboard-card .card-body {
                padding: 1rem;
            }
            
            .btn-group-stack {
                flex-direction: column;
            }
            
            .btn-group-stack .btn {
                margin-bottom: 0.25rem;
                width: 100%;
            }
        }
        
        /* Print optimization */
        @media print {
            .dashboard-stat-card,
            .dashboard-card {
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
            
            .no-print {
                display: none !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-wifi"></i>
                </div>
                <div class="logo-text">MikroPay</div>
            </div>
        </div>
        
        <div class="nav-menu">
            <div class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="nav-item {{ Request::is('routers*') ? 'active' : '' }}">
                <a href="{{ route('routers.index') }}" class="nav-link">
                    <i class="fas fa-server"></i>
                    <span>Router Mikrotik</span>
                </a>
            </div>
            
            <div class="nav-item {{ Request::is('pelanggan*') ? 'active' : '' }}">
                <a href="{{ route('pelanggan.index') }}" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Pelanggan</span>
                </a>
            </div>
            
            <div class="nav-item {{ Request::is('paket*') ? 'active' : '' }}">
                <a href="{{ route('paket.index') }}" class="nav-link">
                    <i class="fas fa-box"></i>
                    <span>Paket</span>
                </a>
            </div>
            
            <div class="nav-item {{ Request::is('tagihan*') ? 'active' : '' }}">
                <a href="{{ route('tagihan.index') }}" class="nav-link">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Tagihan</span>
                </a>
            </div>
            
            <div class="nav-item {{ Request::is('pembayaran*') ? 'active' : '' }}">
                <a href="{{ route('pembayaran.index') }}" class="nav-link">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Pembayaran</span>
                </a>
            </div>
            
            <div class="nav-item {{ Request::is('laporan*') ? 'active' : '' }}">
                <a href="{{ route('laporan.index') }}" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
            </div>
            
            <div class="nav-item {{ Request::is('pengaturan*') ? 'active' : '' }}">
                <a href="{{ route('pengaturan.index') }}" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </div>
        </div>
    </div>
    
    <div class="main-content" id="mainContent">
        <div class="top-bar">
            <div class="d-flex align-items-center">
                <button class="btn btn-light d-md-none me-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="page-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-subtitle', 'Selamat datang di MikroPay')</p>
                </div>
            </div>
            
            <div class="user-menu">
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                
                <div class="user-profile dropdown">
                    <div class="user-avatar" data-bs-toggle="dropdown">
                        <span>A</span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i> Keluar</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-wrapper fade-in">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('fade');
                    setTimeout(() => {
                        try {
                            if(alert && alert.parentNode) {
                                alert.remove(); 
                            }
                        } catch(e) {
                            console.error(e);
                        }
                    }, 300);
                }, 5000);
            });
            
            // Initialize Bootstrap tooltips jika ada
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Add hover effects to dashboard stat cards jika ada di halaman
            const statCards = document.querySelectorAll('.dashboard-stat-card');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Add hover effects to quick action buttons jika ada
            const quickActionBtns = document.querySelectorAll('.quick-action-btn');
            quickActionBtns.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>