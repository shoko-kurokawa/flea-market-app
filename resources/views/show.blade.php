@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="item-detail">
        <div class="item-detail__inner">

            <div class="item-detail__image-area">
                @if ($product->images->isNotEmpty())
                    <img class="item-detail__image" src="{{ $product->images->first()->image_path }}"
                        alt="{{ $product->name }}">
                @endif
            </div>

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

                <div class="item-detail__actions">
                    <div class="item-detail__action">
                        <span>♡</span>
                        <span>{{ $product->likes->count() }}</span>
                    </div>

                    <div class="item-detail__action">
                        <span>💬</span>
                        <span>{{ $product->comments->count() }}</span>
                    </div>
                </div>

                @if ($product->purchase)
                    <p class="item-detail__sold">
                        SOLD
                    </p>
                @else
                    <a class="item-detail__purchase-button" href="#">
                        購入手続きへ
                    </a>
                @endif

                <section class="item-detail__section">
                    <h2 class="item-detail__heading">
                        商品説明
                    </h2>

                    <p class="item-detail__description">
                        {{ $product->description }}
                    </p>
                </section>

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

                <section class="item-detail__section">
                    <h2 class="item-detail__heading">
                        コメント（{{ $product->comments->count() }}）
                    </h2>

                    @forelse ($product->comments as $comment)
                        <div class="item-detail__comment">

                            <div class="item-detail__comment-user">
                                @if ($comment->user->profile_image)
                                    <img class="item-detail__comment-image"
                                        src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                        alt="{{ $comment->user->name }}">
                                @endif

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

            </div>

        </div>
    </div>
@endsection