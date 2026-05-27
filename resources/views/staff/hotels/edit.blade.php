@extends('layouts.app-redesign')

@section('title','Редактирование отеля')

@section('content')
    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;">
            <a href="{{ route('staff.hotels.index') }}" style="font-weight:1000;color:#4f6bff;text-decoration:none;">← К списку</a>
            <a href="{{ route('staff.hotels.show', $hotel->id) }}" style="display:inline-block;background:rgba(79,107,255,.14);border:1px solid rgba(79,107,255,.25);color:#4f6bff;font-weight:1000;padding:10px 12px;border-radius:12px;text-decoration:none;">
                Просмотр
            </a>
        </div>

        @if(session('success'))
            <div class="panel" style="margin-top:12px;padding:12px 14px;background:rgba(209,250,229,.75);border-color:rgba(34,197,94,.25);color:#065f46;font-weight:950;">
                {{ session('success') }}
            </div>
        @endif

        <div class="panel" style="margin-top:14px;padding:14px 14px;background:rgba(255,255,255,.6);">
            <div style="font-weight:1000;font-size:20px;margin-bottom:12px;">🏨 Редактирование: {{ $hotel->name }}</div>

            <form method="POST" action="{{ route('staff.hotels.update', $hotel->id) }}">
                @csrf
                @method('PUT')

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;">
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Название</label>
                        <input name="name" value="{{ old('name', $hotel->name) }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                    </div>
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Город</label>
                        <input name="city" value="{{ old('city', $hotel->city) }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                    </div>
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Страна</label>
                        <input name="country" value="{{ old('country', $hotel->country) }}" style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                    </div>
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Адрес</label>
                        <input name="address" value="{{ old('address', $hotel->address) }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                    </div>
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Звёзды</label>
                        <select name="stars" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;">
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}" {{ (int)old('stars', $hotel->stars) === $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Цена за ночь</label>
                        <input type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night', $hotel->price_per_night) }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                    </div>

                    @if(Auth::user() && Auth::user()->is_admin)
                        <div style="grid-column:1/-1;">
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Организация (admin)</label>
                            <input type="number" name="organization_id" value="{{ old('organization_id', $hotel->organization_id) }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                            <div style="margin-top:6px;color:#64748b;font-weight:800;font-size:12px;">Укажи organization_id (например 1/2).</div>
                        </div>
                    @endif

                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Телефон</label>
                        <input name="phone" value="{{ old('phone', $hotel->phone) }}" style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                    </div>
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Email</label>
                        <input type="email" name="email" value="{{ old('email', $hotel->email) }}" style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                    </div>
                    <div style="grid-column:1/-1;">
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Описание</label>
                        <textarea name="description" style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;min-height:96px;">{{ old('description', $hotel->description) }}</textarea>
                    </div>
                    <div>
                        <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Доступность</label>
                        <select name="is_available" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;">
                            <option value="1" {{ (old('is_available') ?? (int)$hotel->is_available) == 1 ? 'selected' : '' }}>Доступен</option>
                            <option value="0" {{ (old('is_available') ?? (int)$hotel->is_available) == 0 ? 'selected' : '' }}>Не доступен</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <button type="submit" style="border:none;background:#4f6bff;color:white;font-weight:1000;padding:12px 14px;border-radius:12px;cursor:pointer;width:auto;">💾 Сохранить отель</button>
                </div>
            </form>

            <div style="margin-top:18px;border-top:1px solid rgba(2,6,23,.08);padding-top:14px;">
                <div style="font-weight:1000;font-size:18px;margin-bottom:12px;">➕ Добавить комнату</div>

                <form method="POST" action="{{ route('staff.rooms.store', $hotel->id) }}">
                    @csrf
                    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;">
                        <div>
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Номер</label>
                            <input name="room_number" value="{{ old('room_number') }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                        </div>
                        <div>
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Тип</label>
                            <input name="type" value="{{ old('type') }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;" placeholder="standard / deluxe ..."/>
                        </div>
                        <div>
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Цена за ночь</label>
                            <input type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night') }}" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                        </div>
                        <div>
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Вместимость</label>
                            <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                        </div>
                        <div style="grid-column:1/-1;">
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Описание</label>
                            <textarea name="description" style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;min-height:96px;">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Доступность</label>
                            <select name="is_available" required style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;">
                                <option value="1" {{ (old('is_available') ?? '1') == '1' ? 'selected' : '' }}>Доступна</option>
                                <option value="0" {{ (old('is_available') ?? '1') == '0' ? 'selected' : '' }}>Недоступна</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block;font-weight:900;color:#334155;font-size:13px;margin-bottom:6px;">Image (URL/путь)</label>
                            <input name="image" value="{{ old('image') }}" style="width:100%;border:1px solid rgba(2,6,23,.12);border-radius:12px;padding:10px 12px;background:rgba(255,255,255,.9);font-weight:800;"/>
                        </div>
                    </div>

                    <div style="margin-top:14px;">
                        <button type="submit" style="border:none;background:rgba(34,197,94,.16);color:#065f46;font-weight:1000;padding:12px 14px;border-radius:12px;cursor:pointer;">➕ Добавить комнату</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

