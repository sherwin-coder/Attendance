<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Student Tasks | Smart QR Attendance</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ===== MAIN LAYOUT CONTAINER ===== */
        .container-scroller {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== SIDEBAR ===== */
        aside.sidebar {
            width: 260px;
            background: linear-gradient(180deg, #4B49AC 0%, #3a3899 100%);
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
        }

        .sidebar-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
            min-height: 70px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .sidebar-logo img {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .sidebar-logo-text {
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .sidebar-logo-text .brand {
            font-weight: 700;
            font-size: 18px;
            line-height: 1;
            color: white;
            transition: all 0.3s ease;
        }

        .sidebar-logo-text .system {
            font-size: 11px;
            opacity: 0.8;
            margin-top: 2px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        /* ===== SIDEBAR NAVIGATION ===== */
        .sidebar-nav {
            flex: 1;
            padding: 15px 0;
            overflow-y: auto;
            overflow-x: hidden;
            transition: all 0.3s ease;
        }

        .nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin: 4px 12px;
            transition: all 0.3s ease;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px !important;
            color: rgba(255, 255, 255, 0.9) !important;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 3px solid transparent;
            white-space: nowrap;
            min-height: 44px;
            background: transparent;
            position: relative;
            overflow: hidden;
        }

        /* Hover animation with scale and slide effect - ONLY for non-active items */
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: white !important;
            border-left-color: #FFD54F;
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        /* Active state with stronger animation - NO hover effect on active items */
        .nav-item.active .nav-link {
            background: linear-gradient(135deg, #FFFFFF, #F5F5F5) !important;
            color: #2c3e50 !important;
            border-left-color: #4B49AC;
            font-weight: 600;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            transform: translateX(8px) scale(1.03);
        }

        /* DISABLE hover effects for active items */
        .nav-item.active .nav-link:hover {
            background: linear-gradient(135deg, #FFFFFF, #F5F5F5) !important;
            color: #2c3e50 !important;
            border-left-color: #4B49AC;
            transform: translateX(8px) scale(1.03);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            backdrop-filter: none;
        }

        .nav-item.active .nav-link .menu-icon {
            color: #4B49AC !important;
            transform: scale(1.1);
        }

        .menu-icon {
            font-size: 1.3rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .menu-title {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            overflow: hidden;
            font-weight: 500;
        }

        /* Active state icon colors */
        .nav-item.active .menu-icon {
            color: #4B49AC !important;
            transform: scale(1.1);
        }

        /* Hover state - both icon and text stay white with animations - ONLY for non-active */
        .nav-link:hover .menu-icon {
            color: white !important;
            transform: scale(1.1) rotate(5deg);
        }

        .nav-link:hover .menu-title {
            color: white !important;
            transform: translateX(2px);
        }

        /* DISABLE hover animations for active items */
        .nav-item.active .nav-link:hover .menu-icon {
            color: #4B49AC !important;
            transform: scale(1.1);
            rotate: 0deg;
        }

        .nav-item.active .nav-link:hover .menu-title {
            color: #2c3e50 !important;
            transform: translateX(0);
        }

        /* ===== SIDEBAR TOGGLE BUTTON ===== */
        .sidebar-toggle {
            padding: 15px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar-toggle-btn {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            border-radius: 8px;
            width: 100%;
            padding: 10px 15px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .toggle-text {
            font-size: 14px;
            font-weight: 500;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .toggle-icon {
            font-size: 1.2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-toggle-btn:hover .toggle-icon {
            transform: translateX(3px);
        }

        /* ===== SIDEBAR MINIMIZED STATE ===== */
        .sidebar.minimized {
            width: 70px !important;
        }

        .sidebar.minimized .menu-title {
            opacity: 0;
            visibility: hidden;
            width: 0;
            margin: 0;
            transition: all 0.3s ease;
        }

        .sidebar.minimized .sidebar-logo-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
            height: 0;
            transition: all 0.3s ease;
        }

        .sidebar.minimized .sidebar-logo {
            justify-content: center;
        }

        .sidebar.minimized .sidebar-logo img {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        .sidebar.minimized .nav-link {
            padding: 12px !important;
            justify-content: center;
        }

        .sidebar.minimized .nav-link:hover {
            transform: scale(1.15) !important;
            background: rgba(255, 255, 255, 0.2) !important;
            backdrop-filter: blur(10px);
        }

        .sidebar.minimized .nav-item.active .nav-link {
            background: linear-gradient(135deg, #FFFFFF, #F5F5F5) !important;
            color: #2c3e50 !important;
            transform: scale(1.15) !important;
        }

        /* DISABLE hover effects for active items in minimized state */
        .sidebar.minimized .nav-item.active .nav-link:hover {
            background: linear-gradient(135deg, #FFFFFF, #F5F5F5) !important;
            color: #2c3e50 !important;
            transform: scale(1.15) !important;
            backdrop-filter: none;
        }

        .sidebar.minimized .menu-icon {
            margin-right: 0;
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.minimized .nav-item.active .menu-icon {
            color: #4B49AC !important;
            transform: scale(1.2);
        }

        .sidebar.minimized .nav-link:hover .menu-icon {
            color: white !important;
            transform: scale(1.2) rotate(8deg);
        }

        /* DISABLE hover animations for active items in minimized state */
        .sidebar.minimized .nav-item.active .nav-link:hover .menu-icon {
            color: #4B49AC !important;
            transform: scale(1.2);
            rotate: 0deg;
        }

        .sidebar.minimized .sidebar-header {
            padding: 20px 15px;
            justify-content: center;
        }

        .sidebar.minimized .sidebar-nav {
            padding: 10px 0;
        }

        .sidebar.minimized .nav-item {
            margin: 6px 8px;
        }

        .sidebar.minimized .toggle-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        .sidebar.minimized .sidebar-toggle-btn {
            justify-content: center;
            padding: 10px;
        }

        .sidebar.minimized .sidebar-toggle {
            padding: 10px 15px;
        }

        .sidebar.minimized .toggle-icon {
            transform: rotate(180deg);
        }

        /* ===== NAVBAR ===== */
        .navbar {
            height: 70px;
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
            width: 100%;
        }

        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 100%;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .navbar-title {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .navbar-right {
            display: flex;
            align-items: center;
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .user-dropdown-toggle:hover {
            background: rgba(0, 0, 0, 0.05) !important;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .user-dropdown-toggle:hover .user-avatar {
            transform: scale(1.1);
        }

        .dropdown-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .dropdown-menu {
            position: absolute;
            left: auto !important;
            right: 0 !important;
            top: 100%;
            background: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            min-width: 200px;
            padding: 0;
            margin-top: 10px;
            z-index: 1000;
            transform: translateY(-10px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .user-dropdown:hover .dropdown-menu {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .dropdown-header {
            padding: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .dropdown-item {
            padding: 12px 20px;
            color: #2c3e50;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .dropdown-item:hover {
            background: #f8f9fa !important;
            color: #2c3e50 !important;
            transform: translateX(5px);
        }

        .dropdown-item:hover i {
            transform: scale(1.2);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 0;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-wrapper {
            padding: 30px;
            min-height: calc(100vh - 140px);
        }

        /* ===== TABLE STYLES ===== */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 0;
        }

        .table th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            border-bottom: 2px solid #eaeaea;
            padding: 15px;
            font-size: 0.95rem;
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid #eaeaea;
            vertical-align: middle;
            color: #495057;
            font-size: 0.90rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(75, 73, 172, 0.05);
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }

        /* ===== MODERN CARD DESIGN ===== */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            background: white !important;
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12) !important;
            transform: translateY(-5px) scale(1.01) !important;
        }

        .card-header {
            background: white !important;
            border-bottom: 1px solid #eaeaea !important;
            padding: 25px 30px !important;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-title {
            color: #2c3e50 !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
            margin-bottom: 5px !important;
        }

        .card-subtitle {
            color: #6c757d !important;
            font-size: 0.95rem !important;
        }

        .card-body {
            padding: 30px !important;
        }

        /* ===== FORM STYLES ===== */
        .form-group {
            margin-bottom: 1.5rem !important;
        }

        .form-label {
            font-weight: 600 !important;
            color: #2c3e50 !important;
            margin-bottom: 8px !important;
            font-size: 0.95rem !important;
        }

        .form-control {
            border: 1.5px solid #e9ecef !important;
            border-radius: 8px !important;
            padding: 12px 15px !important;
            font-size: 0.95rem !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .form-control:focus {
            border-color: #4B49AC !important;
            box-shadow: 0 0 0 3px rgba(75, 73, 172, 0.1) !important;
            transform: translateY(-2px);
        }

        .input-group-text {
            background: #f8f9fa !important;
            border: 1.5px solid #e9ecef !important;
            color: #6c757d !important;
            transition: all 0.3s ease !important;
        }

        /* ===== BUTTON STYLES ===== */
        .btn {
            border-radius: 8px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border: none !important;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4B49AC, #3a3899) !important;
            box-shadow: 0 4px 15px rgba(75, 73, 172, 0.3) !important;
        }

        .btn-primary:hover {
            transform: translateY(-3px) scale(1.05) !important;
            box-shadow: 0 8px 25px rgba(75, 73, 172, 0.4) !important;
        }

        .btn-light {
            background: #f8f9fa !important;
            color: #6c757d !important;
            border: 1.5px solid #e9ecef !important;
        }

        .btn-light:hover {
            background: #e9ecef !important;
            color: #2c3e50 !important;
            transform: translateY(-2px) scale(1.05) !important;
        }

        /* ===== ALERT STYLES ===== */
        .alert {
            border-radius: 8px !important;
            border: none !important;
            padding: 15px 20px !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
        }

        /* ===== FOOTER ===== */
        .footer {
            background: white !important;
            border-top: 1px solid #eaeaea !important;
            padding: 20px 30px !important;
            margin-top: auto !important;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                height: 100vh;
                z-index: 1000;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .sidebar.active {
                left: 0;
            }

            .mobile-toggle-btn {
                display: flex !important;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1001;
                background: #4B49AC;
                color: white;
                border: none;
                border-radius: 8px;
                width: 45px;
                height: 45px;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 3px 10px rgba(75, 73, 172, 0.3);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .mobile-toggle-btn:hover {
                transform: scale(1.1);
                box-shadow: 0 5px 15px rgba(75, 73, 172, 0.4);
            }

            .navbar {
                padding: 0 20px !important;
            }

            .navbar-title {
                font-size: 18px !important;
            }

            .content-wrapper {
                padding: 20px !important;
            }
        }

        @media (min-width: 992px) {
            .mobile-toggle-btn {
                display: none !important;
            }
        }

        /* Hide scrollbar for sidebar */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Override Bootstrap styles */
        .container-scroller .row {
            margin: 0 !important;
        }

        .container-scroller .col-lg-12 {
            padding: 0 !important;
        }

        .container-scroller .pt-3 {
            padding-top: 1rem !important;
        }

        .container-scroller .mt-4 {
            margin-top: 1.5rem !important;
        }

        .container-scroller .me-3 {
            margin-right: 1rem !important;
        }

        .container-scroller .me-2 {
            margin-right: 0.5rem !important;
        }

        .container-scroller .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .container-scroller .text-muted {
            color: #6c757d !important;
        }

        .container-scroller .fw-semibold {
            font-weight: 600 !important;
        }

        .container-scroller .fw-light {
            font-weight: 300 !important;
        }

        .container-scroller .text-primary {
            color: #4B49AC !important;
        }

        .container-scroller .d-sm-flex {
            display: flex !important;
        }

        .container-scroller .justify-content-center {
            justify-content: center !important;
        }

        .container-scroller .justify-content-sm-between {
            justify-content: space-between !important;
        }

        .container-scroller .d-block {
            display: block !important;
        }

        .container-scroller .d-sm-inline-block {
            display: inline-block !important;
        }

        .container-scroller .float-none {
            float: none !important;
        }

        .container-scroller .float-sm-end {
            float: right !important;
        }

        .container-scroller .mt-1 {
            margin-top: 0.25rem !important;
        }

        .container-scroller .mt-sm-0 {
            margin-top: 0 !important;
        }

        .container-scroller .text-center {
            text-align: center !important;
        }

        /* Ensure proper spacing */
        .navbar-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Remove Bootstrap container padding */
        .container-scroller .container,
        .container-scroller .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <div class="sidebar-logo">
                        <img src="{{ asset('assets/images/smart-icon.jpg') }}" alt="Logo">
                        <div class="sidebar-logo-text">
                            <span class="brand">Smart QR</span>
                            <span class="system">Attendance System</span>
                        </div>
                    </div>
                </div>
                <nav class="sidebar-nav">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin_dashboard') }}">
                                <i class="mdi mdi-view-dashboard menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('students.index') }}">
                                <i class="mdi mdi-account-group menu-icon"></i>
                                <span class="menu-title">Student Records</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('attendance.logs') }}">
                                <i class="mdi mdi-calendar-check menu-icon"></i>
                                <span class="menu-title">Attendance Logs</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('subjects.index') }}">
                                <i class="mdi mdi-book-plus menu-icon"></i>
                                <span class="menu-title">Subjects</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('actquiz') }}">
                                <i class="mdi mdi-clipboard-text menu-icon"></i>
                                <span class="menu-title">Student Tasks</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('newadmin') }}">
                                <i class="mdi mdi-cog menu-icon"></i>
                                <span class="menu-title">Admin Settings</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- ===== SIDEBAR TOGGLE BUTTON ===== -->
                <div class="sidebar-toggle">
                    <button class="sidebar-toggle-btn" id="sidebarToggle">
                        <span class="toggle-text">Collapse Menu</span>
                        <i class="mdi mdi-arrow-left toggle-icon"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT WRAPPER ===== -->
        <div class="navbar-wrapper">
            <!-- ===== NAVBAR ===== -->
            <nav class="navbar">
                <div class="navbar-content">
                    <div class="navbar-left">
                        <h4 class="navbar-title">Smart Student Attendance System</h4>
                    </div>
                    <div class="navbar-right">
                        <div class="user-dropdown">
                            <a class="user-dropdown-toggle" id="UserDropdown" href="#" data-bs-toggle="dropdown">
                                <img class="user-avatar" src="{{ asset('assets/images/faces/face8.jpg') }}"
                                    alt="Profile image">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="UserDropdown">
                                <div class="dropdown-header text-center">
                                    <img class="dropdown-avatar" src="{{ asset('assets/images/faces/face8.jpg') }}"
                                        alt="Profile image">
                                    <p class="mb-1 fw-semibold">Admin</p>
                                    <p class="fw-light text-muted mb-0">admin@attendance.com</p>
                                </div>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                        class="mdi mdi-account-outline me-2 text-primary"></i>Profile</a>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a href="#" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="mdi mdi-logout me-2 text-primary"></i> Logout
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- ===== MAIN CONTENT ===== -->
            <main class="main-content">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="card-title fw-bold text-dark">Student Tasks</h4>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addTaskModal">
                                            <i class="mdi mdi-plus"></i> Add Task
                                        </button>
                                    </div>

                                    <!-- Subject Filter -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Filter by Subject</label>
                                        <select class="form-select" id="subjectFilter">
                                            <option selected disabled>Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->code }}">
                                                    {{ $subject->code }} - {{ $subject->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Task Table -->
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Task Title</th>
                                                    <th>Type</th>
                                                    <th>Subject</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="taskTableBody">
                                                @foreach ($tasks as $task)
                                                    <tr data-id="{{ $task->id }}">
                                                        <td>{{ $task->title }}</td>
                                                        <td>{{ $task->type }}</td>
                                                        <td>{{ $task->subject_code }} - {{ $task->subject->name ?? '' }}
                                                        </td>
                                                        <td>{{ $task->due_date }}</td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $task->status == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                                {{ $task->status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-1">
                                                                <button class="btn btn-sm btn-info view-btn"
                                                                    data-id="{{ $task->id }}" data-mode="view"
                                                                    data-bs-toggle="modal" data-bs-target="#scoreModal">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </button>

                                                                <button class="btn btn-sm btn-warning edit-btn"
                                                                    data-id="{{ $task->id }}" data-mode="edit"
                                                                    data-bs-toggle="modal" data-bs-target="#scoreModal">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </button>

                                                                <form action="{{ route('tasks.destroy', $task->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Delete this task?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-sm btn-danger">
                                                                        <i class="mdi mdi-delete"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block d-sm-inline-block">
                            © {{ date('Y') }} Smart Student Attendance System. All Rights Reserved.
                        </span>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="Quiz">Quiz</option>
                                <option value="Activity">Activity</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <select name="subject_code" class="form-select" required>
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->code }}">
                                        {{ $subject->code }} - {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Score Modal -->
    <div class="modal fade" id="scoreModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="scoreForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Task Scores</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="taskId">

                        <!-- Add Record Button (only visible in Edit mode) -->
                        <div id="addRecordContainer" class="mb-3" style="display: none;">
                            <button type="button" id="addRecordBtn" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-plus"></i> Add Student Record
                            </button>
                        </div>

                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody id="scoreTableBody">
                                <tr>
                                    <td colspan="2" class="text-center">Loading...</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Hidden New Record Form -->
                        <div id="newRecordForm" class="border p-3 rounded bg-white mt-3" style="display: none;">
                            <h6 class="fw-bold mb-3">Add New Student Record</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Select Student</label>
                                    <select id="newStudentSelect" class="form-select" style="color: black;">
                                        <option value="">-- Choose Student --</option>
                                        @foreach(App\Models\User::all() as $student)
                                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="form-label">Score</label>
                                    <input type="number" id="newStudentScore" class="form-control" min="0" max="100">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" id="saveNewRecordBtn" class="btn btn-success w-100">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="markCompleteBtn" class="btn btn-success">Mark as Completed</button>
                        <button type="submit" id="saveScoresBtn" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Files -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Desktop sidebar toggle functionality
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function () {
                    sidebar.classList.toggle('minimized');
                    updateToggleButton();
                });
            }

            // Update toggle button text and icon based on sidebar state
            function updateToggleButton() {
                if (sidebarToggle) {
                    const toggleText = sidebarToggle.querySelector('.toggle-text');
                    const toggleIcon = sidebarToggle.querySelector('.toggle-icon');

                    if (sidebar.classList.contains('minimized')) {
                        toggleText.textContent = 'Expand Menu';
                        toggleIcon.className = 'mdi mdi-arrow-right toggle-icon';
                    } else {
                        toggleText.textContent = 'Collapse Menu';
                        toggleIcon.className = 'mdi mdi-arrow-left toggle-icon';
                    }
                }
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (event) {
                if (window.innerWidth < 992) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnMobileToggle = mobileToggle.contains(event.target);

                    if (!isClickInsideSidebar && !isClickOnMobileToggle && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    }
                }
            });

            // Initialize toggle button on page load
            updateToggleButton();

            // Existing task management JavaScript
            const csrfToken = '{{ csrf_token() }}';

            // Filter tasks by subject
            document.getElementById('subjectFilter').addEventListener('change', function () {
                const code = this.value;
                fetch(`/tasks/filter?subject_code=${code}`)
                    .then(res => res.json())
                    .then(tasks => {
                        const tbody = document.getElementById('taskTableBody');
                        tbody.innerHTML = '';
                        if (tasks.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No tasks found</td></tr>';
                            return;
                        }
                        tasks.forEach(task => {
                            tbody.innerHTML += `
                        <tr data-id="${task.id}">
                            <td>${task.title}</td>
                            <td>${task.type}</td>
                            <td>${task.subject_code}</td>
                            <td>${task.due_date}</td>
                            <td><span class="badge ${task.status === 'Completed' ? 'bg-success' : 'bg-warning text-dark'}">${task.status}</span></td>
                            <td>
                                <button class="btn btn-sm btn-info view-btn" data-id="${task.id}" data-mode="view" data-bs-toggle="modal" data-bs-target="#scoreModal"><i class="mdi mdi-eye"></i></button>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="${task.id}" data-mode="edit" data-bs-toggle="modal" data-bs-target="#scoreModal"><i class="mdi mdi-pencil"></i></button>
                            </td>
                        </tr>`;
                        });
                    });
            });

            const scoreTableBody = document.getElementById('scoreTableBody');
            const saveScoresBtn = document.getElementById('saveScoresBtn');
            const markCompleteBtn = document.getElementById('markCompleteBtn');
            const addRecordContainer = document.getElementById('addRecordContainer');
            let currentMode = 'view';

            // Open modal (view or edit)
            document.addEventListener('click', e => {
                if (e.target.closest('.view-btn') || e.target.closest('.edit-btn')) {
                    const btn = e.target.closest('button');
                    const taskId = btn.dataset.id;
                    currentMode = btn.dataset.mode;
                    document.getElementById('taskId').value = taskId;

                    document.querySelector('#scoreModal .modal-title').textContent =
                        currentMode === 'view' ? 'View Scores' : 'Edit Scores';
                    saveScoresBtn.style.display = currentMode === 'edit' ? 'inline-block' : 'none';
                    addRecordContainer.style.display = currentMode === 'edit' ? 'block' : 'none';

                    fetch(`/tasks/${taskId}/scores`)
                        .then(res => res.json())
                        .then(data => {
                            const scores = data.scores || [];
                            if (!scores.length) {
                                scoreTableBody.innerHTML =
                                    '<tr><td colspan="2" class="text-center">No student records found.</td></tr>';
                                return;
                            }
                            scoreTableBody.innerHTML = scores.map(s => `
                        <tr>
                            <td>${s.user?.name ?? 'Unknown Student'}</td>
                            <td>${currentMode === 'edit'
                                    ? `<input type="number" class="form-control score-input" data-user="${s.user_id}" value="${s.score ?? ''}" min="0" max="100">`
                                    : (s.score ?? '-')
                                }</td>
                        </tr>`).join('');
                        })
                        .catch(err => {
                            console.error('Error fetching scores:', err);
                            scoreTableBody.innerHTML =
                                '<tr><td colspan="2" class="text-center text-danger">Failed to load scores.</td></tr>';
                        });
                }
            });

            // ✅ Save updated scores (NEW WORKING FUNCTION)
            saveScoresBtn.addEventListener('click', () => {
                const taskId = document.getElementById('taskId').value;
                const inputs = scoreTableBody.querySelectorAll('.score-input');

                const scores = Array.from(inputs).map(input => ({
                    user_id: input.dataset.user,
                    score: input.value
                }));

                fetch(`/tasks/${taskId}/scores`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        scores
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Scores updated successfully!');
                            location.reload();
                        } else {
                            alert('Failed to update scores.');
                        }
                    })
                    .catch(err => {
                        console.error('Error updating scores:', err);
                        alert('An error occurred while updating scores.');
                    });
            });

            // Mark as completed
            markCompleteBtn.addEventListener('click', () => {
                const taskId = document.getElementById('taskId').value;
                fetch(`/tasks/${taskId}/complete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                    .then(res => res.json())
                    .then(() => {
                        alert('Task marked as completed.');
                        location.reload();
                    });
            });

            // Add new student record
            document.getElementById('addRecordBtn').addEventListener('click', () => {
                document.getElementById('newRecordForm').style.display = 'block';
            });

            document.getElementById('saveNewRecordBtn').addEventListener('click', () => {
                const taskId = document.getElementById('taskId').value;
                const userId = document.getElementById('newStudentSelect').value;
                const score = document.getElementById('newStudentScore').value;

                if (!userId || score === '') {
                    alert('Please select a student and enter a score.');
                    return;
                }

                fetch(`/tasks/${taskId}/scores/add`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        score
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        const tbody = document.getElementById('scoreTableBody');
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                    <td>${data.data.user.name}</td>
                    <td><input type="number" class="form-control score-input" 
                            data-user="${data.data.user.id}" value="${data.data.score}" min="0" max="100"></td>`;
                        tbody.appendChild(newRow);

                        document.getElementById('newStudentSelect').value = '';
                        document.getElementById('newStudentScore').value = '';
                        document.getElementById('newRecordForm').style.display = 'none';

                        alert('Student record added successfully!');
                    })
                    .catch(err => console.error(err));
            });
        });
    </script>
</body>

</html>