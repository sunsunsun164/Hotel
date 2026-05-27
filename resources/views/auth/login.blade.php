<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: radial-gradient(1200px circle at 10% 10%, rgba(37,99,235,0.18), transparent 40%),
                        radial-gradient(900px circle at 90% 20%, rgba(16,185,129,0.14), transparent 45%),
                        #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #111827;
        }

        .wrapper { width: 100%; max-width: 420px; }

        .card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(229,231,235,0.9);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.08);
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 14px;
        }
        .brand .logo {
            font-size: 28px;
            font-weight: 900;
            color: #2563eb;
            letter-spacing: -0.02em;
        }
        h1 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 18px;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 14px;
            font-size: 14px;
        }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: 13px; color: #374151; font-weight: 600; margin-bottom: 8px; }
        input {
            width: 100%;
            padding: 12px 12px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            outline: none;
            background: white;
        }
        input:focus { border-color: #93c5fd; box-shadow: 0 0 0 4px rgba(59,130,246,0.15); }

        .btn {
            width: 100%;
            padding: 12px 14px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            color: white;
            font-weight: 700;
            font-size: 14px;
            transition: transform 0.05s ease, filter 0.15s ease;
        }
        .btn:active { transform: translateY(1px); }
        .btn:hover { filter: brightness(1.03); }

        .row { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
        .checkbox { display: flex; align-items: center; gap: 10px; }
        .checkbox input { width: auto; margin: 0; }
        .checkbox label { margin: 0; font-weight: 600; }

        .link {
            text-align: center;
            margin-top: 14px;
            font-size: 14px;
            color: #6b7280;
        }
        .link a { color: #2563eb; text-decoration: none; font-weight: 700; }
        .link a:hover { text-decoration: underline; }

        .footer-note { text-align: center; margin-top: 14px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="brand">
                <div class="logo">🏨</div>
            </div>
            <h1>Вход в систему</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                </div>

                <div class="row">
                    <div class="checkbox">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember" style="color:#374151;">Запомнить меня</label>
                    </div>
                </div>

                <button type="submit" class="btn">Войти</button>
            </form>

            <div class="link">
                Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
            </div>

            <div class="footer-note">© {{ date('Y') }} HotelBooking</div>
        </div>
    </div>
</body>
</html>

