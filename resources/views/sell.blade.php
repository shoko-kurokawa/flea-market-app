@extends('layouts.app')

@section('title', '商品出品')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="sell">
        <div class="sell__inner">

            <h1 class="sell__heading">
                商品の出品
            </h1>

            <form
                class="sell__form"
                action="{{ route('sell.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                {{-- 商品画像 --}}
                <div class="sell__group">
                    <label class="sell__label">
                        商品画像
                    </label>

                    <div class="sell__image-area">
                        <label class="sell__image-button" for="image">
                            画像を選択する
                        </label>

                        <input
                            class="sell__image-input"
                            id="image"
                            type="file"
                            name="image"
                            accept="image/jpeg,image/png"
                        >
                    </div>

                    @error('image')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <h2 class="sell__subheading">
                    商品の詳細
                </h2>

                {{-- カテゴリー --}}
                <div class="sell__group">
                    <label class="sell__label">
                        カテゴリー
                    </label>

                    <div class="sell__categories">
                        @foreach ($categories as $category)
                            <label class="sell__category">
                                <input
                                    class="sell__category-input"
                                    type="checkbox"
                                    name="category_ids[]"
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}
                                >

                                <span class="sell__category-text">
                                    {{ $category->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>

                    @error('category_ids')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror

                    @error('category_ids.*')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 商品状態 --}}
                <div class="sell__group">
                    <label class="sell__label" for="condition">
                        商品の状態
                    </label>

                    <select
                        class="sell__select"
                        id="condition"
                        name="condition"
                    >
                        <option value="">
                            選択してください
                        </option>

                        <option value="良好" {{ old('condition') === '良好' ? 'selected' : '' }}>
                            良好
                        </option>

                        <option value="目立った傷や汚れなし"
                            {{ old('condition') === '目立った傷や汚れなし' ? 'selected' : '' }}>
                            目立った傷や汚れなし
                        </option>

                        <option value="やや傷や汚れあり"
                            {{ old('condition') === 'やや傷や汚れあり' ? 'selected' : '' }}>
                            やや傷や汚れあり
                        </option>

                        <option value="状態が悪い"
                            {{ old('condition') === '状態が悪い' ? 'selected' : '' }}>
                            状態が悪い
                        </option>
                    </select>

                    @error('condition')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <h2 class="sell__subheading">
                    商品名と説明
                </h2>

                {{-- 商品名 --}}
                <div class="sell__group">
                    <label class="sell__label" for="name">
                        商品名
                    </label>

                    <input
                        class="sell__input"
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                    >

                    @error('name')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- ブランド名 --}}
                <div class="sell__group">
                    <label class="sell__label" for="brand_name">
                        ブランド名
                    </label>

                    <input
                        class="sell__input"
                        id="brand_name"
                        type="text"
                        name="brand_name"
                        value="{{ old('brand_name') }}"
                    >

                    @error('brand_name')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 商品説明 --}}
                <div class="sell__group">
                    <label class="sell__label" for="description">
                        商品の説明
                    </label>

                    <textarea
                        class="sell__textarea"
                        id="description"
                        name="description"
                        rows="6"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 価格 --}}
                <div class="sell__group">
                    <label class="sell__label" for="price">
                        販売価格
                    </label>

                    <div class="sell__price-wrapper">
                        <span class="sell__price-symbol">
                            ¥
                        </span>

                        <input
                            class="sell__price-input"
                            id="price"
                            type="number"
                            name="price"
                            min="1"
                            value="{{ old('price') }}"
                        >
                    </div>

                    @error('price')
                        <p class="sell__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button
                    class="sell__button"
                    type="submit"
                >
                    出品する
                </button>

            </form>
        </div>
    </div>
@endsection