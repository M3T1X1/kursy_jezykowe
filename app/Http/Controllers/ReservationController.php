<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Reservation, Course, Transakcja, Klient};
use Illuminate\Support\Facades\{DB, Auth};

class ReservationController extends Controller
{
    // Formularz rezerwacji dla zalogowanego użytkownika
    public function create(Request $request)
    {
        // Sprawdź, czy użytkownik jest zalogowany
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby dokonać rezerwacji.');
        }

        $courses = Course::all();
        $selectedCourse = null;
        if ($request->has('course')) {
            $selectedCourse = $courses->firstWhere('id_kursu', $request->input('course'));
        }
        if (!$selectedCourse && $courses->count()) {
            $selectedCourse = $courses->first();
        }

        // Pobierz dane zalogowanego użytkownika
        $user = Auth::user();

        return view('rezerwacja', compact('courses', 'selectedCourse', 'user'));
    }

    // Zapisz rezerwację dla zalogowanego użytkownika
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby dokonać rezerwacji.');
        }

        $validated = $request->validate([
            'course' => 'required|exists:kursy,id_kursu',
        ]);

        $user = Auth::user();

        try {
            DB::transaction(function () use ($validated, $user) {
                $course = Course::lockForUpdate()->findOrFail($validated['course']);

                // Walidacja dostępności
                if (now()->between($course->data_rozpoczecia, $course->data_zakonczenia)) {
                    throw new \Exception('Nie można zapisać się na kurs, który już się rozpoczął.');
                }

                if (method_exists($course, 'reservations') && $course->reservations()->count() >= $course->liczba_miejsc) {
                    throw new \Exception('Brak wolnych miejsc na ten kurs.');
                }

                if (now()->gt($course->data_zakonczenia)) {
                    throw new \Exception('Nie można zapisać się na kurs, który już się zakończył.');
                }

                // Sprawdź, czy użytkownik już nie ma rezerwacji na ten kurs
                $existingReservation = Reservation::where('email', $user->email)
                    ->where('course_id', $course->id_kursu)
                    ->first();

                if ($existingReservation) {
                    throw new \Exception('Już masz rezerwację na ten kurs.');
                }

                // Znajdź klienta w tabeli klienci (jeśli używasz osobnej tabeli)
                $client = Klient::where('email', $user->email)->first();
                if (!$client) {
                    throw new \Exception('Nie znaleziono danych klienta w systemie.');
                }

                // Utwórz rezerwację
                $reservation = Reservation::create([
                    'imie' => $user->imie ?? $user->name,
                    'nazwisko' => $user->nazwisko ?? '',
                    'email' => $user->email,
                    'nr_telefonu' => $user->nr_telefonu ?? '',
                    'course_id' => $course->id_kursu,
                    'base_price' => $course->cena,
                ]);
                
                // Pobierz aktywną największą zniżkę klienta
                $activeDiscount = $client->znizki()
                ->where('active', true)
                ->orderByDesc('wartosc')
                ->first();

                $discountValue = $activeDiscount->wartosc ?? 0;
                $discountedPrice = $course->cena * (1 - $discountValue / 100);

                $transakcja = Transakcja::create([
                    'id_kursu' => $course->id_kursu,
                    'id_klienta' => $client->id_klienta,
                    'klient_imie' => $client->imie,
                    'klient_nazwisko' => $client->nazwisko,
                    'klient_email' => $client->email,
                    'cena_ostateczna' => $discountedPrice,
                    'status' => 'Oczekuje',
                    'data' => now(),
                    'reservation_id' => $reservation->id, 
                ]);
            });

            // Przekierowanie na stronę główną z komunikatem sukcesu
            return redirect()
                ->route('home') // lub route('dashboard')
                ->with('success', 'Rezerwacja została pomyślnie utworzona!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['course' => $e->getMessage()])
                ->withInput();
        }
    }
}
