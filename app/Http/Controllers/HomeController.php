<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Instruktor;
use App\Models\Course; // Dodaj import modelu Course
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
{
    // Pobieramy losowo 3 kursy z instruktorami
    $kursy = Course::with('instructor')->inRandomOrder()->take(3)->get();

    // Mapujemy kursy, aby dodać pełny URL do zdjęcia z fallbackiem
    $kursy->transform(function ($kurs) {
        if (!empty($kurs->zdjecie)) {
            $sciezkaZdjecia = public_path('storage/' . $kurs->zdjecie);
            $kurs->zdjecie_url = File::exists($sciezkaZdjecia)
                ? asset('storage/' . $kurs->zdjecie)
                : asset('img/default-course.png');
        } else {
            $kurs->zdjecie_url = asset('img/default-course.png');
        }
        return $kurs;
    });

    // Instruktorzy
    $instruktorzy = Instruktor::inRandomOrder()->take(5)->get();
    $instruktorzy->transform(function ($instruktor) {
        $sciezkaZdjecia = public_path($instruktor->adres_zdjecia);
        $instruktor->zdjecie_url = (!empty($instruktor->adres_zdjecia) && File::exists($sciezkaZdjecia))
            ? asset($instruktor->adres_zdjecia)
            : asset('img/ZdjeciaInstruktorow/brak.png');
        return $instruktor;
    });

    return view('home', compact('instruktorzy', 'kursy'));
}
}
