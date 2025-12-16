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
        // Manager
        User::create([
            'name' => 'Manager PT Smart',
            'email' => 'manager@smart.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);

        // Sales
        User::create([
            'name' => 'Sales A',
            'email' => 'sales@smart.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
        ]);

        User::create([
            'name' => 'Sales B',
            'email' => 'salesb@smart.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
        ]);
    }
}
