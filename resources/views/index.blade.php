@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="items">
        <div class="items__inner">

            <div class="items__tabs">
                <a class="items__tab items__tab--active" href="{{ route('items.index') }}">
                    おすすめ
                </a>

                <a class="items__tab" href="{{ route('items.index', ['page' => 'mylist']) }}">
                    マイリスト
                </a>
            </div>

            <div class="items__list">
                @forelse ($products as $product)
                    <a class="items__item" href="{{ route('items.show', $product) }}">

                        <div class="items__image-wrapper">
                            @if ($product->images->isNotEmpty())
                                <img class="items__image" src="{{ $product->images->first()->image_path }}"
                                    alt="{{ $product->name }}">
                            @endif

                            @if ($product->purchase)
                                <span class="items__sold">
                                    SOLD
                                </span>
                            @endif
                        </div>

                        <p class="items__name">
                            {{ $product->name }}
                        </p>

                        <p class="items__price">
                            ¥{{ number_format($product->price) }}
                        </p>

                    </a>
                @empty
                    <p>商品がありません。</p>
                @endforelse
            </div>

        </div>
    </div>
@endsection