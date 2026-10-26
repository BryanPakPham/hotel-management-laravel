<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin - Hotel Management')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #12304a;
            color: white;
        }

        .brand {
            padding: 24px 18px;
            font-size: 19px;
            font-weight: bold;
            border-bottom: 1px solid #345168;
        }

        .menu {
            padding: 20px 12px;
        }

        .menu a {
            display: block;
            padding: 12px 14px;
            margin-bottom: 6px;
            border-radius: 7px;
            color: #dbe5ed;
            text-decoration: none;
        }

        .menu a:hover,
        .menu a.active {
            background: #254966;
            color: white;
        }

        .main-area {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 18px 28px;
            border-bottom: 1px solid #e5e7eb;
        }

        .page-content {
            padding: 28px;
        }

        @media (max-width: 767px) {
            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .page-content {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column flex-md-row">

        <aside class="sidebar">
            <div class="brand">
                HOTEL MANAGEMENT
            </div>

            <nav class="menu">
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.rooms.index') }}"
                    class="{{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                    Quản lý phòng
                </a>


                <a href="{{ route('admin.room-types.index') }}"
                    class="{{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
                    Quản lý loại phòng
                </a>


                <a href="{{ route('admin.bookings.index') }}"
                    class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    Quản lý đặt phòng
                </a>

                <a href="{{ route('admin.users.index') }}">
                    Quản lý khách hàng
                </a>

                <a href="{{ route('admin.amenities.index') }}"
                    class="{{ request()->routeIs('admin.amenities.*') ? 'active' : '' }}">
                    Quản lý tiện nghi
                </a>

                <a href="{{ route('admin.services.index') }}"
                    class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    Quản lý dịch vụ
                </a>
                <hr>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        Đăng xuất
                    </button>
                </form>
            </nav>
        </aside>

        <div class="main-area">
            <header class="topbar d-flex justify-content-between align-items-center">
                <div class="fw-semibold">@yield('page-heading', 'Dashboard')</div>
                <div class="text-secondary">
                    Xin chào, {{ auth()->user()->name ?? 'Admin' }}
                </div>
            </header>

            <main class="page-content">
                @yield('content')
            </main>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
