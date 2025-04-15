<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@email.com',
                'username' => 'adminuser'
            ],
            [
                'firstname' => 'Admin',
                'lastname' => 'User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }
}
