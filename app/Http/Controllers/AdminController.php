<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showTransactions()
    {
        // Tymczasowo statyczne dane, potem zastąpisz to zapytaniem do bazy
        $daneZBazy = [
            (object)[
                'kursant' => 'Anna Nowak',
                'email' => 'anna.nowak@email.pl',
                'kurs' => 'Angielski - podstawowy',
                'kurs_id' => 1,
                'data_kursu' => '2025-06-01',
                'cena' => '1200 PLN',
                'status' => 'Opłacone',
                'data_transakcji' => '2025-05-04'
            ],
            (object)[
                'kursant' => 'Piotr Kowalski',
                'email' => 'piotr.kowalski@email.pl',
                'kurs' => 'Hiszpański - średniozaawansowany',
                'kurs_id' => 2,
                'data_kursu' => '2025-06-15',
                'cena' => '1350 PLN',
                'status' => 'Oczekuje',
                'data_transakcji' => '2025-05-03'
            ],
            // Dodaj więcej obiektów według potrzeb
        ];

        return view('admin.transactions', ['transactions' => $daneZBazy]);
    }

    public function index()
    {
        return redirect()->route('dashboard');
    }
}
