
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') | Hotel Management</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    {{-- CSS dùng chung --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @stack('styles')
</head>

<body>

    <div class="dashboard-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar" id="sidebar">

            <a href="{{ url('/') }}" class="sidebar-brand">
                <i class="bi bi-buildings-fill"></i>
                <span>Hotel Manager</span>
            </a>

            <div class="sidebar-user">
                <div class="user-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>
                    <strong>{{ auth()->user()->name ?? 'Tài khoản' }}</strong>
                    <small>Hệ thống quản lý khách sạn</small>
                </div>
            </div>

            {{-- Menu thay đổi theo từng trang --}}
            <nav class="sidebar-menu">
                @yield('sidebar')
            </nav>

            <div class="sidebar-bottom">
                <a href="{{ url('/') }}" class="menu-link">
                    <i class="bi bi-house"></i>
                    <span>Trang chủ</span>
                </a>
            </div>

        </aside>

        {{-- LỚP PHỦ TRÊN ĐIỆN THOẠI --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        {{-- NỘI DUNG CHÍNH --}}
        <div class="main-area">

            {{-- TOPBAR --}}
            <header class="topbar">

                <div class="d-flex align-items-center gap-3">
                    <button type="button"
                            class="sidebar-toggle"
                            id="sidebarToggle"
                            aria-label="Mở hoặc thu gọn menu">
                        <i class="bi bi-list"></i>
                    </button>

                    <div>
                        <h5 class="mb-1">@yield('page-heading', 'Dashboard')</h5>
                        <small class="text-secondary">
                            @yield('breadcrumb', 'Trang quản trị')
                        </small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="account-info">
                        <strong>{{ auth()->user()->name ?? 'Tài khoản' }}</strong>
                        <small>{{ auth()->user()->role ?? '' }}</small>
                    </div>

                    <div class="user-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>

            </header>

            {{-- NỘI DUNG RIÊNG CỦA TỪNG TRANG --}}
            <main class="content-area">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close"
                                data-bs-dismiss="alert"></button>
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
            <footer class="dashboard-footer">
                <span>© {{ date('Y') }} Hotel Management</span>
                <span>Hệ thống quản lý khách sạn</span>
            </footer>

        </div>

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- JavaScript dùng chung --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>

    @stack('scripts')

</body>
</html>
