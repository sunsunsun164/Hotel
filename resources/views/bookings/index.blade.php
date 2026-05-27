{{-- Redesign: unified layout --}}
@extends('layouts.app-redesign')

@section('title','Мои бронирования')

@section('content')
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin:10px 0 14px;">
        <div style="font-size:18px;font-weight:1000;letter-spacing:-.02em;">📋 Мои бронирования</div>
    </div>

    @if(session('success'))
        <div class="panel" style="margin:12px 0;padding:14px 16px;border-radius:18px;background:rgba(209,250,229,.75);border-color:rgba(34,197,94,.25);color:#065f46;font-weight:950;">
            {{ session('success') }}
        </div>
    @endif

    <div>
        @forelse($bookings as $booking)
            <div class="panel" style="padding:14px 16px;margin:12px 0;background:rgba(255,255,255,.62);">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;flex-wrap:wrap;">
                    <div style="font-weight:1000;color:#0b1220;">{{ $booking->room->hotel->name ?? 'Отель' }}</div>
                    <div style="font-weight:950;font-size:12px;padding:7px 10px;border-radius:999px;background:rgba(100,116,139,.12);color:#334155;">
                        @if($booking->status == 'confirmed') ✅ Подтверждено
                        @elseif($booking->status == 'cancelled') ❌ Отменено
                        @elseif($booking->status == 'completed') ✔️ Завершено
                        @else ⏳ В ожидании
                        @endif
                    </div>
                </div>

                <div style="margin-top:10px;color:#64748b;font-weight:850;">
                    📅 {{ $booking->check_in->format('d.m.Y') }} — {{ $booking->check_out->format('d.m.Y') }} ({{ $booking->check_in->diffInDays($booking->check_out) }} ночей)
                </div>
                <div style="margin-top:8px;color:#64748b;font-weight:800;">
                    👥 Гостей: {{ $booking->guests }} • 🏨 Номер: {{ $booking->room->type ?? 'Стандарт' }} • 📍 {{ $booking->room->hotel->city ?? '' }}
                </div>
                <div style="margin-top:10px;color:#4f6bff;font-weight:1000;">💰 Стоимость: {{ number_format($booking->total_price, 0, '.', ' ') }} ₽</div>

                @if($booking->status == 'confirmed')
                    <form method="POST" action="{{ route('bookings.cancel', $booking->id) }}" style="margin-top:12px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-reset" style="border:none;background:rgba(239,68,68,.12);color:#b91c1c;font-weight:1000;">
                            Отменить
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="panel" style="margin:14px 0;padding:26px 16px;background:rgba(255,255,255,.55);text-align:center;">
                <div style="font-weight:1000;font-size:16px;">😕 У вас пока нет бронирований</div>
                <a href="/hotels" style="display:inline-block;margin-top:12px;color:#4f6bff;font-weight:1000;text-decoration:none;">Перейти к поиску отелей →</a>
            </div>
        @endforelse
    </div>
@endsection

