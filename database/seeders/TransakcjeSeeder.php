<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transakcja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransakcjeSeeder extends Seeder
{
    public function run(): void
    {
        $klienci = \App\Models\Klient::all();
        $kursy = \App\Models\Course::all();

        if (empty($klienci) || empty($kursy)) {
            $this->command->warn("Brak danych w tabeli 'klienci' lub 'kursy'. Dodaj dane przed seedowaniem transakcji.");
            return;
        }

        $statusy = ['Opłacone', 'Oczekuje', 'Anulowane'];

        for ($i = 0; $i < 20; $i++) {

            $klient = $klienci->random();
            $kurs = $kursy->random();

            Transakcja::create([
                'id_klienta' => $klient->id_klienta,
                'id_kursu' => $kurs->id_kursu,
                'klient_imie'     => $klient->imie,
                'klient_nazwisko' => $klient->nazwisko,
                'klient_email'    => $klient->email,
                'kurs_jezyk' => $kurs->jezyk,
                'kurs_poziom' => $kurs->poziom,
                'kurs_data_rozpoczecia' => $kurs->data_rozpoczecia,
                'cena_ostateczna' => rand(100, 1000),
                'status' => $statusy[array_rand($statusy)],
                'data' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
            ]);
        }
    }
}
