<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(callback: CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(callback: UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(callback: UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(callback: ResetUserPassword::class);
        Fortify::authenticateUsing(function (Request $request) {

            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required'],
                'g-recaptcha-response' => config('app.show_captcha') === 'Yes'
                    ? 'required|captcha'
                    : 'nullable',
            ], [
                'g-recaptcha-response.required' => 'Harap lengkapi verifikasi reCAPTCHA.',
                'g-recaptcha-response.captcha' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format alamat email tidak valid.',
                'password.required' => 'Kata sandi wajib diisi.',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // 🔍 Cek user
            $user = \App\Models\User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Email atau kata sandi yang Anda masukkan salah.'],
                ]);
            }

            // 🔍 CEK ASSIGN MERCHANT
            $assignMerchant = DB::table('assign_merchants')
                ->where('user_id', $user->id)
                ->first();

            if (! $assignMerchant) {
                throw ValidationException::withMessages([
                    'email' => ['Anda tidak memiliki akses ke merchant manapun. Silakan hubungi admin.'],
                ]);
            }

            session([
                'sessionMerchant' => $assignMerchant->merchant_id
            ]);

            return $user;
        });


        RateLimiter::for(name: 'login', callback: function (Request $request): Limit {
            $throttleKey = Str::transliterate(string: Str::lower(value: $request->input(key: Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(maxAttempts: 5)->by(key: $throttleKey);
        });

        RateLimiter::for(name: 'two-factor', callback: fn(Request $request) => Limit::perMinute(maxAttempts: 5)->by(key: $request->session()->get(key: 'login.id')));

        Fortify::registerView(view: fn() => view(view: 'auth.register'));

        Fortify::loginView(view: fn() => view(view: 'auth.login'));

        Fortify::confirmPasswordView(view: fn() => view(view: 'auth.confirm-password'));

        Fortify::twoFactorChallengeView(view: fn() => view(view: 'auth.two-factor-challenge'));

        Fortify::requestPasswordResetLinkView(view: fn() => view(view: 'auth.forgot-password'));

        Fortify::resetPasswordView(view: fn(Request $request) => view(view: 'auth.reset-password', data: ['request' => $request]));
    }
}
