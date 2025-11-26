<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //cek apakah admin sudah ada
        if(!User::where('role','admin')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@woka.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]);
        }
    }
}
