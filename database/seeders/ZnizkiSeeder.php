<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Znizka;

class ZnizkiSeeder extends Seeder
{
    public function run(): void
    {
        $znizki = [
            ['nazwa_znizki' => 'Wiosenna', 'wartosc' => 10, 'opis' => 'Zniżka na wiosnę', 'active' => true],
            ['nazwa_znizki' => 'Studencka', 'wartosc' => 15, 'opis' => 'Dla studentów z ważną legitymacją', 'active' => true],
            ['nazwa_znizki' => 'Black Friday', 'wartosc' => 25, 'opis' => 'Promocja z okazji Black Friday', 'active' => true],
            ['nazwa_znizki' => 'Nowy klient', 'wartosc' => 5, 'opis' => 'Dla nowych klientów', 'active' => true],
            ['nazwa_znizki' => 'Urodzinowa', 'wartosc' => 20, 'opis' => 'Zniżka urodzinowa', 'active' => true],
        ];

        foreach ($znizki as $znizka) {
            Znizka::create($znizka);
        }
    }
}
