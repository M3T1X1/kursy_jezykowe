<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KursyTableSeeder extends Seeder
{
    public function run()
    {
        // Pobierz listę instruktorów z bazy, żeby znać ich ID
        $instruktorzy = DB::table('instruktorzy')->pluck('id')->toArray();

        if (empty($instruktorzy)) {
            $this->command->error('Brak instruktorów w bazie! Najpierw uruchom InstruktorzyTableSeeder.');
            return;
        }

        DB::table('kursy')->insert([
            [
                'cena' => 1500.00,
                'jezyk' => 'Angielski',
                'poziom' => 'Zaawansowany',
                'data_rozpoczecia' => '2025-06-01',
                'data_zakonczenia' => '2025-08-31',
                'liczba_miejsc' => 10,
                'id_instruktora' => $instruktorzy[0],
                'zdjecie' => 'courses/angielski-zaawansowany.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cena' => 1200.00,
                'jezyk' => 'Hiszpański',
                'poziom' => 'Średniozaawansowany',
                'data_rozpoczecia' => '2025-07-01',
                'data_zakonczenia' => '2025-09-30',
                'liczba_miejsc' => 15,
                'id_instruktora' => $instruktorzy[1],
                'zdjecie' => 'courses/hiszpanski-sredniozaawansowany.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cena' => 1100.00,
                'jezyk' => 'Francuski',
                'poziom' => 'Początkujący',
                'data_rozpoczecia' => '2025-08-01',
                'data_zakonczenia' => '2025-10-31',
                'liczba_miejsc' => 8,
                'id_instruktora' => $instruktorzy[2],
                'zdjecie' => 'courses/francuski-poczatkujacy.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
