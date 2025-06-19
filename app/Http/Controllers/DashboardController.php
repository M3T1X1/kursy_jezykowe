<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Klient;
use App\Models\Instruktor;
use App\Models\Znizka;
use App\Models\Transakcja;

class DashboardController extends Controller
{
    public function index()
{
    $recentEnrollments = Transakcja::with(['klient', 'kurs'])
        ->orderBy('data', 'desc')
        ->take(5)
        ->get()
        ->map(function($t) {
            return (object)[
                'client_name'    => $t->klient_imie . ' ' . $t->klient_nazwisko,
                'client_email'   => $t->klient_email,
                'course_name' => $t->kurs ? ($t->kurs->jezyk . ' ' . $t->kurs->poziom) : 'Brak kursu',
                'course_id'      => $t->kurs->id_kursu,
                'kurs' => $t->kurs_jezyk . ' ' . $t->kurs_poziom,
                'course_date'    => ($t->kurs && $t->kurs->data_rozpoczecia) ? \Carbon\Carbon::parse($t->kurs->data_rozpoczecia)->format('Y-m-d') : '',
                'instructor'     => ($t->kurs && $t->kurs->instructor) ? ($t->kurs->instructor->imie . ' ' . $t->kurs->instructor->nazwisko) : 'Brak instruktora',
                'amount' => $t->cena_ostateczna,
                'status'         => $t->status,
                'transaction_date'=> $t->data ? \Carbon\Carbon::parse($t->data)->format('Y-m-d') : '',
            ];
        });

    return view('dashboard', [
        'coursesCount'      => Course::count(),
        'clientsCount'      => Klient::count(),
        'instructorsCount'  => Instruktor::count(),
        'discountsCount'    => Znizka::where('active', 1)->count(),
        'recentEnrollments' => $recentEnrollments,
    ]);
}

}
