@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="mypage">
        <div class="mypage__inner">

            <div class="mypage__profile">
                <div class="mypage__user">
                    <div class="mypage__image">
                        @if ($user->profile_image)
                            <img class="mypage__image-content" src="{{ asset('storage/' . $user->profile_image) }}"
                                alt="プロフィール画像">
                        @endif
                    </div>

                    <p class="mypage__name">
                        {{ $user->name }}
                    </p>
                </div>

                <a class="mypage__edit-button" href="{{ route('profile.edit') }}">
                    プロフィールを編集
                </a>
            </div>

            <div class="mypage__tabs">
                <a class="mypage__tab" href="{{ route('profile.index', ['page' => 'sell']) }}">
                    出品した商品
                </a>

                <a class="mypage__tab" href="{{ route('profile.index', ['page' => 'buy']) }}">
                    購入した商品
                </a>
            </div>

            <div class="mypage__products">
                @if (request('page') === 'buy')
                    @forelse ($purchasedProducts as $purchase)
                        <div class="mypage__product">
                            @if ($purchase->product->images->isNotEmpty())
                                <img class="mypage__product-image"
                                    src="{{ asset('storage/' . $purchase->product->images->first()->image_url) }}"
                                    alt="{{ $purchase->product->name }}">
                            @endif

                            <p class="mypage__product-name">
                                {{ $purchase->product->name }}
                            </p>
                        </div>
                    @empty
                        <p>購入した商品はありません。</p>
                    @endforelse
                @else
                    @forelse ($products as $product)
                        <div class="mypage__product">
                            @if ($product->images->isNotEmpty())
                                <img class="mypage__product-image" src="{{ asset('storage/' . $product->images->first()->image_url) }}"
                                    alt="{{ $product->name }}">
                            @endif

                            <p class="mypage__product-name">
                                {{ $product->name }}
                            </p>
                        </div>
                    @empty
                        <p>出品した商品はありません。</p>
                    @endforelse
                @endif
            </div>

        </div>
    </div>
@endsection