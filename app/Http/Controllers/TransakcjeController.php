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
                'kursant' => $t->klient_imie . ' ' . $t->klient_nazwisko,
                'email' => $t->klient_email,
                'kurs' => $t->kurs->jezyk . ' ' . $t->kurs->poziom,
                'kurs_id' => $t->kurs->id_kursu,
                'data_kursu' => \Carbon\Carbon::parse($t->kurs->data_rozpoczecia)->format('Y-m-d'),
                'instructor' => ($t->kurs && $t->kurs->instructor) ? ($t->kurs->instructor->imie . ' ' . $t->kurs->instructor->nazwisko) : 'Brak instruktora',
                'cena' => number_format($t->cena_ostateczna, 2, ',', ' '),
                'status' => $t->status,
                'data_transakcji' => \Carbon\Carbon::parse($t->data)->format('Y-m-d'),
            ];
        });



        return view('transakcje.transakcje', ['transactions' => $data]);
    }

        public function anulujPrzeterminowane()
    {
        $threshold = Carbon::now()->subDays(7);

        $expired = Transakcja::with('reservation')
            ->where('status', 'Oczekuje')
            ->whereDate('data', '<=', $threshold)
            ->get();

        foreach ($expired as $transakcja) {
            $transakcja->status = 'Anulowana';
            $transakcja->save();

            if ($transakcja->reservation) {
                $transakcja->reservation->delete();
            }
        }

        return redirect()->back()->with('success', 'Przeterminowane transakcje zostały anulowane, a powiązane rezerwacje usunięte.');
    }
}
