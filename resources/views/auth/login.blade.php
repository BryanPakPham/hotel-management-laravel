
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Hotel Management</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #f5f6f7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: white;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .hotel-name {
            color: #12304a;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .btn-login {
            background: #12304a;
            color: white;
            padding: 11px;
        }

        .btn-login:hover {
            background: #1d4969;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container px-3">
        <div class="login-card mx-auto">

            <div class="text-center mb-4">
                <h3 class="hotel-name">HOTEL MANAGEMENT</h3>
                <p class="text-secondary mb-0">Chào mừng bạn quay trở lại!</p>
            </div>

            <!-- Hiển thị thông báo lỗi -->
            @if (isset($errors) && $errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Form đăng nhập -->
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Nhập email của bạn"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-login w-100">
                    Đăng nhập
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    ← Quay về trang chủ
                </a>
            </div>

        </div>
    </div>
</body>
</html>
