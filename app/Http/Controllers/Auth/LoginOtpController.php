<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class LoginOtpController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function showForm(Request $request): View|RedirectResponse
    {
        $userId = $request->session()->get('login_otp_user_id');

        if (! $userId) {
            return redirect()->route('login')->with('error', 'Sesi OTP tidak valid. Silakan login kembali.');
        }

        $user = User::find($userId);

        if (! $user) {
            $request->session()->forget('login_otp_user_id');
            return redirect()->route('login')->with('error', 'Sesi OTP tidak valid. Silakan login kembali.');
        }

        return view('auth.login-otp', [
            'user' => $user,
            'email' => $user->email,
        ]);
    }

    /**
     * Verify OTP and complete login.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6', 'regex:/^[0-9]+$/'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit.',
            'otp.regex' => 'Kode OTP harus berupa angka.',
        ]);

        $userId = $request->session()->get('login_otp_user_id');

        if (! $userId) {
            return redirect()->route('login')->with('error', 'Sesi OTP tidak valid atau sudah kadaluarsa. Silakan login kembali.');
        }

        $cacheKey = 'login_otp_' . $userId;
        $cachedOtp = Cache::get($cacheKey);

        if (! $cachedOtp || $cachedOtp !== $request->otp) {
            throw ValidationException::withMessages([
                'otp' => ['Kode OTP tidak valid atau sudah kadaluarsa. Silakan coba lagi atau login ulang.'],
            ]);
        }

        Cache::forget($cacheKey);
        $request->session()->forget('login_otp_user_id');

        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan. Silakan login kembali.');
        }

        $remember = $request->session()->get('login_otp_remember', false);
        $request->session()->forget('login_otp_remember');

        Auth::login($user, $remember);

        return redirect()->intended(config('fortify.home'));
    }

    /**
     * Resend OTP.
     */
    public function resend(Request $request): RedirectResponse
    {
        $userId = $request->session()->get('login_otp_user_id');
        $throttleKey = 'login-otp-resend:' . ($userId ?? $request->ip());
        $resendCount = (int) Cache::get($throttleKey, 0);

        if ($resendCount >= 3) {
            return redirect()->route('login-otp.form')
                ->with('error', 'Terlalu banyak percobaan. Silakan tunggu beberapa menit.');
        }

        if (! $userId) {
            return redirect()->route('login')->with('error', 'Sesi OTP tidak valid. Silakan login kembali.');
        }

        $user = User::find($userId);

        if (! $user) {
            $request->session()->forget('login_otp_user_id');
            return redirect()->route('login')->with('error', 'Sesi OTP tidak valid.');
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put('login_otp_' . $userId, $otp, now()->addMinutes(5));

        Mail::to($user->email)->send(new LoginOtpMail($otp, $user->name));

        $count = (int) Cache::get($throttleKey, 0) + 1;
        Cache::put($throttleKey, $count, now()->addMinutes(5));

        return redirect()->route('login-otp.form')->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
