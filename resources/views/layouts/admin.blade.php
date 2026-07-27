<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Dashboard') | {{ setting('site_name', 'Storyloom') }} CMS</title>
  
  <!-- Bootstrap 5 & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }
    .admin-sidebar {
      min-width: 250px;
      max-width: 250px;
      background-color: #1d2a44;
      color: #fff;
      min-height: 100vh;
      transition: all 0.3s;
    }
    .admin-sidebar .sidebar-header {
      padding: 20px;
      background-color: #162035;
    }
    .admin-sidebar a {
      color: rgba(255, 255, 255, 0.75);
      text-decoration: none;
      padding: 12px 20px;
      display: block;
      transition: all 0.3s;
    }
    .admin-sidebar a:hover, .admin-sidebar a.active {
      color: #fff;
      background-color: rgba(255, 255, 255, 0.1);
      border-left: 4px solid #b55b29;
    }
    .admin-sidebar a i {
      margin-right: 10px;
    }
    .admin-navbar {
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.04);
      padding: 15px 30px;
    }
    .content-area {
      padding: 30px;
      width: 100%;
    }
    .card {
      border: none;
      box-shadow: 0 4px 6px rgba(0,0,0,0.02), 0 1px 3px rgba(0,0,0,0.08);
      border-radius: 8px;
    }
    .btn-primary {
      background-color: #b55b29;
      border-color: #b55b29;
    }
    .btn-primary:hover {
      background-color: #96471d;
      border-color: #96471d;
    }
    .btn-outline-primary {
      color: #b55b29;
      border-color: #b55b29;
    }
    .btn-outline-primary:hover {
      background-color: #b55b29;
      color: #fff;
    }
    .text-primary {
      color: #b55b29 !important;
    }
    .toast-container {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1050;
    }
  </style>
  @stack('styles')
</head>
<body class="d-flex">

  <!-- Sidebar -->
  @include('layouts.sidebar')

  <!-- Main Content Wrapper -->
  <div class="d-flex flex-column flex-grow-1 min-vh-100">
    
    <!-- Top Navbar -->
    <nav class="navbar admin-navbar navbar-expand-lg d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <h4 class="m-0 text-dark font-weight-bold">@yield('page_title', 'Dashboard')</h4>
      </div>
      
      <div class="d-flex align-items-center">
        <!-- User Profile Dropdown -->
        <div class="dropdown">
          <button class="btn btn-link text-dark dropdown-toggle text-decoration-none d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="me-2 d-none d-md-inline">{{ Auth::user()->name }}</span>
            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Edit Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Log Out</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="content-area">
      <!-- Breadcrumbs -->
      @yield('breadcrumbs')
      
      <!-- Content -->
      @yield('content')
    </div>
  </div>

  <!-- Toast Notification System -->
  <div class="toast-container">
    @if(session('success'))
      <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @if(session('error'))
      <div class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    @endif
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Initialize tooltips/popovers if needed
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl, { delay: 5000 });
    });
  </script>
  @stack('scripts')
</body>
</html>
