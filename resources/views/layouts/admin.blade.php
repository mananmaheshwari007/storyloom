<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — {{ setting('site_name', 'Storyloom') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Serif/handwritten fonts kept only for the Journal editor's live article preview, which mirrors the front-of-site typography -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Edu+SA+Hand:wght@400..700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-bg: #1D2A44;
            --primary-active: #B55B29;
            --primary-active-soft: rgba(181, 91, 41, 0.1);
            --content-bg: #F8F4EC;
            --card-shadow: 0 4px 20px 0 rgba(29, 42, 68, 0.04);
            --font-family-base: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            --font-family-title: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            --font-hand: "Edu SA Hand", cursive;
            --text-body: #1e2533;
            --text-quiet: #64748b;
        }

        body {
            font-family: var(--font-family-base);
            background-color: var(--content-bg);
            color: var(--text-body);
            line-height: 1.55;
            font-size: 0.94rem;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-family-title);
        }

        label, .form-label {
            font-weight: 600;
            font-size: 0.86rem;
            color: var(--text-body);
        }

        .form-control, .form-select {
            font-size: 0.92rem;
        }

        .form-text {
            color: var(--text-quiet);
            font-size: 0.8rem;
        }

        .text-muted {
            color: var(--text-quiet) !important;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary-bg);
            color: #94a3b8;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .admin-sidebar .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-sidebar .sidebar-brand img {
            border-radius: 6px;
            background: #fff;
            padding: 4px;
        }

        .admin-sidebar .sidebar-brand .brand-name {
            font-family: var(--font-family-title);
            font-weight: 700;
            color: #fff;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            padding: 16px 8px;
            max-height: calc(100vh - 90px);
            overflow-y: auto;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.1);
            border-radius: 4px;
        }

        .sidebar-menu-header {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            padding: 10px 16px 4px;
            font-weight: 600;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.92rem;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .sidebar-link i {
            font-size: 1.1rem;
        }

        .sidebar-link:hover {
            background-color: rgba(255,255,255,0.03);
            color: #f1f5f9;
        }

        .sidebar-link.active {
            background-color: var(--primary-active-soft);
            color: var(--primary-active);
            font-weight: 500;
        }

        /* Main Content Styling */
        .admin-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .admin-navbar {
            background: #fff;
            padding: 16px 24px;
            box-shadow: 0 1px 0 rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .admin-content {
            padding: 32px 24px;
            flex-grow: 1;
        }

        .admin-footer {
            background: #fff;
            padding: 16px 24px;
            border-top: 1px solid rgba(0,0,0,0.05);
            text-align: center;
            font-size: 0.85rem;
            color: #64748b;
        }

        .btn-primary {
            background-color: var(--primary-active);
            border-color: var(--primary-active);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #c77b4d;
            border-color: #c77b4d;
        }

        /* Breadcrumbs and Stats styling */
        .page-header {
            margin-bottom: 28px;
        }

        .page-title {
            font-family: var(--font-family-title);
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .card {
            border: 1px solid rgba(29, 42, 68, 0.08);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            background-color: #FFFDF8;
        }

        /* Responsive Sidebar toggling */
        @media(max-width: 991px) {
            .admin-sidebar {
                left: -260px;
            }
            .admin-wrapper {
                margin-left: 0;
            }
            body.sidebar-open .admin-sidebar {
                left: 0;
            }
            body.sidebar-open .admin-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset(setting('site_favicon', 'assets/img/favicon.png')) }}" alt="Logo" width="32" height="32">
            <span class="brand-name">Storyloom</span>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-menu-header">Page Content Managers</div>
            
            <a href="{{ route('admin.hero.edit') }}" class="sidebar-link {{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                <span>1. Homepage</span>
            </a>
            <a href="{{ route('admin.how.edit') }}" class="sidebar-link {{ request()->routeIs('admin.how.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>2. How It Works</span>
            </a>
            <a href="{{ route('admin.library.index') }}" class="sidebar-link {{ request()->routeIs('admin.library.*') ? 'active' : '' }}">
                <i class="bi bi-book-half"></i>
                <span>3. Read a Storyloom</span>
            </a>
            <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                <i class="bi bi-heart"></i>
                <span>4. Occasions</span>
            </a>
            <a href="{{ route('admin.blog.index') }}" class="sidebar-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i>
                <span>5. Journal</span>
            </a>
            <a href="{{ route('admin.pricing.index') }}" class="sidebar-link {{ request()->routeIs('admin.pricing.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i>
                <span>6. Pricing</span>
            </a>
            <a href="{{ route('admin.about.edit') }}" class="sidebar-link {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                <i class="bi bi-file-person"></i>
                <span>7. About</span>
            </a>
            <a href="{{ route('admin.faqs.index') }}" class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <i class="bi bi-question-circle"></i>
                <span>8. FAQ</span>
            </a>
            <a href="{{ route('admin.begin.edit') }}" class="sidebar-link {{ request()->routeIs('admin.begin.*') ? 'active' : '' }}">
                <i class="bi bi-rocket-takeoff"></i>
                <span>9. Begin a Story</span>
            </a>

            <div class="sidebar-menu-header">Global Site Controls</div>

            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i>
                <span>Site Settings & Branding</span>
            </a>
            <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i>
                <span>Messages & Inquiries</span>
                @php $unreadMsgs = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                @if($unreadMsgs > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadMsgs }}</span>
                @endif
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="sidebar-link {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <i class="bi bi-mailbox"></i>
                <span>Newsletter Subscribers</span>
            </a>
            <a href="{{ route('admin.media.index') }}" class="sidebar-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i>
                <span>Media Manager</span>
            </a>
        </div>
    </aside>

    <!-- Wrapper -->
    <div class="admin-wrapper">
        <!-- Top Navbar -->
        <nav class="admin-navbar">
            <button class="btn btn-link p-0 d-lg-none text-dark fs-3" id="sidebar-toggle" aria-label="Toggle Sidebar">
                <i class="bi bi-list"></i>
            </button>
            <div class="ms-auto d-flex align-items-center gap-4">
                <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-box-arrow-up-right me-1"></i> Visit Site
                </a>
                <div class="dropdown">
                    <button class="btn btn-link text-decoration-none dropdown-toggle text-dark p-0 d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Log Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Body Content -->
        <main class="admin-content" id="main">
            <!-- Toast notification messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            &copy; {{ date('Y') }} {{ setting('site_name', 'Storyloom') }} CMS. Crafted with Care.
        </footer>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });

        /* Universal "Remove image".
           Any image field wrapped in .img-upload-block gets this for free:
           clears the stored path, clears any pending file, and dims the
           preview. The blank value is what tells the controller to drop the
           saved image — so it only takes effect once the form is saved. */
        (function () {
            var PLACEHOLDER = "{{ asset('assets/img/logo-emblem.png') }}";

            document.addEventListener('click', function (e) {
                var btn = e.target.closest('.remove-img-btn');
                if (!btn) return;

                var block = btn.closest('.img-upload-block');
                if (!block) return;

                e.preventDefault();

                var pathInput = block.querySelector('.img-path-input');
                var fileInput = block.querySelector('.hidden-file-input');
                var preview   = block.querySelector('.img-preview-el');

                if (pathInput) pathInput.value = '';
                if (fileInput) fileInput.value = '';
                if (preview) {
                    preview.src = PLACEHOLDER;
                    preview.style.opacity = '.25';
                }
                btn.blur();
            });
        })();
    </script>
    @yield('scripts')
</body>
</html>
