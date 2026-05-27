<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Отели для вашего отдыха</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
            line-height: 1.5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .header {
            background: white;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            padding: 1rem 0;
            margin-bottom: 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }
        .logo:hover {
            color: #1d4ed8;
        }
        .nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .nav a {
            text-decoration: none;
            color: #4b5563;
            transition: color 0.2s;
        }
        .nav a:hover {
            color: #2563eb;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-name {
            color: #2563eb;
            font-weight: 500;
        }
        .logout-btn {
            background: none;
            border: none;
            color: #dc2626;
            cursor: pointer;
            font-size: 1rem;
            padding: 0;
        }
        .logout-btn:hover {
            text-decoration: underline;
        }
        .hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        .hero h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        .hero p {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 1rem;
        }
        .hero-button {
            display: inline-block;
            background: #f59e0b;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 2rem;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s;
        }
        .hero-button:hover {
            background: #d97706;
            transform: scale(1.05);
        }
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .hotels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .hotel-card {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .hotel-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .hotel-img {
            height: 180px;
            background: linear-gradient(135deg, #d1d5db, #9ca3af);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 0.875rem;
            overflow: hidden;
        }
        .hotel-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hotel-info {
            padding: 1rem;
        }
        .hotel-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }
        .hotel-city {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        .stars {
            color: #fbbf24;
            font-size: 0.875rem;
            margin: 0.25rem 0;
        }
        .price {
            font-weight: bold;
            color: #2563eb;
            margin: 0.5rem 0;
        }
        .btn-small {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 0.8rem;
            transition: background 0.2s;
        }
        .btn-small:hover {
            background: #1d4ed8;
        }
        .info-block {
            background: #e0e7ff;
            border-radius: 1rem;
            padding: 1.5rem;
            margin: 2rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .info-block h3 {
            color: #1e3a8a;
            margin-bottom: 0.25rem;
        }
        .info-block p {
            color: #1e40af;
        }
        .contacts {
            text-align: right;
        }
        .contacts .phone {
            font-weight: bold;
            font-size: 1.1rem;
        }
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .footer {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            margin-top: 2rem;
        }
        @media (max-width: 640px) {
            .header-inner {
                flex-direction: column;
            }
            .nav {
                justify-content: center;
            }
            .hero h1 {
                font-size: 1.4rem;
            }
            .hero {
                padding: 1.5rem;
            }
            .info-block {
                flex-direction: column;
                text-align: center;
            }
            .contacts {
                text-align: center;
            }
        }
        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 1rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container header-inner">
            <a href="/" class="logo">🏨 HotelBooking</a>
            <div class="nav">
                <a href="{{ route('hotels.index') }}">Все отели</a>
    
                @auth
                    <a href="{{ route('profile.index') }}" style="color: #2563eb; font-weight: bold;">👤 Личный кабинет</a>
                    <a href="{{ route('bookings.index') }}">Мои брони</a>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn">Выйти</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}">Вход</a>
                    <a href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="hero">
            <h1>🔥 Летние скидки до 30%</h1>
            <p>Забронируйте отель сейчас и получите специальную цену на проживание</p>
            <a href="{{ route('hotels.index') }}" class="hero-button">Выбрать отель →</a>
        </div>

        <h2 class="section-title">⭐ Популярные отели</h2>
        <div class="hotels-grid">
            @forelse($popularHotels as $hotel)
                <div class="hotel-card">
                    <div class="hotel-img">
                        @if($hotel->image)
                            <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                        @else
                            🏙️ Нет фото
                        @endif
                    </div>
                    <div class="hotel-info">
                        <div class="hotel-name">{{ $hotel->name }}</div>
                        <div class="hotel-city">{{ $hotel->city }}{{ $hotel->country ? ', ' . $hotel->country : '' }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $hotel->stars ? '★' : '☆' }}
                            @endfor
                        </div>
                        <div class="price">{{ number_format($hotel->price_per_night, 0, '.', ' ') }} ₽ / ночь</div>
                        <a href="{{ route('hotels.show', $hotel->id) }}" class="btn-small">Подробнее →</a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>😕 Пока нет добавленных отелей</p>
                    <p style="font-size: 0.875rem; margin-top: 0.5rem;">Заходите позже!</p>
                </div>
            @endforelse
        </div>

        <div class="info-block">
            <div>
                <h3>📞 Нужна помощь с выбором?</h3>
                <p>Наши консультанты помогут подобрать лучший вариант для вашего отпуска</p>
            </div>
            <div class="contacts">
                <div class="phone">+7 (800) 123-45-67</div>
                <p style="font-size: 0.8rem;">support@hotelbooking.ru</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} HotelBooking. Все права защищены.</p>
        <p style="font-size: 0.8rem; margin-top: 0.5rem;">Удобный поиск и бронирование отелей</p>
    </div>
</body>
</html>