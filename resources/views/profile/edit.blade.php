@extends('layouts.app-redesign')

@section('title','Редактирование профиля')

@section('content')
    <div class="panel" style="max-width:520px;margin:18px auto;padding:20px;">
        <div style="font-weight:1000;font-size:18px;letter-spacing:-.02em;margin-bottom:14px;">✏️ Редактирование профиля</div>

        @if ($errors->any())
            <div style="background:rgba(254,226,226,.95);color:#991b1b;border:1px solid rgba(248,113,113,.35);padding:12px 12px;border-radius:14px;margin-bottom:14px;font-weight:800;">
                @foreach ($errors->all() as $error)
                    <div style="margin:4px 0;">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="field" style="margin-bottom:14px;">
                <label>Имя</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="field" style="margin-bottom:14px;">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <hr style="border:0;border-top:1px solid rgba(2,6,23,.08);margin:14px 0;" />

            <div class="field" style="margin-bottom:14px;">
                <label>Новый пароль (оставьте пустым, чтобы не менять)</label>
                <input type="password" name="password">
                <div style="color:#64748b;font-weight:800;font-size:12px;margin-top:6px;">Минимум 6 символов</div>
            </div>

            <div class="field" style="margin-bottom:14px;">
                <label>Подтверждение пароля</label>
                <input type="password" name="password_confirmation">
            </div>

            <button type="submit" class="btn-filter" style="width:100%">Сохранить изменения</button>

            <a href="{{ route('profile.index') }}" class="btn-reset" style="width:100%;justify-content:center;margin-top:10px;">Отмена</a>
        </form>
    </div>
@endsection

