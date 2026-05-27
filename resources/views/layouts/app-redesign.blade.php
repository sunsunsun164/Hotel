<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','HotelBooking')</title>
    <style>
        :root{
            --bg0:#f7f7ff;
            --bg1:#eef6ff;
            --card:rgba(255,255,255,.78);
            --stroke:rgba(2,6,23,.08);
            --text:#0f172a;
            --muted:#64748b;
            --brand:#5b7cfa;
            --brand2:#22c55e;
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;
            color:var(--text);
            line-height:1.45;
            background:
                radial-gradient(900px 500px at 15% 10%, rgba(91,124,250,.18), transparent 60%),
                radial-gradient(800px 480px at 85% 15%, rgba(34,197,94,.14), transparent 58%),
                linear-gradient(180deg, var(--bg1), var(--bg0));
            min-height:100vh;
        }
        .container{max-width:1180px;margin:0 auto;padding:0 18px}
        .header{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.65);backdrop-filter:blur(10px);border-bottom:1px solid rgba(2,6,23,.06)}
        .header-inner{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:14px 0}
        .logo{font-weight:950;color:var(--brand);text-decoration:none;letter-spacing:-.02em;font-size:1.35rem}
        .nav{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .nav a{color:#475569;text-decoration:none;font-weight:800;padding:8px 10px;border-radius:12px;border:1px solid transparent}
        .nav a:hover{background:rgba(91,124,250,.08);border-color:rgba(91,124,250,.16)}
        .logout-btn{background:none;border:none;color:#ef4444;font-weight:900;cursor:pointer;padding:8px 10px;border-radius:12px}
        .logout-btn:hover{background:rgba(239,68,68,.08)}
        .panel{background:var(--card);border:1px solid var(--stroke);border-radius:18px;box-shadow:0 18px 50px rgba(2,6,23,.06);backdrop-filter:blur(8px)}
        @yield('styles')
    </style>
</head>
<body>
    <div class="header">
        <div class="container header-inner">
            <a href="/" class="logo">🏨 HotelBooking</a>
            <div class="nav">
                <a href="/hotels">Отели</a>
                @auth
                    <a href="{{ route('profile.index') }}">👤 Личный кабинет</a>
                    <a href="{{ route('bookings.index') }}">Мои брони</a>
@if(Auth::user()->is_admin)
                        <a href="{{ route('admin.reviews.index') }}">👑 Модерация отзывов</a>
                        <a href="{{ route('admin.hotels.create') }}">➕ Создать отель</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Выйти</button>
                    </form>
                @else
                    <a href="/login">Вход</a>
                    <a href="/register">Регистрация</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>

