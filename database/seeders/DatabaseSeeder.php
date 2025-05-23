<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Vova',
            'email' => 'test@example.com',
        ]);

        $this->call([
            LinkSeeder::class,
            ClickSeeder::class,
        ]);
    }
}
