<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Transakcja;

class TransakcjeController extends Controller
{
    public function index()
    {
        // Pobierz transakcje wraz z klientem, kursem i instruktorem
        $transactions = Transakcja::with(['klient', 'kurs.instructor'])->get();

        // Mapujemy dane, by pasowały do widoku
        $data = $transactions->map(function ($t) {
            return (object)[
                'kursant' => $t->klient->imie . ' ' . $t->klient->nazwisko,
                'email' => $t->klient->email,
                'kurs' => $t->kurs->jezyk . ' ' . $t->kurs->poziom,
                'kurs_id' => $t->kurs->id_kursu,
                'data_kursu' => \Carbon\Carbon::parse($t->kurs->data_rozpoczecia)->format('Y-m-d'),
                'instructor' => $t->kurs->instructor ? ($t->kurs->instructor->imie . ' ' . $t->kurs->instructor->nazwisko) : '-',
                'cena' => number_format($t->cena_ostateczna, 2, ',', ' '),
                'status' => $t->status,
                'data_transakcji' => \Carbon\Carbon::parse($t->data)->format('Y-m-d'),
            ];
        });

        return view('transakcje.transakcje', ['transactions' => $data]);
    }
}