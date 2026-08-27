@extends('layouts.app')

@section('title', '住所変更')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="address">
        <div class="address__inner">

            <h1 class="address__heading">
                住所の変更
            </h1>

            <form class="address__form" action="{{ route('purchase.address.update', $product) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="address__group">
                    <label class="address__label" for="postal_code">
                        郵便番号
                    </label>

                    <input class="address__input" id="postal_code" type="text" name="postal_code"
                        value="{{ old('postal_code', session('shipping_postal_code', auth()->user()->postal_code)) }}">

                    @error('postal_code')
                        <p class="address__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="address__group">
                    <label class="address__label" for="address">
                        住所
                    </label>

                    <input class="address__input" id="address" type="text" name="address"
                        value="{{ old('address', session('shipping_address', auth()->user()->address)) }}">

                    @error('address')
                        <p class="address__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="address__group">
                    <label class="address__label" for="building">
                        建物名
                    </label>

                    <input class="address__input" id="building" type="text" name="building"
                        value="{{ old('building', session('shipping_building', auth()->user()->building)) }}">

                    @error('building')
                        <p class="address__error">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button class="address__button" type="submit">
                    更新する
                </button>

            </form>
        </div>
    </div>
@endsection