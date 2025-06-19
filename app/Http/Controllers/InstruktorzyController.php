<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktor;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InstruktorzyController extends Controller
{
    public function index()
    {
        $instruktorzy = Instruktor::active()->paginate(10);
        return view('instruktorzy.instruktorzy', compact('instruktorzy'));
    }

    public function create()
    {
        return view('instruktorzy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'imie' => 'required|string|max:255|min:2',
            'nazwisko' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:instruktorzy,email',
            'jezyk' => 'required|string|in:Angielski,Niemiecki,Francuski,Hiszpański,Włoski,Rosyjski',
            'poziom' => 'required|string|in:Początkujący,Średniozaawansowany,Zaawansowany',
            'placa' => 'required|numeric|between:20,500|regex:/^\d+(\.\d{1,2})?$/',
            'zdjecie' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            // Imię
            'imie.required' => 'Pole imię jest wymagane.',
            'imie.string' => 'Imię musi być tekstem.',
            'imie.max' => 'Imię nie może być dłuższe niż 255 znaków.',
            'imie.min' => 'Imię musi mieć co najmniej 2 znaki.',

            // Nazwisko
            'nazwisko.required' => 'Pole nazwisko jest wymagane.',
            'nazwisko.string' => 'Nazwisko musi być tekstem.',
            'nazwisko.max' => 'Nazwisko nie może być dłuższe niż 255 znaków.',
            'nazwisko.min' => 'Nazwisko musi mieć co najmniej 2 znaki.',

            // Email
            'email.required' => 'Pole email jest wymagane.',
            'email.email' => 'Podaj prawidłowy adres email.',
            'email.unique' => 'Ten adres email jest już zajęty.',

            // Język
            'jezyk.required' => 'Wybór języka jest wymagany.',
            'jezyk.in' => 'Wybierz język z dostępnej listy.',

            // Poziom
            'poziom.required' => 'Wybór poziomu jest wymagany.',
            'poziom.in' => 'Wybierz poziom z dostępnej listy (Początkujący, Średniozaawansowany, Zaawansowany).',

            // Płaca
            'placa.required' => 'Pole płaca jest wymagane.',
            'placa.numeric' => 'Płaca musi być liczbą (np. 50 lub 45.50).',
            'placa.between' => 'Płaca musi być między 20 a 500 zł/h.',
            'placa.regex' => 'Płaca może mieć maksymalnie 2 miejsca po przecinku (np. 45.50).',

            // Zdjęcie
            'zdjecie.image' => 'Plik musi być zdjęciem.',
            'zdjecie.mimes' => 'Zdjęcie musi być w formacie: jpeg, png, jpg, gif lub webp.',
            'zdjecie.max' => 'Rozmiar zdjęcia nie może przekraczać 2MB.',
        ]);

        $folder = public_path('img/ZdjeciaInstruktorow');
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        if ($request->hasFile('zdjecie')) {
            $plik = $request->file('zdjecie');

            $imie = Str::slug($request->imie, '-');
            $nazwisko = Str::slug($request->nazwisko, '-');
            $extension = $plik->getClientOriginalExtension();
            $nazwaPliku = $imie . '-' . $nazwisko . '.' . $extension;

            $finalPath = $folder . '/' . $nazwaPliku;
            if (File::exists($finalPath)) {
                $nazwaPliku = $imie . '-' . $nazwisko . '-' . time() . '.' . $extension;
            }

            $plik->move($folder, $nazwaPliku);
            $sciezkaZdjecia = 'img/ZdjeciaInstruktorow/' . $nazwaPliku;
        } else {
            $sciezkaZdjecia = null;
        }

        Instruktor::create([
            'imie' => $request->imie,
            'nazwisko' => $request->nazwisko,
            'email' => $request->email,
            'jezyk' => $request->jezyk,
            'poziom' => $request->poziom,
            'placa' => $request->placa,
            'adres_zdjecia' => $sciezkaZdjecia,
        ]);

        return redirect()->route('instruktorzy.instruktorzy')
            ->with('success', "Instruktor {$request->imie} {$request->nazwisko} został pomyślnie dodany do systemu.");
    }

    public function destroy($id)
    {
        $instruktor = Instruktor::findOrFail($id);

        $instruktor->update(['is_deleted' => true]);

        return redirect()->route('instruktorzy.instruktorzy')
            ->with('success', "Instruktor {$instruktor->imie} {$instruktor->nazwisko} został usunięty z listy aktywnych. Dane zachowano w kursach.");
    }

    public function edit($id)
    {
        $instruktor = Instruktor::findOrFail($id);
        return view('instruktorzy.edit', compact('instruktor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'imie' => 'required|string|max:255|min:2',
            'nazwisko' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:instruktorzy,email,' . $id,
            'jezyk' => 'required|string|in:Angielski,Niemiecki,Francuski,Hiszpański,Włoski,Rosyjski',
            'poziom' => 'required|string|in:Początkujący,Średniozaawansowany,Zaawansowany',
            'placa' => 'required|numeric|between:20,500|regex:/^\d+(\.\d{1,2})?$/',
            'zdjecie' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            // Imię
            'imie.required' => 'Pole imię jest wymagane.',
            'imie.string' => 'Imię musi być tekstem.',
            'imie.max' => 'Imię nie może być dłuższe niż 255 znaków.',
            'imie.min' => 'Imię musi mieć co najmniej 2 znaki.',

            // Nazwisko
            'nazwisko.required' => 'Pole nazwisko jest wymagane.',
            'nazwisko.string' => 'Nazwisko musi być tekstem.',
            'nazwisko.max' => 'Nazwisko nie może być dłuższe niż 255 znaków.',
            'nazwisko.min' => 'Nazwisko musi mieć co najmniej 2 znaki.',

            // Email
            'email.required' => 'Pole email jest wymagane.',
            'email.email' => 'Podaj prawidłowy adres email.',
            'email.unique' => 'Ten adres email jest już zajęty.',

            // Język
            'jezyk.required' => 'Wybór języka jest wymagany.',
            'jezyk.in' => 'Wybierz język z dostępnej listy.',

            // Poziom
            'poziom.required' => 'Wybór poziomu jest wymagany.',
            'poziom.in' => 'Wybierz poziom z dostępnej listy (Początkujący, Średniozaawansowany, Zaawansowany).',

            // Płaca
            'placa.required' => 'Pole płaca jest wymagane.',
            'placa.numeric' => 'Płaca musi być liczbą (np. 50 lub 45.50).',
            'placa.regex' => 'Płaca może mieć maksymalnie 2 miejsca po przecinku (np. 45.50).',

            // Zdjęcie
            'zdjecie.image' => 'Plik musi być zdjęciem.',
            'zdjecie.mimes' => 'Zdjęcie musi być w formacie: jpeg, png, jpg, gif lub webp.',
            'zdjecie.max' => 'Rozmiar zdjęcia nie może przekraczać 2MB.',
        ]);

        $instruktor = Instruktor::findOrFail($id);

        $instruktor->imie = $request->imie;
        $instruktor->nazwisko = $request->nazwisko;
        $instruktor->email = $request->email;
        $instruktor->jezyk = $request->jezyk;
        $instruktor->poziom = $request->poziom;
        $instruktor->placa = $request->placa;

        if ($request->has('usun_zdjecie') && $request->input('usun_zdjecie') == '1') {
            if ($instruktor->adres_zdjecia && File::exists(public_path($instruktor->adres_zdjecia))) {
                File::delete(public_path($instruktor->adres_zdjecia));
            }
            $instruktor->adres_zdjecia = null;
        }

        if ($request->hasFile('zdjecie')) {
            $folder = public_path('img/ZdjeciaInstruktorow');
            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            if ($instruktor->adres_zdjecia && File::exists(public_path($instruktor->adres_zdjecia))) {
                File::delete(public_path($instruktor->adres_zdjecia));
            }

            $plik = $request->file('zdjecie');

            $imie = Str::slug($request->imie, '-');
            $nazwisko = Str::slug($request->nazwisko, '-');
            $extension = $plik->getClientOriginalExtension();
            $nazwaPliku = $imie . '-' . $nazwisko . '.' . $extension;

            $finalPath = $folder . '/' . $nazwaPliku;
            if (File::exists($finalPath)) {
                $nazwaPliku = $imie . '-' . $nazwisko . '-' . time() . '.' . $extension;
            }

            $plik->move($folder, $nazwaPliku);
            $instruktor->adres_zdjecia = 'img/ZdjeciaInstruktorow/' . $nazwaPliku;
        }

        $instruktor->save();

        return redirect()->route('instruktorzy.instruktorzy')
            ->with('success', "Dane instruktora {$instruktor->imie} {$instruktor->nazwisko} zostały pomyślnie zaktualizowane.");
    }
}
