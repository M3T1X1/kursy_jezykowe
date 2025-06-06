<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RejestracjaController extends Controller
{
    public function showForm()
    {
        return view('auth.register'); // lub ścieżka do Twojego widoku rejestracji
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:klienci,email',
            'password' => 'required|min:6',
            'imie' => 'required',
            'nazwisko' => 'required',
            'adres' => ['required', 'regex:/^ul\.\s*.+,\s*.+$/i'],
            'nr_telefonu' => ['required', 'regex:/^\d{9}$/'],
            'adres_zdjecia' => 'nullable',
            'zdjecie' => 'nullable|image|max:2048',
        ], [
            'adres.regex' => 'Adres musi być w formacie: ul. Nazwa, Miasto',
            'nr_telefonu.regex' => 'Numer telefonu musi składać się z dokładnie 9 cyfr.',
        ]);

        // Obsługa uploadu zdjęcia
        if ($request->hasFile('zdjecie')) {
            $path = $request->file('zdjecie')->store('klienci', 'public');
            $validated['adres_zdjecia'] = $path;
        }

        // Utwórz nowego klienta
        $klient = Klient::create([
            'email' => $validated['email'],
            'haslo' => Hash::make($validated['password']),
            'imie' => $validated['imie'],
            'nazwisko' => $validated['nazwisko'],
            'adres' => $validated['adres'],
            'nr_telefonu' => $validated['nr_telefonu'],
            'adres_zdjecia' => $validated['adres_zdjecia'] ?? null,
            'role' => 'user',
        ]);

        // Jeśli rejestruje admin (przychodzi parametr 'admin'), NIE loguj nowego klienta!
        if ($request->has('admin')) {
            // Admin zostaje zalogowany, wraca na listę klientów
            return redirect()->route('klienci.index')->with('success', 'Klient został dodany!');
        } else {
            // Zwykła rejestracja – automatyczne logowanie nowego klienta
            Auth::login($klient);
            return redirect()->route('login')->with('success', 'Rejestracja zakończona sukcesem! Możesz się zalogować.');
        }
    }
}
