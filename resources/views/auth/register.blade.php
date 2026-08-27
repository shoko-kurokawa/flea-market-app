@extends('layouts.app')

@section('title', '会員登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth">
        <div class="auth__inner">
            <h1 class="auth__heading">会員登録</h1>

            <form class="auth-form" method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="auth-form__group">
                    <label class="auth-form__label" for="name">
                        ユーザー名
                    </label>

                    <input class="auth-form__input" type="text" id="name" name="name" value="{{ old('name') }}">

                    @error('name')
                        <p class="auth-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="email">
                        メールアドレス
                    </label>

                    <input class="auth-form__input" type="text" id="email" name="email" value="{{ old('email') }}">

                    @error('email')
                        <p class="auth-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="password">
                        パスワード
                    </label>

                    <input class="auth-form__input" type="password" id="password" name="password">

                    @error('password')
                        <p class="auth-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="auth-form__group">
                    <label class="auth-form__label" for="password_confirmation">
                        確認用パスワード
                    </label>

                    <input class="auth-form__input" type="password" id="password_confirmation" name="password_confirmation">

                    @error('password_confirmation')
                        <p class="auth-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <button class="auth-form__button" type="submit">
                    登録する
                </button>

                <div class="auth-form__link">
                    <a href="{{ route('login') }}">ログインはこちら</a>
                </div>
            </form>
        </div>
    </div>
@endsection