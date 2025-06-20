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
        return view('auth.register');
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
            'email.required' => 'Pole Email jest wymagane.',
            'email.email' => 'Podaj poprawny adres email.',
            'email.unique' => 'Ten adres email jest już zajęty.',

            'password.required' => 'Pole Hasło jest wymagane.',
            'password.min' => 'Hasło musi mieć co najmniej 6 znaków.',

            'imie.required' => 'Pole Imię jest wymagane.',

            'nazwisko.required' => 'Pole Nazwisko jest wymagane.',

            'adres.required' => 'Pole Adres jest wymagane.',
            'adres.regex' => 'Adres musi być w formacie: ul. Nazwa, Miasto',

            'nr_telefonu.required' => 'Pole Nr telefonu jest wymagane.',
            'nr_telefonu.regex' => 'Numer telefonu musi składać się z dokładnie 9 cyfr.',

            'zdjecie.image' => 'Plik musi być obrazem (jpg, png, itp.).',
            'zdjecie.max' => 'Zdjęcie nie może być większe niż 2MB.',
        ]);

        if ($request->hasFile('zdjecie')) {
            $path = $request->file('zdjecie')->store('klienci', 'public');
            $validated['adres_zdjecia'] = $path;
        }

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

        if ($request->has('admin')) {
            return redirect()->route('klienci.index')->with('success', 'Klient został dodany!');
        } else {
            Auth::login($klient);
            return redirect()->route('login')->with('success', 'Rejestracja zakończona sukcesem! Możesz się zalogować.');
        }
    }
}
