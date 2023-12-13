<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'id' => Str::uuid(),
                'name' => 'Admin 1',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Admin 2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Admin 3',
                'email' => 'admin3@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'admin',
                'email_verified_at' => now(),
            ],
        ]);
    }
}
