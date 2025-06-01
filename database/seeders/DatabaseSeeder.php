<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Division;
use App\Models\Branch;
use App\Models\Payscale;
use App\Models\OfficeRole;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        Role::create(['name' => 'HR']);
        Role::create(['name' => 'Employee']);

        // Create divisions
        Division::create(['name' => 'Engineering']);
        Division::create(['name' => 'Marketing']);

        // Create branches
        Branch::create(['name' => 'Main Office', 'location' => 'New York']);
        Branch::create(['name' => 'West Coast', 'location' => 'San Francisco']);

        // Create payscales
        $payscale1 = Payscale::create(['title' => 'Junior', 'salary' => 50000]);
        $payscale2 = Payscale::create(['title' => 'Senior', 'salary' => 80000]);

        // Create office roles
        OfficeRole::create(['title' => 'Software Engineer', 'payscale_id' => $payscale1->id]);
        OfficeRole::create(['title' => 'Marketing Manager', 'payscale_id' => $payscale2->id]);

        // Create HR user
        User::create([
            'name' => 'HR Admin',
            'email' => 'hr@example.com',
            'password' => bcrypt('password'),
            'role_id' => Role::where('name', 'HR')->first()->id,
        ]);

        // Create sample employee
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('  '),
            'role_id' => Role::where('name', 'Employee')->first()->id,
            'division_id' => Division::where('name', 'Engineering')->first()->id,
            'branch_id' => Branch::where('name', 'Main Office')->first()->id,
            'office_role_id' => OfficeRole::where('title', 'Software Engineer')->first()->id,
        ]);
    }
}
