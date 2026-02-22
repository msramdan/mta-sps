<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogTokenB2bSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummies = [
            [
                'header' => [
                    'Content-Type' => 'application/json',
                    'X-Client-Id' => 'client-b2b-' . Str::random(8),
                    'X-Request-Id' => (string) Str::uuid(),
                ],
                'payload' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('app.name') . '-b2b',
                    'client_secret' => '***',
                ],
                'response' => [
                    'access_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.' . Str::random(80),
                    'token_type' => 'Bearer',
                    'expires_in' => 3600,
                ],
            ],
            [
                'header' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ***',
                    'X-Request-Id' => (string) Str::uuid(),
                ],
                'payload' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => '***',
                ],
                'response' => [
                    'access_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.' . Str::random(80),
                    'refresh_token' => 'rt_' . Str::random(40),
                    'expires_in' => 3600,
                ],
            ],
        ];

        foreach ($dummies as $i => $data) {
            $created = now()->subHours(count($dummies) - $i);
            DB::table('log_token_b2b')->insert([
                'id' => (string) Str::uuid(),
                'header' => json_encode($data['header'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'payload' => json_encode($data['payload'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'response' => json_encode($data['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                'created_at' => $created,
                'updated_at' => $created,
            ]);
        }

        $this->command->info('Log Token B2B seeder: ' . count($dummies) . ' dummy log(s) created.');
    }
}
