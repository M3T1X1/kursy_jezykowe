<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlienciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('klienci')->insert([
            [
                'email' => 'jan.kowalski@example.com',
                'haslo' => bcrypt('haslo123'),
                'imie' => 'Jan',
                'nazwisko' => 'Kowalski',
                'adres' => 'ul. Testowa 1, Warszawa',
                'nr_telefonu' => '123456789',
                'adres_zdjecia' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'anna.nowak@example.com',
                'haslo' => bcrypt('haslo456'),
                'imie' => 'Anna',
                'nazwisko' => 'Nowak',
                'adres' => 'ul. Przykładowa 5, Kraków',
                'nr_telefonu' => '987654321',
                'adres_zdjecia' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'piotr.zielinski@example.com',
                'haslo' => bcrypt('haslo789'),
                'imie' => 'Piotr',
                'nazwisko' => 'Zieliński',
                'adres' => 'ul. Fikcyjna 10, Gdańsk',
                'nr_telefonu' => '555666777',
                'adres_zdjecia' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
