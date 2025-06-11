<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminReferensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin Referensi PCare',
            'role' => 'admin-referensi',
            'email' => 'adminreferensi@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // pastikan password di-hash
            'address' => 'Makassar',
            'no_hp' => '0',
            'nip' => '0',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
