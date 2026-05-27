@extends('layouts.app-redesign')

@section('title','Создание отеля')

@section('content')
    <div class="panel" style="padding:18px 18px;margin:16px 0;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;">
            <div>
                <div style="font-weight:1000;font-size:22px;letter-spacing:-.02em;">➕ Создать отель</div>
                <div style="margin-top:8px;color:#64748b;font-weight:900;">Выберите организацию и заполните данные отеля</div>
            </div>
            <a href="/" style="font-weight:1000;color:#4f6bff;text-decoration:none;">← На главную</a>
        </div>

        @if(session('success'))
            <div class="panel" style="margin-top:14px;padding:12px 14px;background:rgba(209,250,229,.75);border-color:rgba(34,197,94,.25);color:#065f46;font-weight:950;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="panel" style="margin-top:14px;padding:12px 14px;background:rgba(254,226,226,.85);border-color:rgba(239,68,68,.25);color:#991b1b;font-weight:950;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.hotels.store') }}" enctype="multipart/form-data" style="margin-top:14px;">
            @csrf

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;">
                <div style="grid-column:1/-1;">
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">🏢 Организация</label>
                    <select name="organization_id" required style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;">
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}">{{ $organization->name }} (ID: {{ $organization->id }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Название</label>
                    <input name="name" value="{{ old('name') }}" required style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Город</label>
                    <input name="city" value="{{ old('city') }}" required style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Страна</label>
                    <input name="country" value="{{ old('country') }}" style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Адрес</label>
                    <input name="address" value="{{ old('address') }}" required style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Звёзды</label>
                    <select name="stars" required style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;">
                        @for($i=1;$i<=5;$i++)
                            <option value="{{ $i }}" {{ old('stars') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Цена за ночь</label>
                    <input type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night') }}" required min="0" style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Телефон</label>
                    <input name="phone" value="{{ old('phone') }}" style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                </div>

                <div>
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Image (картинка)</label>

                    <div style="display:flex;gap:12px;align-items:flex-start;flex-wrap:wrap;">
                        <div style="min-width:220px;flex:1;">
                            <div style="color:#334155;font-weight:1000;font-size:12px;margin-bottom:6px;">Выберите из: <b>pictures</b></div>
                            <select name="image_picture" style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;">
                                <option value="">— не выбирать —</option>
                                <option value="HotelLaravel.jpg" {{ old('image_picture') === 'HotelLaravel.jpg' ? 'selected' : '' }}>HotelLaravel.jpg</option>
                            </select>

                            <div style="margin-top:10px;">
                                <div style="color:#64748b;font-weight:850;font-size:12px;">Просмотр:</div>
                                <div style="margin-top:8px;">
                                    <img
                                        src="/pictures/{{ old('image_picture','HotelLaravel.jpg') }}"
                                        alt="preview"
                                        style="max-width:100%;height:auto;border-radius:12px;border:1px solid rgba(2,6,23,.10);background:rgba(255,255,255,.6);" />
                                </div>
                            </div>
                        </div>

                        <div style="min-width:260px;flex:1;">
                            <div style="color:#334155;font-weight:1000;font-size:12px;margin-bottom:6px;">или загрузите файл</div>
                            <input type="file" name="image_file" accept="image/*" style="width:100%;padding:8px 0;font-weight:900;"/>

                            <div style="margin-top:8px;color:#64748b;font-weight:850;font-size:12px;">
                                Если выбрана картинка — сохранится в <b>public/storage/hotels</b> и путь запишется в <b>image</b>.
                            </div>

                            <div style="margin-top:10px;">
                                <label style="display:block;color:#334155;font-weight:900;font-size:12px;margin-bottom:6px;">или путь/URL</label>
                                <input name="image" value="{{ old('image') }}" style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="grid-column:1/-1;">
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Доступность</label>
                    <select name="is_available" required style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:900;">
                        <option value="1" {{ old('is_available') === '1' ? 'selected' : '' }}>Доступен</option>
                        <option value="0" {{ old('is_available') === '0' ? 'selected' : '' }}>Не доступен</option>
                    </select>
                </div>

                <div style="grid-column:1/-1;">
                    <label style="display:block;font-weight:1000;color:#334155;margin-bottom:6px;">Описание</label>
                    <textarea name="description" rows="4" style="width:100%;padding:12px 12px;border-radius:12px;border:1px solid rgba(2,6,23,.12);background:rgba(255,255,255,.9);font-weight:800;">{{ old('description') }}</textarea>
                </div>
            </div>

            <div style="margin-top:14px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                <button type="submit" style="border:none;background:linear-gradient(90deg,#5b7cfa,#3b82f6);color:white;font-weight:1000;padding:12px 14px;border-radius:14px;cursor:pointer;">
                    ✅ Создать отель
                </button>

                <a href="/" style="font-weight:1000;color:#4f6bff;text-decoration:none;padding:12px 14px;border-radius:14px;border:1px solid rgba(79,107,255,.25);background:rgba(79,107,255,.08);">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection

