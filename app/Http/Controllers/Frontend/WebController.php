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
            'nama_perusahaan' => 'required|string|max:150',
            'no_wa' => 'required|string|max:14|starts_with:62',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'no_wa.starts_with' => 'Nomor WhatsApp harus diawali dengan 62.',
            'no_wa.max' => 'Nomor WhatsApp maksimal 14 digit.',
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

            Alert::success('Berhasil', 'Pendaftaran merchant berhasil! Akun Anda sedang dalam proses review oleh admin.');
            return redirect()->route('login');

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            DB::rollBack();

            Alert::error('Gagal', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }
}
