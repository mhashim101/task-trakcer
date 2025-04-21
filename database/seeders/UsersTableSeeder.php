<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
        ]);

        $teamLead = User::create([
            'name' => 'Hashim',
            'email' => 'lead@example.com',
            'password' => Hash::make('admin123'),
            'role_id' => 2,
        ]);

        $teamMember = User::create([
            'name' => 'Zakria',
            'email' => 'member@example.com',
            'password' => Hash::make('admin123'),
            'role_id' => 3,
        ]);
    }
}
