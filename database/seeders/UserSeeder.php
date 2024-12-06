<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Dokter',
            'role' => 'dokter',
            'username' => 'dokter.malut',
            'email' => 'dokter@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // pastikan password di-hash
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
