@extends('layouts.app')

@section('title', 'メール認証')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
    <div class="verify-email">
        <div class="verify-email__inner">

            <p class="verify-email__message">
                登録していただいたメールアドレスに認証メールを送付しました。
                <br>
                メール内のリンクからメール認証を完了してください。
            </p>

            <a class="verify-email__button" href="http://localhost:8025" target="_blank">
                認証はこちらから
            </a>

            @if (session('status') === 'verification-link-sent')
                <p class="verify-email__success">
                    認証メールを再送しました。
                </p>
            @endif

            <form class="verify-email__form" method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button class="verify-email__resend-button" type="submit">
                    認証メールを再送する
                </button>
            </form>

        </div>
    </div>
@endsection