@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth">
        <div class="auth__inner">
            <h1 class="auth__heading">ログイン</h1>

            <form class="auth-form" method="POST" action="{{ route('login.store') }}">
                @csrf

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

                <button class="auth-form__button" type="submit">
                    ログインする
                </button>

                <div class="auth-form__link">
                    <a href="{{ route('register') }}">会員登録はこちら</a>
                </div>
            </form>
        </div>
    </div>
@endsection