@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="item-detail">
        <div class="item-detail__inner">

            {{-- 商品画像 --}}
            <div class="item-detail__image-area">
                @if ($product->images->isNotEmpty())
                    <img class="item-detail__image" src="{{ $product->images->first()->image_path }}"
                        alt="{{ $product->name }}">
                @endif
            </div>

            {{-- 商品情報 --}}
            <div class="item-detail__content">

                <h1 class="item-detail__name">
                    {{ $product->name }}
                </h1>

                @if ($product->brand_name)
                    <p class="item-detail__brand">
                        {{ $product->brand_name }}
                    </p>
                @endif

                <p class="item-detail__price">
                    ¥{{ number_format($product->price) }}
                    <span>（税込）</span>
                </p>

                {{-- いいね・コメント数 --}}
                <div class="item-detail__actions">

                    {{-- いいね --}}
                    <div class="item-detail__action">
                        @auth
                            @php
                                $isLiked = $product->likes->contains('user_id', auth()->id());
                            @endphp

                            @if ($isLiked)
                                <form action="{{ route('likes.destroy', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button class="item-detail__like-button item-detail__like-button--liked" type="submit">
                                        ♥
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('likes.store', $product) }}" method="POST">
                                    @csrf

                                    <button class="item-detail__like-button" type="submit">
                                        ♡
                                    </button>
                                </form>
                            @endif
                        @else
                            <span class="item-detail__like-icon">
                                ♡
                            </span>
                        @endauth

                        <span class="item-detail__action-count">
                            {{ $product->likes->count() }}
                        </span>
                    </div>

                    {{-- コメント数 --}}
                    <div class="item-detail__action">
                        <span class="item-detail__comment-icon">
                            💬
                        </span>

                        <span class="item-detail__action-count">
                            {{ $product->comments->count() }}
                        </span>
                    </div>

                </div>

                {{-- 購入ボタン --}}
                @if ($product->purchase)
                    <p class="item-detail__sold">
                        SOLD
                    </p>
                @else
                    <a class="item-detail__purchase-button" href="{{ route('purchase.create', $product) }}">
                        購入手続きへ
                    </a>
                @endif

                {{-- 商品説明 --}}
                <section class="item-detail__section">
                    <h2 class="item-detail__heading">
                        商品説明
                    </h2>

                    <p class="item-detail__description">
                        {{ $product->description }}
                    </p>
                </section>

                {{-- 商品情報 --}}
                <section class="item-detail__section">
                    <h2 class="item-detail__heading">
                        商品の情報
                    </h2>

                    <div class="item-detail__info">
                        <p class="item-detail__info-label">
                            商品のカテゴリー
                        </p>

                        <div class="item-detail__categories">
                            @foreach ($product->categories as $category)
                                <span class="item-detail__category">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="item-detail__info">
                        <p class="item-detail__info-label">
                            商品の状態
                        </p>

                        <p>
                            {{ $product->condition }}
                        </p>
                    </div>
                </section>

                {{-- コメント一覧 --}}
                <section class="item-detail__section">
                    <h2 class="item-detail__heading">
                        コメント（{{ $product->comments->count() }}）
                    </h2>

                    @forelse ($product->comments as $comment)
                        <div class="item-detail__comment">

                            <div class="item-detail__comment-user">
                                <div class="item-detail__comment-user-image">
                                    @if ($comment->user->profile_image)
                                        <img class="item-detail__comment-image"
                                            src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                            alt="{{ $comment->user->name }}">
                                    @endif
                                </div>

                                <span>
                                    {{ $comment->user->name }}
                                </span>
                            </div>

                            <p class="item-detail__comment-content">
                                {{ $comment->content }}
                            </p>

                        </div>
                    @empty
                        <p>コメントはありません。</p>
                    @endforelse
                </section>

                {{-- コメント投稿 --}}
                <section class="item-detail__section">
                    <h2 class="item-detail__comment-heading">
                        商品へのコメント
                    </h2>

                    @auth
                        <form class="item-detail__comment-form" action="{{ route('comments.store', $product) }}" method="POST">
                            @csrf

                            <textarea class="item-detail__comment-textarea" name="comment"
                                rows="5">{{ old('comment') }}</textarea>

                            @error('comment')
                                <p class="item-detail__error">
                                    {{ $message }}
                                </p>
                            @enderror

                            <button class="item-detail__comment-button" type="submit">
                                コメントを送信する
                            </button>
                        </form>
                    @else
                        <p>
                            コメントを投稿するにはログインしてください。
                        </p>
                    @endauth
                </section>

            </div>

        </div>
    </div>
@endsection