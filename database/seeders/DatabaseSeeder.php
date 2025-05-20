<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        Role::create(['name' => 'HR']);
        Role::create(['name' => 'Employee']);

        // Create an HR user
        User::create([
            'name' => 'HR Admin',
            'email' => 'hr@example.com',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'HR')->first()->id,
        ]);
    }
}
