<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Znizka;

class ZnizkiSeeder extends Seeder
{
    public function run(): void
    {
        $znizki = [
            ['nazwa_znizki' => 'Wiosenna', 'wartosc' => 10, 'opis' => 'Zniżka na wiosnę'],
            ['nazwa_znizki' => 'Studencka', 'wartosc' => 15, 'opis' => 'Dla studentów z ważną legitymacją'],
            ['nazwa_znizki' => 'Black Friday', 'wartosc' => 25, 'opis' => 'Promocja z okazji Black Friday'],
            ['nazwa_znizki' => 'Nowy klient', 'wartosc' => 5, 'opis' => 'Dla nowych klientów'],
            ['nazwa_znizki' => 'Urodzinowa', 'wartosc' => 20, 'opis' => 'Zniżka urodzinowa'],
        ];

        foreach ($znizki as $znizka) {
            Znizka::create($znizka);
        }
    }
}
