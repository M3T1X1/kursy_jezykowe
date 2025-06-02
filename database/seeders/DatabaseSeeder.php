<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory(10)->create();

        // Seeder dla instruktorów
        $this->call(InstruktorzyTableSeeder::class);

        $this->call(KursyTableSeeder::class);

        // Seeder dla Klientow
        $this->call(KlienciSeeder::class);

        // Seeder dla zniżek
        $this->call(ZnizkiSeeder::class);

        // Seeder dla transakcji
        $this->call(TransakcjeSeeder::class);

        // Przykładowy użytkownik
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
