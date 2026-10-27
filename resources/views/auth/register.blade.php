
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký | Hotel Management</title>

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

        .register-card {
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

        .btn-register {
            background: #12304a;
            color: white;
            padding: 11px;
        }

        .btn-register:hover {
            background: #1d4969;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container px-3">
        <div class="register-card mx-auto">

            <div class="text-center mb-4">
                <h3 class="hotel-name">HOTEL MANAGEMENT</h3>
                <p class="text-secondary mb-0">
                    Tạo tài khoản để đặt phòng dễ dàng!
                </p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nhập họ và tên"
                        required
                        autofocus
                    >
                </div>

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
                    >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Ít nhất 8 ký tự"
                        minlength="8"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">
                        Xác nhận mật khẩu
                    </label>
                    <input
                        type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Nhập lại mật khẩu"
                        minlength="8"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-register w-100">
                    Đăng ký
                </button>
            </form>

            <div class="text-center mt-3">
                Đã có tài khoản?
                <a href="{{ route('login') }}" class="text-decoration-none">
                    Đăng nhập
                </a>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    ← Quay về trang chủ
                </a>
            </div>

        </div>
    </div>
</body>
</html>
