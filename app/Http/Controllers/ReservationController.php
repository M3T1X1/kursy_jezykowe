<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Reservation, Course, Transakcja, Klient};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    // Wyświetl wszystkie rezerwacje (np. dla admina)
    public function index()
    {
        $reservations = Reservation::with('course')->get();
        return view('rezerwacje.index', compact('reservations'));
    }

    // Formularz rezerwacji
    public function create(Request $request)
    {
        $courses = Course::all();
        $selectedCourse = null;
        if ($request->has('course')) {
            $selectedCourse = $courses->firstWhere('id_kursu', $request->input('course'));
        }
        if (!$selectedCourse && $courses->count()) {
            $selectedCourse = $courses->first();
        }
        return view('rezerwacja', compact('courses', 'selectedCourse'));
    }

    // Zapisz rezerwację i utwórz transakcję, a potem przekieruj do rejestracji
    public function store(Request $request)
    {
        $wiadomosci = 
        [
            'nr_telefonu.regex' => "Numer telefonu musi składać się z 9 cyfr (tylko i wyłącznie)!"
        ];

        $validated = $request->validate([
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nr_telefonu' => ['required', 'regex:/^[0-9]{9}$/'],
            'course' => 'required|exists:kursy,id_kursu',
        ], $wiadomosci);

        try {
            DB::transaction(function () use ($validated) {

               $existingReservation = Reservation::where('email', $validated['email'])
               ->where('course_id', $validated['course'])
               ->exists();

                if ($existingReservation) 
                {
                    throw new \Exception('Ten e-mail jest już zapisany na wybrany kurs.');
                }

                $course = Course::lockForUpdate()->findOrFail($validated['course']);

                if (now()->between($course->data_rozpoczecia, $course->data_zakonczenia)) {
                    throw new \Exception('Nie można zapisać się na kurs, który już się rozpoczął.');
                }

                if (method_exists($course, 'reservations') && $course->reservations()->count() >= $course->liczba_miejsc) {
                    throw new \Exception('Brak wolnych miejsc na ten kurs.');
                }

                
                $client = Klient::firstOrCreate(
                    ['email' => $validated['email']],
                    [
                        'imie' => $validated['imie'],
                        'nazwisko' => $validated['nazwisko'],
                        'nr_telefonu' => $validated['nr_telefonu'],
                        'haslo' => bcrypt(Str::random(12)),
                        'adres' => 'Nie podano',
                        'role' => 'klient'
                    ]
                );
                
                $reservation = Reservation::create([
                    'imie' => $validated['imie'],
                    'nazwisko' => $validated['nazwisko'],
                    'email' => $validated['email'],
                    'nr_telefonu' => $validated['nr_telefonu'],
                    'course_id' => $course->id_kursu,
                    'base_price' => $course->cena,
                ]);

                $activeDiscount = $client->znizki()
                ->where('active', true)
                ->orderByDesc('wartosc') // jeśli chcesz wziąć największą zniżkę
                ->first();

                $discountValue = $activeDiscount ? $activeDiscount->wartosc : 0;

                $discountedPrice = $course->cena * (1 - $discountValue / 100);

                Transakcja::create([
                    'id_kursu' => $course->id_kursu,
                    'id_klienta' => $client->id_klienta,
                    'cena_ostateczna' => $discountedPrice,
                    'status' => 'Oczekuje',
                    'data' => now(),
                ]);
            });

            // Przekierowanie do rejestracji z przekazaniem e-maila
         

           $emailExists = Klient::where('email', $validated['email'])->exists();

            if ($emailExists) {
                return redirect()
                    ->route('home', ['email' => $validated['email']])
                    ->with('success', 'Rezerwacja została zapisana!');
            } else {
                return redirect()
                    ->route('register.form', ['email' => $validated['email']])
                    ->with('success', 'Rezerwacja została zapisana. Proszę teraz się zarejestrować!');
            }
        } catch (\Exception $e) {
            return back()
                ->withErrors(['course' => $e->getMessage()])
                ->withInput();
        }
    }
}
