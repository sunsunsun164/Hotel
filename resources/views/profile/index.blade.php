@extends('layouts.app-redesign')

@section('title', 'Личный кабинет - '.$user->name)

@section('content')
    @if(session('success'))
        <div class="panel" style="margin:12px 0;border-radius:18px;background:rgba(209,250,229,.75);border-color:rgba(34,197,94,.25);color:#065f46;font-weight:950;padding:14px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="panel" style="padding:18px;margin:16px 0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;">
            <div>
                <div style="font-size:20px;font-weight:1000;letter-spacing:-.02em;">👤 {{ $user->name }}</div>
                <div style="color:#64748b;font-weight:850;margin-top:6px;">{{ $user->email }}</div>
                <div style="color:#64748b;font-weight:800;margin-top:10px;">🗓️ Зарегистрирован: {{ $user->created_at->format('d.m.Y') }}</div>
                @if($user->organization_id)
                    <div style="color:#64748b;font-weight:800;margin-top:8px;">🏢 Организация ID: {{ $user->organization_id }}</div>
                @endif
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;">
                @if($user->organization_id)
                    <a href="{{ route('staff.hotels.index') }}" class="btn" style="background:linear-gradient(90deg,#22c55e,#16a34a)">🛠️ Модерация отелей</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="btn">✏️ Редактировать профиль</a>
            </div>
        </div>
    </div>

    <div class="panel" style="padding:18px;margin:16px 0;">
        <div style="font-weight:1000;font-size:18px;margin-bottom:14px;">📋 История бронирований</div>
        @forelse($bookings as $booking)
            <div class="panel" style="padding:14px;margin:12px 0;background:rgba(255,255,255,.6)">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
                    <div style="font-weight:1000;color:#0b1220;">{{ $booking->room->hotel->name ?? 'Отель' }}</div>
                    <div style="font-weight:950;font-size:12px;padding:6px 10px;border-radius:999px;background:rgba(100,116,139,.12);color:#334155;">
                        @if($booking->status == 'confirmed') ✅ Подтверждено
                        @elseif($booking->status == 'cancelled') ❌ Отменено
                        @elseif($booking->status == 'completed') ✔️ Завершено
                        @else ⏳ В ожидании
                        @endif
                    </div>
                </div>
                <div style="color:#64748b;font-weight:850;margin-top:10px;">
                    📅 {{ $booking->check_in->format('d.m.Y') }} — {{ $booking->check_out->format('d.m.Y') }} ({{ $booking->check_in->diffInDays($booking->check_out) }} ночей)
                </div>
                <div style="color:#64748b;font-weight:800;margin-top:8px;">
                    👥 Гостей: {{ $booking->guests }} • 🏨 Номер: {{ $booking->room->type ?? 'Стандарт' }} • 📍 {{ $booking->room->hotel->city ?? '' }}
                </div>
                <div style="color:#4f6bff;font-weight:1000;margin-top:10px;">💰 Стоимость: {{ number_format($booking->total_price, 0, '.', ' ') }} ₽</div>
            </div>
        @empty
            <div class="empty-state" style="background:transparent;">
                <div style="font-weight:950;">😕 У вас пока нет бронирований</div>
                <a href="/hotels" style="margin-top:10px;display:inline-block;">Перейти к поиску отелей →</a>
            </div>
        @endforelse
    </div>

    <div class="panel" style="padding:18px;margin:16px 0;">
        <div style="font-weight:1000;font-size:18px;margin-bottom:14px;">⭐ Мои отзывы</div>
        @forelse($reviews as $review)
            <div class="panel" style="padding:14px;margin:12px 0;background:rgba(255,255,255,.6)">
                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;">
                    <div style="font-weight:1000;">{{ $review->hotel->name ?? 'Отель' }}</div>
                    <div style="color:#94a3b8;font-weight:850;font-size:12px;">{{ $review->created_at->format('d.m.Y') }}</div>
                </div>
                <div style="color:#f59e0b;font-weight:950;margin-top:8px;">
                    @for($i=1;$i<=5;$i++)
                        {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                    <span style="color:#64748b;font-size:12px;">({{ $review->rating }}/5)</span>
                </div>
                <div style="color:#334155;font-weight:800;margin-top:8px;">{{ $review->comment }}</div>
            </div>
        @empty
            <div class="empty-state" style="background:transparent;">
                <div style="font-weight:950;">😕 Вы ещё не оставляли отзывы</div>
                <a href="/hotels" style="margin-top:10px;display:inline-block;">Посетите отели и оставьте отзыв →</a>
            </div>
        @endforelse
    </div>
@endsection

