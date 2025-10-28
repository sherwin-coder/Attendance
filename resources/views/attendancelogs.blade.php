<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Attendance Logs | Smart QR Attendance</title>

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

    html, body {
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

    .form-select {
      border: 1.5px solid #e9ecef !important;
      border-radius: 8px !important;
      padding: 12px 15px !important;
      font-size: 0.95rem !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .form-select:focus {
      border-color: #4B49AC !important;
      box-shadow: 0 0 0 3px rgba(75, 73, 172, 0.1) !important;
      transform: translateY(-2px);
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

    .btn-sm {
      padding: 8px 16px !important;
      font-size: 0.875rem !important;
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
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.02);
    }

    .table-hover tbody tr:hover {
      background-color: rgba(75, 73, 172, 0.05);
      transform: translateY(-1px);
      transition: all 0.3s ease;
    }

    /* ===== ALERT STYLES ===== */
    .alert {
      border-radius: 8px !important;
      border: none !important;
      padding: 15px 20px !important;
      font-size: 0.95rem !important;
      transition: all 0.3s ease !important;
    }

    /* ===== PAGINATION STYLES ===== */
    .pagination {
      margin-bottom: 0;
    }

    .page-link {
      border: 1.5px solid #e9ecef !important;
      border-radius: 8px !important;
      margin: 0 4px;
      color: #4B49AC;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .page-link:hover {
      background: #4B49AC;
      border-color: #4B49AC;
      color: white;
      transform: translateY(-2px);
    }

    .page-item.active .page-link {
      background: linear-gradient(135deg, #4B49AC, #3a3899);
      border-color: #4B49AC;
    }

    /* ===== FILTER SECTION ===== */
    .filter-section {
      background: white;
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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

      .table-responsive {
        font-size: 0.875rem;
      }

      .table th,
      .table td {
        padding: 10px 8px;
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
            <li class="nav-item active">
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
            <li class="nav-item">
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
                <img class="user-avatar" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="dropdown-avatar" src="{{ asset('assets/images/faces/face8.jpg') }}" alt="Profile image">
                  <p class="mb-1 fw-semibold">Admin</p>
                  <p class="fw-light text-muted mb-0">admin@attendance.com</p>
                </div>
                <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="mdi mdi-account-outline me-2 text-primary"></i>Profile</a>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                  @csrf
                  <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
          <!-- Page Title -->
          <div class="mb-4">
            <h3 class="fw-bold text-dark">Attendance Logs</h3>
          </div>

          <!-- Filter Section -->
          <div class="card mb-4">
            <div class="card-body">
              <form method="GET" action="{{ route('attendance.logs') }}">
                <div class="row align-items-end">
                  <div class="col-md-8">
                    <label class="form-label fw-bold">Filter by Subject</label>
                    <select name="subject" id="subject" class="form-select" onchange="this.form.submit()">
                      <option value="">All Subjects</option>
                      @foreach($subjects as $subject)
                      <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                        {{ $subject->code }} - {{ $subject->name }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <noscript>
                      <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                    </noscript>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!-- Attendance Logs Table -->
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Subject</th>
                      <th>Date</th>
                      <th>Time In</th>
                      <th>Time Out</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $log->user->studentno ?? 'N/A' }}</td>
                      <td>{{ $log->user->name ?? 'N/A' }}</td>
                      <td>{{ $log->subject->code ?? 'N/A' }} - {{ $log->subject->name ?? 'N/A' }}</td>
                      <td>{{ \Carbon\Carbon::parse($log->date)->format('Y-m-d') }}</td>
                      <td>
                        <span class="badge bg-success">{{ $log->time_in ?? '-' }}</span>
                      </td>
                      <td>
                        <span class="badge bg-info">{{ $log->time_out ?? '-' }}</span>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center text-muted py-4">
                        <i class="mdi mdi-information-outline me-2"></i>
                        No attendance logs found.
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              @if($logs->hasPages())
              <div class="d-flex justify-content-center mt-4">
                {{ $logs->appends(['subject' => $selectedSubject])->links() }}
              </div>
              @endif
            </div>
          </div>

        </div>

        <!-- Footer -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center d-block d-sm-inline-block">
              © {{ date('Y') }} Smart Student Attendance System. All Rights Reserved.
            </span>
          </div>
        </footer>
      </main>
    </div>
  </div>

  <!-- JS Files -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>

  <!-- Sidebar Toggle Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');
      
      // Desktop sidebar toggle functionality
      if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
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
      document.addEventListener('click', function(event) {
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
    });
  </script>
</body>
</html>