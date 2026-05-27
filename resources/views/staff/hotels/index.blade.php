@extends('layouts.app-redesign')

@section('title','Отели вашей организации')

@section('content')
    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;">
            <div>
                <div style="font-weight:1000;font-size:22px;letter-spacing:-.02em;">🏨 Отели вашей организации</div>
                <div style="margin-top:8px;color:#64748b;font-weight:900;">Модерация и управление отелями</div>
            </div>
        </div>

        <div style="margin-top:14px;display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px;">
            @forelse($hotels as $hotel)
                <div class="panel" style="padding:14px 14px;background:rgba(255,255,255,.6);">
                    <div style="font-weight:1000;color:#0b1220;">{{ $hotel->name }}</div>
                    <div style="margin-top:6px;color:#64748b;font-weight:900;font-size:13px;">
                        {{ $hotel->city }}{{ $hotel->country ? ', ' . $hotel->country : '' }}
                    </div>
                    <a href="{{ route('staff.hotels.show', $hotel->id) }}" style="display:inline-block;margin-top:12px;background:rgba(79,107,255,.14);border:1px solid rgba(79,107,255,.25);color:#4f6bff;font-weight:1000;padding:10px 12px;border-radius:12px;text-decoration:none;">
                        Подробнее →
                    </a>
                </div>
            @empty
                <div class="panel" style="padding:20px 14px;background:rgba(255,255,255,.55);text-align:center;grid-column:1/-1;">
                    <div style="font-weight:1000;color:#334155;">Нет отелей для вашей организации.</div>
                </div>
            @endforelse
        </div>

        @if($hotels->hasPages())
            <div style="margin-top:16px;">
                {{ $hotels->links() }}
            </div>
        @endif
    </div>
@endsection

