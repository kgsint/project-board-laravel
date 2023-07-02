<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Project;
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
            'email' => 'kgsint@gmail.co.uk',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'senna',
            'email' => 'senna@mail.com',
        ]);

        $this->call([
            ProjectSeeder::class,
        ]);
    }
}
