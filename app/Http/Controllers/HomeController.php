<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktor;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        // Pobieramy losowo maksymalnie 5 instruktorów
        $instruktorzy = Instruktor::inRandomOrder()->take(5)->get();

        // Mapujemy, aby dodać pełny URL do zdjęcia z fallbackiem
        $instruktorzy->transform(function ($instruktor) {
            $sciezkaZdjecia = public_path($instruktor->adres_zdjecia);

            $instruktor->zdjecie_url = (!empty($instruktor->adres_zdjecia) && File::exists($sciezkaZdjecia))
                ? asset($instruktor->adres_zdjecia)
                : asset('img/ZdjeciaInstruktorow/brak.png');

            return $instruktor;
        });

        return view('home', compact('instruktorzy'));
    }
}
