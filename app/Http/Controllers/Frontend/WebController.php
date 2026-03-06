<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\ActivityLogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class WebController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function apiDocs()
    {
        return view('frontend.api-docs');
    }

    public function registerMerchantForm()
    {
        return view('auth.register-merchant');
    }

    public function registerMerchant(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pemilik' => ['required', 'string', 'min:5', 'max:100', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'nama_perusahaan' => ['required', 'string', 'min:5', 'max:100', 'regex:/^[a-zA-Z0-9\s]+$/', 'unique:merchants,nama_merchant'],
            'no_wa' => 'required|string|max:14|starts_with:62|unique:users,no_wa',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'nama_pemilik.required' => 'Nama lengkap harus diisi.',
            'nama_pemilik.min' => 'Nama lengkap minimal 5 karakter.',
            'nama_pemilik.max' => 'Nama lengkap maksimal 100 karakter.',
            'nama_pemilik.regex' => 'Nama lengkap hanya boleh berisi huruf, angka, dan spasi.',
            'nama_perusahaan.required' => 'Nama merchant/perusahaan harus diisi.',
            'nama_perusahaan.min' => 'Nama merchant/perusahaan minimal 5 karakter.',
            'nama_perusahaan.max' => 'Nama merchant/perusahaan maksimal 100 karakter.',
            'nama_perusahaan.regex' => 'Nama merchant/perusahaan hanya boleh berisi huruf, angka, dan spasi.',
            'nama_perusahaan.unique' => 'Nama merchant/perusahaan sudah terdaftar.',
            'no_wa.starts_with' => 'Nomor WhatsApp harus diawali dengan 62.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 14 digit.',
            'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Format nomor WhatsApp
        $noWa = $request->no_wa;
        if (!str_starts_with($noWa, '62')) {
            $noWa = '62' . ltrim($noWa, '0');
        }

        $token_qrin = $this->generateTokenQrin(64);

        // Mulai transaction
        DB::beginTransaction();

        try {
            // Step 1: Insert ke table users
            $userId = DB::table('users')->insertGetId([
                'name' => $request->nama_pemilik,
                'email' => $request->email,
                'no_wa' => $noWa,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
                'log_otp' => 'No',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Step 2: Generate UUID untuk merchant
            $merchantId = (string) Str::uuid();

            // Step 2.5: Generate kode_merchant unik
            do {
                $randomNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $kodeMerchant = 'QR' . $randomNumber;
            } while (DB::table('merchants')->where('kode_merchant', $kodeMerchant)->exists());

            // Step 3: Insert ke table merchants
            DB::table('merchants')->insert([
                'id' => $merchantId,
                'kode_merchant' => $kodeMerchant,
                'nama_merchant' => $request->nama_perusahaan,
                'logo' => null,
                'url_callback' => null,
                'token_qrin' => $token_qrin,
                'bank_id' => null,
                'pemilik_rekening' => null,
                'nomor_rekening' => null,
                'ktp' => null,
                'catatan' => null,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Step 4: Insert ke table assign_merchants
            DB::table('assign_merchants')->insert([
                'user_id' => $userId,
                'merchant_id' => $merchantId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Commit transaction
            DB::commit();

            // Assign role User Merchant ke user
            $user = \App\Models\User::find($userId);
            if ($user) {
                $user->assignRole('User Merchant');
                ActivityLogHelper::log(
                    description: 'Merchant registration',
                    logName: 'auth',
                    properties: [
                        'before' => null,
                        'after' => [
                            'user_id' => $userId,
                            'email' => $user->email,
                            'merchant_id' => $merchantId,
                            'nama_merchant' => $request->nama_perusahaan,
                        ],
                    ],
                    subject: $user
                );
            }

            // Redirect ke login dengan session success
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login untuk melengkapi data merchant Anda.');
        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            DB::rollBack();

            // Kembali dengan error session
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }

    private function generateTokenQrin($length = 64)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $result;
    }
}
