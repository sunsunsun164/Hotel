<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отели — поиск и бронирование</title>
    <style>
        :root{
            --bg0:#f7f7ff;
            --bg1:#eef6ff;
            --card:#ffffffcc;
            --stroke:rgba(15,23,42,.10);
            --text:#0f172a;
            --muted:#64748b;
            --brand:#5b7cfa;
            --brand2:#22c55e;
            --shadow: 0 18px 50px rgba(2,6,23,.10);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family: system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;
            color:var(--text);
            line-height:1.45;
            background:
                radial-gradient(900px 500px at 15% 10%, rgba(91,124,250,.18), transparent 60%),
                radial-gradient(800px 480px at 85% 15%, rgba(34,197,94,.14), transparent 58%),
                linear-gradient(180deg, var(--bg1), var(--bg0));
            min-height:100vh;
        }
        .container{max-width:1180px;margin:0 auto;padding:0 18px}

        .header{
            position:sticky;top:0;z-index:50;
            background:rgba(255,255,255,.65);
            backdrop-filter: blur(10px);
            border-bottom:1px solid rgba(2,6,23,.06);
        }
        .header-inner{
            display:flex;align-items:center;justify-content:space-between;
            gap:12px;flex-wrap:wrap;padding:14px 0;
        }
        .logo{font-weight:950;color:var(--brand);text-decoration:none;letter-spacing:-.02em;font-size:1.35rem}
        .nav{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .nav a{
            text-decoration:none;color:#475569;font-weight:800;
            padding:8px 10px;border-radius:12px;
            border:1px solid transparent;
        }
        .nav a:hover{background:rgba(91,124,250,.08);border-color:rgba(91,124,250,.16)}
        .logout-btn{background:none;border:none;color:#ef4444;font-weight:900;cursor:pointer;padding:8px 10px;border-radius:12px}
        .logout-btn:hover{background:rgba(239,68,68,.08)}

        .hero{padding:22px 0 14px;display:flex;align-items:flex-end;justify-content:space-between;gap:18px;flex-wrap:wrap}
        .hero h1{font-size:1.9rem;letter-spacing:-.03em}
        .hero p{color:var(--muted);font-weight:700;max-width:640px}
        .chips{display:flex;gap:10px;flex-wrap:wrap}
        .chip{background:rgba(255,255,255,.7);border:1px solid rgba(2,6,23,.06);padding:8px 11px;border-radius:999px;font-weight:900;color:#334155;box-shadow:0 8px 25px rgba(2,6,23,.05)}

        .panel{
            background:rgba(255,255,255,.72);
            border:1px solid rgba(2,6,23,.06);
            border-radius:18px;
            box-shadow: 0 18px 50px rgba(2,6,23,.06);
            backdrop-filter: blur(8px);
        }

        .section{margin:14px 0 18px}

        .filters-title{font-weight:950;color:#0b1220;font-size:1.05rem;margin-bottom:12px}
        .filters-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:12px}
        .field{display:flex;flex-direction:column;gap:6px}
        label{font-size:12px;color:#475569;font-weight:900}
        select,input{
            padding:11px 12px;border-radius:14px;border:1px solid rgba(2,6,23,.10);
            background:#fff;font-weight:750;color:#0f172a;
            outline:none;
        }
        select:focus,input:focus{border-color:rgba(91,124,250,.55);box-shadow:0 0 0 4px rgba(91,124,250,.12)}

        .filter-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap;margin-top:4px}
        .btn-filter{
            border:none;border-radius:14px;
            padding:12px 14px;
            font-weight:950;
            cursor:pointer;
            color:#fff;
            background: linear-gradient(90deg, var(--brand), #3b82f6);
            box-shadow: 0 14px 30px rgba(91,124,250,.22);
        }
        .btn-reset{border:none;border-radius:14px;padding:12px 14px;font-weight:950;background:#e2e8f0;color:#0f172a;text-decoration:none;display:inline-flex;align-items:center}
        .btn-reset:hover{background:#dbe4f0}

        .sort-section{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin:12px 0 8px}
        .result-count{color:#475569;font-weight:950}
        .sort-links{display:flex;gap:8px;flex-wrap:wrap}
        .sort-link{
            text-decoration:none;color:#334155;font-weight:950;
            background:rgba(255,255,255,.7);
            border:1px solid rgba(2,6,23,.06);
            padding:9px 10px;border-radius:14px;
            transition:transform .15s, background .15s;
        }
        .sort-link:hover{transform:translateY(-1px);background:#fff}
        .sort-link.active{background:linear-gradient(90deg, rgba(91,124,250,.95), rgba(59,130,246,.95));color:#fff;border-color:transparent}

        .hotels-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;margin:18px 0 26px}
        .hotel-card{position:relative;overflow:hidden;border-radius:18px;border:1px solid rgba(2,6,23,.06);background:rgba(255,255,255,.78)}
        .hotel-card::before{content:'';position:absolute;inset:-2px;background:linear-gradient(135deg, rgba(91,124,250,.35), rgba(34,197,94,.22));opacity:.0;transition:opacity .18s;z-index:0}
        .hotel-card:hover::before{opacity:1}
        .hotel-card > *{position:relative;z-index:1}
        .hotel-card:hover{transform:translateY(-4px);transition:transform .2s;}
        .hotel-img{height:165px;display:flex;align-items:center;justify-content:center;font-size:44px;
            background:linear-gradient(135deg, rgba(91,124,250,.18), rgba(34,197,94,.12));}
        .hotel-info{padding:14px}
        .hotel-name{font-weight:950;color:#0b1220;font-size:1.08rem;margin-bottom:6px}
        .hotel-city{color:var(--muted);font-weight:850;font-size:13px;margin-bottom:10px}
        .stars{color:#f59e0b;font-weight:950;margin-bottom:10px}
        .price{color:#4f6bff;font-weight:1000;font-size:1.12rem;margin-bottom:12px}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;color:#fff;font-weight:950;
            padding:10px 14px;border-radius:14px;
            background:linear-gradient(90deg, var(--brand), #3b82f6);
        }
        .btn:hover{filter:brightness(1.04)}

        .empty-state{text-align:center;padding:3rem;background:rgba(255,255,255,.85);border-radius:18px;border:1px dashed rgba(91,124,250,.35);color:#64748b;font-weight:900;grid-column:1 / -1}
        .empty-state a{color: #4f6bff;font-weight:1000;text-decoration:none}

        .pagination{display:flex;justify-content:center;gap:8px;margin:20px 0 34px;flex-wrap:wrap}
        .pagination a,.pagination span{background:rgba(255,255,255,.75);border:1px solid rgba(2,6,23,.08);padding:10px 12px;border-radius:14px;text-decoration:none;color:#334155;font-weight:950}
        .pagination .active span{background:linear-gradient(90deg, var(--brand), #3b82f6);color:#fff;border-color:transparent}

        .footer{padding:28px 0;color:#64748b;text-align:center;border-top:1px solid rgba(2,6,23,.06);margin-top:10px;font-weight:800}

        @media (max-width:640px){
            .hero h1{font-size:1.55rem}
            .hero{padding:18px 0 10px}
            .filters-grid{grid-template-columns:1fr}
            .sort-section{align-items:flex-start}
        }
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
    <div class="hero">
        <div>
            <h1>Выберите отель без лишнего</h1>
            <p>Фильтры, сортировка и карточки в едином лаконичном стиле. Всё читается и выглядит приятно.</p>
        </div>
        <div class="chips">
            <span class="chip">⚡ Быстрый поиск</span>
            <span class="chip">🛎️ Удобный просмотр</span>
            <span class="chip">⭐ Отзывы после модерации</span>
        </div>
    </div>

    @if(session('success'))
        <div class="panel section" style="margin-top:10px;padding:14px;border-radius:18px;border-color:rgba(34,197,94,.25);background:rgba(209,250,229,.65);color:#065f46;font-weight:950">
            {{ session('success') }}
        </div>
    @endif

    <div class="panel section" style="padding:16px;">
        <div class="filters-title">🔍 Найти отель</div>
        <form method="GET" action="{{ route('hotels.index') }}">
            <div class="filters-grid">
                <div class="field">
                    <label>📍 Город</label>
                    <select name="city">
                        <option value="">Все города</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>⭐ Звёзды</label>
                    <select name="stars">
                        <option value="">Любые</option>
                        <option value="5" {{ request('stars') == '5' ? 'selected' : '' }}>★★★★★ (5)</option>
                        <option value="4" {{ request('stars') == '4' ? 'selected' : '' }}>★★★★ (4+)</option>
                        <option value="3" {{ request('stars') == '3' ? 'selected' : '' }}>★★★ (3+)</option>
                        <option value="2" {{ request('stars') == '2' ? 'selected' : '' }}>★★ (2+)</option>
                        <option value="1" {{ request('stars') == '1' ? 'selected' : '' }}>★ (1+)</option>
                    </select>
                </div>

                <div class="field">
                    <label>💰 Цена от (₽)</label>
                    <input type="number" name="price_from" value="{{ request('price_from') }}" placeholder="0" min="0">
                </div>

                <div class="field">
                    <label>💰 Цена до (₽)</label>
                    <input type="number" name="price_to" value="{{ request('price_to') }}" placeholder="50000" min="0">
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter">Применить</button>
                    <a href="{{ route('hotels.index') }}" class="btn-reset">Сбросить</a>
                </div>
            </div>
        </form>
    </div>

    <div class="sort-section">
        <div class="result-count">Найдено: <strong>{{ $hotels->total() }}</strong></div>
        <div class="sort-links">
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc', 'direction' => null]) }}" class="sort-link {{ request('sort') == 'price_asc' ? 'active' : '' }}">💰 По возрастанию</a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc', 'direction' => null]) }}" class="sort-link {{ request('sort') == 'price_desc' ? 'active' : '' }}">💰 По убыванию</a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'stars_desc', 'direction' => null]) }}" class="sort-link {{ request('sort') == 'stars_desc' ? 'active' : '' }}">⭐ По звёздам</a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc', 'direction' => null]) }}" class="sort-link {{ request('sort') == 'name_asc' ? 'active' : '' }}">📝 По названию</a>
        </div>
    </div>

    <div class="hotels-grid">
        @forelse($hotels as $hotel)
            <div class="hotel-card" style="transform:translateZ(0);">
                    <div class="hotel-img">
                        @if(trim(mb_strtolower($hotel->name)) === 'отель ларавель')
                            <img src="/pictures/HotelLaravel.jpg" alt="Отель Ларавель" style="max-width:100%;max-height:165px;object-fit:cover;" onerror="this.style.display='none';" />

                        @elseif($hotel->image)
                            <img src="{{ str_starts_with($hotel->image, '/') ? $hotel->image : ('/' . $hotel->image) }}" alt="hotel" style="max-width:100%;max-height:165px;object-fit:cover;" />
                        @else
                            🏨
                        @endif
                    </div>
                <div class="hotel-info">
                    <div class="hotel-name">{{ $hotel->name }}</div>
                    <div class="hotel-city">{{ $hotel->city }}, {{ $hotel->country ?? 'Россия' }}</div>
                    <div class="stars">
                        @for($i=1;$i<=5;$i++)
                            {{ $i <= $hotel->stars ? '★' : '☆' }}
                        @endfor
                    </div>
                    <div class="price">от {{ number_format($hotel->price_per_night,0,'.',' ') }} ₽</div>

                    @auth
                        @if(Auth::user()->is_admin)
                            <form method="POST" action="{{ route('admin.hotels.destroy', $hotel->id) }}" onsubmit="return confirm('Удалить отель?');" style="margin:10px 0 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-reset" style="background:rgba(239,68,68,.12);border-color:rgba(239,68,68,.25);font-weight:1000;color:#991b1b;cursor:pointer;">
                                    🗑️ Удалить
                                </button>
                            </form>
                        @endif
                    @endauth

                    <a href="{{ route('hotels.show', $hotel->id) }}" class="btn">Подробнее →</a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div>😕 Ничего не найдено</div>
                <div style="margin-top:10px;color:#64748b;font-weight:850">Попробуйте изменить параметры фильтров.</div>
                <a href="{{ route('hotels.index') }}" style="display:inline-block;margin-top:14px;">Сбросить фильтры</a>
            </div>
        @endforelse
    </div>

    @if($hotels->hasPages())
        <div class="pagination">{{ $hotels->links() }}</div>
    @endif
</div>

<div class="footer">© {{ date('Y') }} HotelBooking</div>
</body>
</html>

