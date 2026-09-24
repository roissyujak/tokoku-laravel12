<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // forceCreate dipakai karena 'role' sengaja TIDAK dimasukkan ke $fillable
        // (kolom role tidak boleh bisa diisi lewat form/request biasa).
        User::forceCreate([
            'name'     => 'Admin TokoKu',
            'email'    => 'admin@tokoku.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::forceCreate([
            'name'     => 'Seller TokoKu',
            'email'    => 'seller@tokoku.com',
            'password' => Hash::make('password'),
            'role'     => 'seller',
        ]);

        User::forceCreate([
            'name'     => 'Customer Test',
            'email'    => 'customer@tokoku.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
        ]);
    }
}
