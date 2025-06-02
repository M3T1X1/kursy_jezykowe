<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstruktorzyTableSeeder extends Seeder
{
    public function run()
    {
        $instruktorzy = [
            [
                'email' => 'jan.kowalski@example.com',
                'imie' => 'Jan',
                'nazwisko' => 'Kowalski',
                'jezyk' => 'Angielski',
                'adres_zdjecia' => 'ul. Lipowa 10, Warszawa',
                'poziom' => 'Zaawansowany',
                'placa' => 50.00,
            ],
            [
                'email' => 'maria.nowak@example.com',
                'imie' => 'Maria',
                'nazwisko' => 'Nowak',
                'jezyk' => 'Hiszpański',
                'adres_zdjecia' => 'ul. Długa 5, Kraków',
                'poziom' => 'Średniozaawansowany',
                'placa' => 45.00,
            ],
            [
                'email' => 'piotr.wisniewski@example.com',
                'imie' => 'Piotr',
                'nazwisko' => 'Wiśniewski',
                'jezyk' => 'Francuski',
                'adres_zdjecia' => 'ul. Słoneczna 8, Gdańsk',
                'poziom' => 'Początkujący',
                'placa' => 40.00,
            ],
        ];

        foreach ($instruktorzy as $instruktor) {
            DB::table('instruktorzy')->updateOrInsert(
                ['email' => $instruktor['email']],
                $instruktor
            );
        }
    }
}
