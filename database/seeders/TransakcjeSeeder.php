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
        $klienci = DB::table('klienci')->pluck('id_klienta')->toArray();
        $kursy = DB::table('kursy')->pluck('id_kursu')->toArray();

        if (empty($klienci) || empty($kursy)) {
            $this->command->warn("Brak danych w tabeli 'klienci' lub 'kursy'. Dodaj dane przed seedowaniem transakcji.");
            return;
        }

        $statusy = ['Opłacone', 'Oczekuje', 'Anulowane'];

        for ($i = 0; $i < 20; $i++) {
            Transakcja::create([
                'id_klienta' => $klienci[array_rand($klienci)],
                'id_kursu' => $kursy[array_rand($kursy)],
                'cena_ostateczna' => rand(100, 1000),
                'status' => $statusy[array_rand($statusy)],
                'data' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
            ]);
        }
    }
}
