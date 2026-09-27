<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Seleksi Osis',
            'username' => 'admin',
            'email' => 'admin@osis.com',
            'password' => Hash::make('M4sukygbener'),
            'role' => 'admin',
            'status_lulus' => 'pending',
        ]);
    }
}