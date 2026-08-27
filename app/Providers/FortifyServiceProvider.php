<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * メール認証完了後、
         * プロフィール設定画面へ遷移する
         */
        $this->app->singleton(
            VerifyEmailResponse::class,
            function () {
                return new class implements VerifyEmailResponse {
                    public function toResponse($request)
                    {
                        return redirect()->route('profile.edit');
                    }
                };
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * 会員登録処理
         */
        Fortify::createUsersUsing(CreateNewUser::class);

        /**
         * 会員登録画面
         */
        Fortify::registerView(function () {
            return view('auth.register');
        });

        /**
         * ログイン画面
         */
        Fortify::loginView(function () {
            return view('auth.login');
        });

        /**
         * メール認証案内画面
         */
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

        /**
         * ログイン試行回数制限
         */
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username()))
                . '|' .
                $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}