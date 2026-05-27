@extends('layouts.app-redesign')

@section('title', $hotel->name)

@section('content')
    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;">
            <a href="{{ route('staff.hotels.index') }}" style="font-weight:1000;color:#4f6bff;text-decoration:none;">← К списку</a>
            @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('staff.hotels.edit', $hotel->id) }}" style="display:inline-block;background:#16a34a;color:white;font-weight:1000;padding:10px 12px;border-radius:12px;text-decoration:none;">
                    ✏️ Редактировать (admin)
                </a>
            @endif




        </div>

        <div class="panel" style="padding:14px 14px;margin-top:14px;background:rgba(255,255,255,.6);">
            <div style="font-weight:1000;font-size:22px;">🏨 {{ $hotel->name }}</div>
            <div style="margin-top:6px;color:#64748b;font-weight:900;">
                {{ $hotel->city }}{{ $hotel->country ? ', ' . $hotel->country : '' }}
            </div>
            @if($hotel->address)
                <div style="margin-top:8px;color:#64748b;font-weight:900;">📍 {{ $hotel->address }}</div>
            @endif
            @if($hotel->description)
                <div style="margin-top:10px;color:#334155;font-weight:850;">{{ $hotel->description }}</div>
            @endif
        </div>

        <div class="panel" style="padding:14px 14px;margin-top:14px;background:rgba(255,255,255,.6);">
            <div style="font-weight:1000;font-size:18px;margin-bottom:10px;">🛏️ Номера</div>
            @forelse($hotel->rooms as $room)
                <div class="panel" style="padding:12px 12px;margin:10px 0;background:rgba(255,255,255,.55);">
                    <div style="font-weight:1000;">{{ $room->room_number }} ({{ $room->type }})</div>
                    <div style="margin-top:6px;color:#64748b;font-weight:900;font-size:13px;">
                        Цена: {{ number_format($room->price_per_night, 2, '.', ' ') }} ₽
                    </div>
                </div>
            @empty
                <div style="color:#64748b;font-weight:900;">У этой организации пока нет номеров.</div>
            @endforelse
        </div>
    </div>
@endsection

