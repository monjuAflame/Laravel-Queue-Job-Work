<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin 1',
            'email' => 'admin@gmail.com.com',
            'is_admin' => 1,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Admin 2',
            'email' => 'admin2@gmail.com.com',
            'is_admin' => 1,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Admin 3',
            'email' => 'admin3@gmail.com.com',
            'is_admin' => 1,
        ]);
    }
}
