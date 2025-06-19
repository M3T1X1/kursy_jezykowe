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
        $kursy = DB::table('kursy')->pluck('id_kursu')->toArray();

        if (empty($klienci) || empty($kursy)) {
            $this->command->warn("Brak danych w tabeli 'klienci' lub 'kursy'. Dodaj dane przed seedowaniem transakcji.");
            return;
        }

        $statusy = ['Opłacone', 'Oczekuje', 'Anulowane'];

        for ($i = 0; $i < 20; $i++) {

            $klient = $klienci->random();

            Transakcja::create([
                'id_klienta' => $klient->id_klienta,
                'id_kursu' => $kursy[array_rand($kursy)],
                'klient_imie'     => $klient->imie,
                'klient_nazwisko' => $klient->nazwisko,
                'klient_email'    => $klient->email,
                'cena_ostateczna' => rand(100, 1000),
                'status' => $statusy[array_rand($statusy)],
                'data' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
            ]);
        }
    }
}
