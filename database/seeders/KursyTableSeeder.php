<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KursyTableSeeder extends Seeder
{
    public function run()
    {
        // Pobierz listę instruktorów z bazy, żeby znać ich ID
        $instruktorzy = DB::table('instruktorzy')->get();

        if ($instruktorzy->isEmpty()) {
            $this->command->error('Brak instruktorów w bazie! Najpierw uruchom InstruktorzyTableSeeder.');
            return;
        }

        // Przygotuj dane kursów
        $kursyData = [
            [
                'cena' => 1500.00,
                'jezyk' => 'Angielski',
                'poziom' => 'Zaawansowany',
                'data_rozpoczecia' => '2025-06-01',
                'data_zakonczenia' => '2025-08-31',
                'liczba_miejsc' => 10,
                'id_instruktora' => $instruktorzy[0]->id,
                'zdjecie' => 'courses/UKFlag.png',
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
                'id_instruktora' => $instruktorzy[1]->id,
                'zdjecie' => 'courses/SpainFlag.png',
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
                'id_instruktora' => $instruktorzy[2]->id,
                'zdjecie' => 'courses/FranceFlag.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Dodaj denormalizowane dane instruktorów do każdego kursu
        foreach ($kursyData as &$kurs) {
            $instruktor = $instruktorzy->firstWhere('id', $kurs['id_instruktora']);

            if ($instruktor) {
                $kurs['instruktor_imie'] = $instruktor->imie;
                $kurs['instruktor_nazwisko'] = $instruktor->nazwisko;
                $kurs['instruktor_email'] = $instruktor->email;
                $kurs['instruktor_jezyk'] = $instruktor->jezyk;
                $kurs['instruktor_poziom'] = $instruktor->poziom;
                $kurs['instruktor_placa'] = $instruktor->placa;
                $kurs['instruktor_adres_zdjecia'] = $instruktor->adres_zdjecia;
            }
        }

        // Wstaw kursy do bazy
        DB::table('kursy')->insert($kursyData);
    }
}
