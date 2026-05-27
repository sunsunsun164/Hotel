{{-- Redesign: unified layout --}}
@extends('layouts.app-redesign')

@section('title','Модерация отзывов')

@section('content')
    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;">
            <div>
                <div style="font-weight:1000;font-size:22px;letter-spacing:-.02em;">📋 Модерация отзывов</div>
                @if(session('success'))
                    <div class="panel" style="margin-top:12px;padding:12px 14px;background:rgba(209,250,229,.75);border-color:rgba(34,197,94,.25);color:#065f46;font-weight:950;">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <a href="/" style="font-weight:1000;color:#4f6bff;text-decoration:none;">← На главную</a>
        </div>

        <div style="margin-top:14px;">
            @foreach($reviews as $review)
                <div class="panel" style="padding:14px 14px;background:rgba(255,255,255,.6);margin:12px 0;">
                    <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:center;">
                        <div>
                            <div style="font-weight:1000;color:#0b1220;">{{ $review->hotel->name }}</div>
                            <div style="margin-top:4px;color:#64748b;font-weight:900;font-size:13px;">от {{ $review->user->name }}</div>
                        </div>

                        <div>
                            @if($review->is_approved)
                                <div style="padding:7px 10px;border-radius:999px;background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);font-weight:1000;color:#065f46;font-size:12px;">
                                    ✅ Опубликован
                                </div>
                            @else
                                <div style="padding:7px 10px;border-radius:999px;background:rgba(245,158,11,.14);border:1px solid rgba(245,158,11,.28);font-weight:1000;color:#92400e;font-size:12px;">
                                    ⏳ На модерации
                                </div>
                            @endif
                        </div>
                    </div>

                    <div style="margin-top:10px;color:#f59e0b;font-weight:1000;">
                        @for($i=1;$i<=5;$i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                        <span style="color:#64748b;font-weight:1000;font-size:12px;">({{ $review->rating }}/5)</span>
                    </div>

                    <div style="margin-top:10px;color:#334155;font-weight:850;">{{ $review->comment }}</div>

                    <div style="margin-top:8px;color:#94a3b8;font-weight:900;font-size:12px;">
                        {{ $review->created_at->format('d.m.Y H:i') }}
                    </div>

                    @if(!$review->is_approved)
                        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px;">
                            <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="border:none;background:rgba(16,185,129,.15);color:#065f46;font-weight:1000;padding:10px 12px;border-radius:12px;cursor:pointer;">
                                    ✅ Одобрить
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Удалить отзыв без публикации?')" style="border:none;background:rgba(239,68,68,.14);color:#991b1b;font-weight:1000;padding:10px 12px;border-radius:12px;cursor:pointer;">
                                    ❌ Отклонить
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div style="margin-top:12px;">
            {{ $reviews->links() }}
        </div>
    </div>
@endsection

