@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="profile">
        <div class="profile__inner">
            <h1 class="profile__heading">プロフィール設定</h1>

            <form class="profile-form" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="profile-form__image">
                    <div class="profile-form__image-preview"></div>

                    <label class="profile-form__image-button" for="profile_image">
                        画像を選択する
                    </label>

                    <input class="profile-form__image-input" type="file" id="profile_image" name="profile_image"
                        accept=".jpeg,.jpg,.png">
                </div>

                @error('profile_image')
                    <p class="profile-form__error">{{ $message }}</p>
                @enderror

                <div class="profile-form__group">
                    <label class="profile-form__label" for="name">
                        ユーザー名
                    </label>

                    <input class="profile-form__input" type="text" id="name" name="name"
                        value="{{ old('name', auth()->user()->name) }}">

                    @error('name')
                        <p class="profile-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="profile-form__group">
                    <label class="profile-form__label" for="postal_code">
                        郵便番号
                    </label>

                    <input class="profile-form__input" type="text" id="postal_code" name="postal_code"
                        value="{{ old('postal_code') }}">

                    @error('postal_code')
                        <p class="profile-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="profile-form__group">
                    <label class="profile-form__label" for="address">
                        住所
                    </label>

                    <input class="profile-form__input" type="text" id="address" name="address" value="{{ old('address') }}">

                    @error('address')
                        <p class="profile-form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="profile-form__group">
                    <label class="profile-form__label" for="building">
                        建物名
                    </label>

                    <input class="profile-form__input" type="text" id="building" name="building"
                        value="{{ old('building') }}">
                </div>

                <button class="profile-form__button" type="submit">
                    更新する
                </button>
            </form>
        </div>
    </div>
@endsection