<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронирование номера {{ $room->room_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 { margin-bottom: 1rem; }
        .hotel-name {
            color: #2563eb;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.25rem; font-weight: 500; }
        input, textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-back {
            background: #6b7280;
            margin-top: 0.5rem;
        }
        .error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2563eb;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>📅 Бронирование</h1>
        <div class="hotel-name">
            {{ $room->hotel->name }} — Номер {{ $room->room_number }}
        </div>
        <p>Тип: {{ $room->type }}</p>
        <p>Вместимость: {{ $room->capacity }} чел.</p>
        <div class="price">{{ number_format($room->price_per_night, 0) }} ₽ / ночь</div>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="error">{{ $error }}</div>
            @endforeach
        @endif

        <form method="POST" action="{{ route('bookings.store', $room->id) }}">
            @csrf
            
            <div class="form-group">
                <label>Дата заезда:</label>
                <input type="date" name="check_in" required min="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label>Дата выезда:</label>
                <input type="date" name="check_out" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>

            <div class="form-group">
                <label>Количество гостей:</label>
                <input type="number" name="guests" min="1" max="{{ $room->capacity }}" value="2" required>
            </div>

            <div class="form-group">
                <label>Особые пожелания (необязательно):</label>
                <textarea name="special_requests" rows="3" placeholder="Например: нужна детская кроватка, веганское меню..."></textarea>
            </div>

            <button type="submit">Подтвердить бронирование</button>
            <a href="{{ url()->previous() }}" class="btn-back" style="display: block; text-align: center; text-decoration: none; margin-top: 0.5rem; color: white; background: #6b7280; padding: 0.75rem; border-radius: 0.5rem;">Назад</a>
        </form>
    </div>
</body>
</html>