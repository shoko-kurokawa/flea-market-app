@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="items">
        <div class="items__inner">

            {{-- タブ --}}
            <div class="items__tabs">
                <a class="items__tab {{ request('page') !== 'mylist' ? 'items__tab--active' : '' }}" href="{{ route('items.index', [
        'keyword' => request('keyword'),
    ]) }}">
                    おすすめ
                </a>

                <a class="items__tab {{ request('page') === 'mylist' ? 'items__tab--active' : '' }}" href="{{ route('items.index', [
        'page' => 'mylist',
        'keyword' => request('keyword'),
    ]) }}">
                    マイリスト
                </a>
            </div>

            {{-- 商品一覧 --}}
            <div class="items__list">
                @forelse ($products as $product)
                    <a class="items__item" href="{{ route('items.show', $product) }}">

                        <div class="items__image-wrapper">
                            @if ($product->images->isNotEmpty())
                                <img class="items__image" src="{{ $product->images->first()->image_url }}"
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
                    @if (request('page') === 'mylist')
                        <p>
                            マイリストに商品がありません。
                        </p>
                    @else
                        <p>
                            商品がありません。
                        </p>
                    @endif
                @endforelse
            </div>

        </div>
    </div>
@endsection