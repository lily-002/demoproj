<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = User::create([
            'uuid' => '1',
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@localhost',
            'phone' => '081234567890',
            'password' => bcrypt('admin'),
        ]);

        // Assign the 'admin' role to the user
        $user->assignRole('admin');
    }
}
