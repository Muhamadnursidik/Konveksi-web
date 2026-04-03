<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Konveksi',
            'email' => 'admin@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'photo' => 'users/admin.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Pemotong1',
            'email' => 'pemotong1@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'pemotong',
            'photo' => 'users/pemotong.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Pemotong2',
            'email' => 'pemotong2@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'pemotong',
            'photo' => 'users/pemotong.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Pemotong3',
            'email' => 'pemotong3@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'pemotong',
            'photo' => 'users/pemotong.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Penjahit1',
            'email' => 'penjahit1@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'penjahit',
            'photo' => 'users/penjahit.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Penjahit2',
            'email' => 'penjahit2@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'penjahit',
            'photo' => 'users/penjahit.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Penjahit3',
            'email' => 'penjahit3@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'penjahit',
            'photo' => 'users/penjahit.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Finishing1',
            'email' => 'finishing1@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'finishing',
            'photo' => 'users/finishing.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Finishing2',
            'email' => 'finishing2@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'finishing',
            'photo' => 'users/finishing.jpg',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Finishing3',
            'email' => 'finishing3@konveksi.com',
            'password' => Hash::make('password'),
            'role' => 'finishing',
            'photo' => 'users/finishing.jpg',
            'is_active' => true
        ]);

    }
}
