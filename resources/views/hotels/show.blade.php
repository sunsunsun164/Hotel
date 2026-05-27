@extends('layouts.app-redesign')

@section('title', $hotel->name.' - бронирование')

@section('content')
    @if(session('success'))
        <div class="panel" style="margin:12px 0;padding:14px 16px;border-radius:18px;background:rgba(209,250,229,.75);border-color:rgba(34,197,94,.25);color:#065f46;font-weight:950;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="panel" style="margin:12px 0;padding:14px 16px;border-radius:18px;background:rgba(254,226,226,.8);border-color:rgba(239,68,68,.25);color:#991b1b;font-weight:950;">
            {{ session('error') }}
        </div>
    @endif

    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;">
            <div>
                <div style="font-weight:1000;font-size:28px;letter-spacing:-.03em;">{{ $hotel->name }}</div>
                <div style="margin-top:6px;color:#f59e0b;font-weight:1000;">
                    @for($i=1;$i<=5;$i++)
                        {{ $i <= $hotel->stars ? '★' : '☆' }}
                    @endfor
                    <span style="color:#94a3b8;font-weight:900;font-size:12px;">({{ $hotel->stars }} звёзд)</span>
                </div>
                <div style="margin-top:10px;color:#334155;font-weight:900;">
                    📍 {{ $hotel->city }}{{ $hotel->country ? ', '.$hotel->country : '' }}
                </div>
                <div style="margin-top:8px;color:#64748b;font-weight:850;">
                    🏠 {{ $hotel->address }}
                </div>
            </div>
            <div style="min-width:260px;">
                <div style="font-weight:1000;font-size:22px;color:#4f6bff;">от {{ number_format($hotel->price_per_night, 0, '.', ' ') }} ₽ / ночь</div>
                @auth
                    <div style="margin-top:10px;">
                        @if($hotel->is_available)
                            <div style="padding:8px 12px;border-radius:999px;background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.25);color:#065f46;font-weight:1000;font-size:12px;display:inline-block;">
                                ✅ Отель доступен
                            </div>
                        @else
                            <div style="padding:8px 12px;border-radius:999px;background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.25);color:#991b1b;font-weight:1000;font-size:12px;display:inline-block;">
                                ⛔ Временно недоступен
                            </div>
                        @endif
                    </div>
                @endauth
            </div>
        </div>

        @if($hotel->description)
            <div style="margin-top:14px;color:#334155;font-weight:800;">📝 {{ $hotel->description }}</div>
        @endif
        <div style="margin-top:10px;display:flex;gap:14px;flex-wrap:wrap;">
            <div style="color:#64748b;font-weight:900;">📞 {{ $hotel->phone ?? '—' }}</div>
            <div style="color:#64748b;font-weight:900;">✉️ {{ $hotel->email ?? '—' }}</div>
        </div>
    </div>

    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="font-weight:1000;font-size:18px;margin-bottom:14px;">🏠 Наши номера</div>

        @if($hotel->rooms && $hotel->rooms->count() > 0)
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;">
                @foreach($hotel->rooms as $room)
                    <div class="panel" style="padding:14px 14px;background:rgba(255,255,255,.55);">
                        <div style="font-weight:1000;color:#0b1220;">Номер {{ $room->room_number }}</div>
                        <div style="margin-top:6px;color:#334155;font-weight:900;">{{ $room->type }}</div>
                        <div style="margin-top:8px;color:#64748b;font-weight:850;">Вместимость: {{ $room->capacity }} чел.</div>
                        @if($room->description)
                            <div style="margin-top:8px;color:#334155;font-weight:800;">{{ $room->description }}</div>
                        @endif
                        <div style="margin-top:12px;font-weight:1000;color:#4f6bff;">{{ number_format($room->price_per_night, 0, '.', ' ') }} ₽ / ночь</div>
                        @auth
                            <a href="{{ route('bookings.create', $room->id) }}" class="btn" style="display:inline-block;margin-top:10px;">Забронировать</a>
                        @else
                            <a href="{{ route('login') }}" class="btn" style="display:inline-block;margin-top:10px;">Войдите для бронирования</a>
                        @endauth
                    </div>
                @endforeach
            </div>
        @else
            <div style="padding:20px;text-align:center;">
                <div style="font-weight:1000;">😕 Номера временно отсутствуют</div>
                <div style="margin-top:8px;color:#64748b;font-weight:900;font-size:12px;">Скоро появятся новые предложения</div>
            </div>
        @endif
    </div>

    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="font-weight:1000;font-size:18px;margin-bottom:14px;">⭐ Отзывы гостей</div>

        @auth
            @if(!$userReview)
                <div class="panel" style="padding:14px 14px;background:rgba(243,244,246,.55);margin-bottom:16px;">
                    <div style="font-weight:1000;">✏️ Оставить отзыв</div>
                    <div style="margin-top:6px;color:#64748b;font-weight:900;font-size:12px;">Опубликован будет после проверки модератором</div>

                    <form method="POST" action="{{ route('reviews.store', $hotel->id) }}" style="margin-top:12px;">
                        @csrf
                        <div style="margin-bottom:10px;">
                            <label style="font-weight:900;color:#334155;">Оценка (1-5)</label>
                            <select name="rating" required style="width:100%;padding:10px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:800;">
                                @for($i=5;$i>=1;$i--)
                                    <option value="{{ $i }}">{{ $i }} - {{ $i==5?'Отлично':($i==4?'Хорошо':($i==3?'Нормально':($i==2?'Плохо':'Ужасно'))) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div style="margin-bottom:10px;">
                            <label style="font-weight:900;color:#334155;">Ваш отзыв</label>
                            <textarea name="comment" rows="3" required placeholder="Поделитесь впечатлениями..." style="width:100%;padding:10px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:700;"></textarea>
                        </div>
                        <button type="submit" class="btn-filter" style="width:auto;">Отправить на модерацию</button>
                    </form>
                </div>
            @else
                <div class="panel" style="padding:14px 14px;background:rgba(209,250,229,.75);border-color:rgba(34,197,94,.25);margin-bottom:16px;">
                    <div style="font-weight:1000;">✅ Вы уже оставили отзыв. Спасибо!</div>
                    @if(!$userReview->is_approved)
                        <div style="margin-top:8px;color:#065f46;font-weight:900;font-size:12px;">⏳ Ваш отзыв проходит модерацию. Он появится после проверки администратором.</div>
                    @endif
                </div>
            @endif
        @else
            <div class="panel" style="padding:12px 14px;background:rgba(219,234,254,.9);border-color:rgba(191,219,254,.7);margin-bottom:16px;">
                <a href="{{ route('login') }}" style="color:#1e40af;font-weight:1000;">Войдите</a>, чтобы оставить отзыв
            </div>
        @endauth

        <div style="margin-top:8px;">
            @php
                $approvedReviews = $hotel->reviews->where('is_approved', true);
            @endphp

            @forelse($approvedReviews as $review)
                <div class="panel" style="padding:14px 14px;background:rgba(255,255,255,.55);margin-bottom:12px;">
                    <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:center;">
                        <div style="font-weight:1000;">{{ $review->user->name }}</div>
                        <div style="color:#94a3b8;font-weight:900;font-size:12px;">{{ $review->created_at->format('d.m.Y') }}</div>
                    </div>
                    <div style="margin-top:8px;color:#f59e0b;font-weight:1000;">
                        @for($i=1;$i<=5;$i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                        <span style="color:#64748b;font-weight:900;font-size:12px;">({{ $review->rating }}/5)</span>
                    </div>
                    <div style="margin-top:8px;color:#334155;font-weight:850;">{{ $review->comment }}</div>
                </div>
            @empty
                <div style="padding:20px;text-align:center;">
                    <div style="font-weight:1000;">📝 Пока нет опубликованных отзывов</div>
                    <div style="margin-top:8px;color:#64748b;font-weight:900;font-size:12px;">Будьте первым, кто оценит этот отель!</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

