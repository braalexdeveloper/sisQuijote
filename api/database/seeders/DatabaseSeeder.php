<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $rol1=Role::create(['name'=>'admin']);
        $rol2=Role::create(['name'=>'employe']);
        
        User::create([
            'name'=>'brayan',
            'email'=>'brayan@gmail.com',
            'password'=>bcrypt('brayan123'),
            'role_id'=>$rol1->id
        ]);

        User::create([
            'name' => 'tati',
            'email' => 'tati@gmail.com',
            'password' => bcrypt('tati123'),
            'role_id'=>$rol2->id
        ]);
    }
}
