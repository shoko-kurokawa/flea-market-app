@extends('layouts.app')

@section('title', '購入手続き')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    @php
        $shippingPostalCode = session('shipping_postal_code', $user->postal_code);
        $shippingAddress = session('shipping_address', $user->address);
        $shippingBuilding = session('shipping_building', $user->building);
    @endphp

    <div class="purchase">
        <form
            class="purchase__form"
            action="{{ route('purchase.store', $product) }}"
            method="POST"
        >
            @csrf

            <div class="purchase__inner">

                {{-- 左側 --}}
                <div class="purchase__main">

                    {{-- 商品情報 --}}
                    <div class="purchase__product">
                        <div class="purchase__product-image-wrapper">
                            @if ($product->images->isNotEmpty())
                                <img
                                    class="purchase__product-image"
                                    src="{{ $product->images->first()->image_path }}"
                                    alt="{{ $product->name }}"
                                >
                            @endif
                        </div>

                        <div class="purchase__product-info">
                            <h1 class="purchase__product-name">
                                {{ $product->name }}
                            </h1>

                            <p class="purchase__product-price">
                                ¥{{ number_format($product->price) }}
                            </p>
                        </div>
                    </div>

                    {{-- 支払い方法 --}}
                    <div class="purchase__section">
                        <h2 class="purchase__heading">
                            支払い方法
                        </h2>

                        <select
                            class="purchase__select"
                            id="payment-method"
                            name="payment_method"
                        >
                            <option value="">
                                選択してください
                            </option>

                            <option
                                value="convenience_store"
                                {{ old('payment_method') === 'convenience_store' ? 'selected' : '' }}
                            >
                                コンビニ払い
                            </option>

                            <option
                                value="card"
                                {{ old('payment_method') === 'card' ? 'selected' : '' }}
                            >
                                カード支払い
                            </option>
                        </select>

                        @error('payment_method')
                            <p class="purchase__error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- 配送先 --}}
                    <div class="purchase__section">
                        <div class="purchase__address-heading">
                            <h2 class="purchase__heading">
                                配送先
                            </h2>

                            <a
                                class="purchase__address-link"
                                href="{{ route('purchase.address.edit', $product) }}"
                            >
                                変更する
                            </a>
                        </div>

                        <div class="purchase__address">
                            <p>
                                〒{{ $shippingPostalCode }}
                            </p>

                            <p>
                                {{ $shippingAddress }}
                            </p>

                            @if ($shippingBuilding)
                                <p>
                                    {{ $shippingBuilding }}
                                </p>
                            @endif
                        </div>

                        <input
                            type="hidden"
                            name="shipping_postal_code"
                            value="{{ old('shipping_postal_code', $shippingPostalCode) }}"
                        >

                        <input
                            type="hidden"
                            name="shipping_address"
                            value="{{ old('shipping_address', $shippingAddress) }}"
                        >

                        <input
                            type="hidden"
                            name="shipping_building"
                            value="{{ old('shipping_building', $shippingBuilding) }}"
                        >

                        @error('shipping_postal_code')
                            <p class="purchase__error">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('shipping_address')
                            <p class="purchase__error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                {{-- 右側 --}}
                <div class="purchase__side">

                    <div class="purchase__summary">

                        <div class="purchase__summary-row">
                            <span>
                                商品代金
                            </span>

                            <span>
                                ¥{{ number_format($product->price) }}
                            </span>
                        </div>

                        <div class="purchase__summary-row">
                            <span>
                                支払い方法
                            </span>

                            <span id="selected-payment-method">
                                選択してください
                            </span>
                        </div>

                    </div>

                    <button
                        class="purchase__button"
                        type="submit"
                    >
                        購入する
                    </button>

                </div>

            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethod = document.getElementById('payment-method');
            const selectedPaymentMethod = document.getElementById('selected-payment-method');

            function updatePaymentMethod() {
                const selectedOption =
                    paymentMethod.options[paymentMethod.selectedIndex];

                selectedPaymentMethod.textContent =
                    selectedOption.textContent.trim();
            }

            paymentMethod.addEventListener('change', updatePaymentMethod);

            updatePaymentMethod();
        });
    </script>
@endsection