<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Adminseeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'email_verified_at' => null,
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'email_verified_at' => '2024-11-28 12:00:00',
                'password' => Hash::make('securepassword'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
