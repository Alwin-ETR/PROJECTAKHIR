<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin 
        User::create([
            'name' => 'Admin Fasilkom',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890'
        ]);

        // 2. Mahasiswa
        User::create([
            'name' => 'Alwin Ghazali',
            'email' => 'alwin@gmail.com',
            'password' => Hash::make('alwin123'),
            'role' => 'mahasiswa',
            'nim' => '202410104022',
            'phone' => '081234567891'
        ]);

        User::create([
            'name' => 'Dimas Rofi',
            'email' => 'dimas@gmail.com',
            'password' => Hash::make('dimas123'),
            'role' => 'mahasiswa',
            'nim' => '202410104062',
            'phone' => '083543216789'
        ]);

        User::create([
            'name' => 'Advent Nito',
            'email' => 'nito@gmail.com',
            'password' => Hash::make('nito123'),
            'role' => 'mahasiswa',
            'nim' => '202410104094',
            'phone' => '081345543213'
        ]);
    }
}