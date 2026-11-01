
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Lễ tân') - Hotel Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/receptionist.css') }}">

    @stack('styles')
</head>

<body class="receptionist-page">

    <div class="receptionist-wrapper">

        {{-- SIDEBAR --}}
        <aside class="receptionist-sidebar" id="sidebar">

            <a href="{{ route('receptionist.dashboard') }}" class="receptionist-brand">
                <i class="bi bi-buildings-fill"></i>
                <span>Hotel Manager</span>
            </a>

            <div class="receptionist-profile">
                <div class="profile-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div class="profile-info">
                    <strong>{{ auth()->user()->name ?? 'Tài khoản' }}</strong>
                    <small>Nhân viên lễ tân</small>
                </div>
            </div>

            <div class="sidebar-heading">MENU CHÍNH</div>

            <nav class="receptionist-menu">
                @yield('sidebar')
            </nav>

            <div class="sidebar-bottom">
                <a href="{{ route('receptionist.dashboard') }}">
                    <i class="bi bi-house-door"></i>
                    <span>Trang chủ</span>
                </a>
            </div>

        </aside>

        <div class="receptionist-overlay" id="sidebarOverlay"></div>

        {{-- MAIN CONTENT --}}
        <div class="receptionist-main">

            {{-- TOPBAR --}}
            <header class="receptionist-topbar">

                <div class="topbar-left">

                    <button type="button" id="sidebarToggle" class="sidebar-toggle">
                        <i class="bi bi-list"></i>
                    </button>

                    <div>
                        <h5>@yield('page-heading', 'Dashboard')</h5>
                        <small>@yield('breadcrumb', 'Trang chủ / Lễ tân')</small>
                    </div>

                </div>

                <div class="topbar-account">
                    <div class="account-info">
                        <strong>{{ auth()->user()->name ?? 'Tài khoản' }}</strong>
                        <small>Nhân viên lễ tân</small>
                    </div>

                    <div class="profile-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>

            </header>

            {{-- PAGE CONTENT --}}
            <main class="receptionist-content">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')

            </main>

            {{-- FOOTER --}}
            <footer class="receptionist-footer">
                <span>© {{ date('Y') }} Hotel Management</span>
                <span>Hệ thống quản lý khách sạn</span>
            </footer>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var toggle = document.getElementById('sidebarToggle');
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebarOverlay');

            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });

            overlay.addEventListener('click', function () {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });

        });
    </script>

    @stack('scripts')

</body>
</html>
