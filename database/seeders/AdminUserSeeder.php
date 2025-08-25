<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@drone.local'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@drone.local'],
            [
                'name' => 'User',
                'password' => bcrypt('password'),
                'role' => 'user'
            ]
        );
    }
}
