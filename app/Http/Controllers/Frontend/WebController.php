<?php

namespace App\Http\Controllers\Frontend;

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

    public function registerMerchantForm()
    {
        return view('auth.register-merchant');
    }

    public function registerMerchant(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_pemilik' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:150|unique:merchants,nama_merchant',
            'no_wa' => 'required|string|max:14|starts_with:62|unique:users,no_wa',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'nama_perusahaan.required' => 'Nama merchant/perusahaan harus diisi.',
            'nama_perusahaan.max' => 'Nama merchant maksimal 150 karakter.',
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
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Step 2: Generate UUID untuk merchant
            $merchantId = (string) Str::uuid();

            // Step 3: Insert ke table merchants
            DB::table('merchants')->insert([
                'id' => $merchantId,
                'nama_merchant' => $request->nama_perusahaan,
                'logo' => null,
                'url_callback' => null,
                'apikey' => null,
                'secretkey' => null,
                'bank_id' => null,
                'pemilik_rekening' => null,
                'nomor_rekening' => null,
                'ktp' => null,
                'catatan' => null,
                'is_active' => 'No',
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
            }

            // Redirect ke login dengan session success (sama seperti di login page)
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
}
