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
        return view('dashboard', [
            'coursesCount' => Course::count(),
            'clientsCount' => Klient::count(),
            'instructorsCount' => Instruktor::count(),
            'discountsCount' => Znizka::where('active', 1)->count(),
            'recentEnrollments' => Transakcja::latest()->take(3)->get()->map(function($t) {
                return (object)[
                    'client_name' => $t->klient->imie . ' ' . $t->klient->nazwisko,
                    'course_name' => $t->kurs->nazwa,
                    'date' => $t->created_at->format('Y-m-d'),
                    'status' => $t->status,
                    'amount' => $t->kwota,
                ];
            }),
        ]);
    }
}
