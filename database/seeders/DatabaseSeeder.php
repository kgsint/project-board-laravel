<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'kgsint',
            'email' => 'kgsint@gmail.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'senna',
            'email' => 'senna@gmail.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
        ]);

        $this->call([
            ProjectSeeder::class,
        ]);
    }
}
