<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Klient;

class KlientController extends Controller
{
    public function index()
    {
        $klienci = Klient::all();

        $data = $klienci->map(function ($k) {
            return (object)[
                'imie' => $k->imie,
                'nazwisko' => $k->nazwisko,
                'email' => $k->email,
                'adres' => $k->adres,
                'nr_telefonu' => $k->nr_telefonu,
                'adres_zdjecia' => $k->adres_zdjecia,
                'id_klienta' => $k->id_klienta,
            ];
        });

        return view('klienci.klienci', ['klienci' => $data]);
    }

    public function destroy($id_klienta)
    {

        if (Auth::id() == $id_klienta) {
            return redirect()->route('klienci.index')
                ->with('error', 'Nie możesz usunąć swojego własnego konta!');
        }

        $klient = \App\Models\Klient::findOrFail($id_klienta);
        $klient->delete();

        return redirect()->route('klienci.index')->with('success', 'Klient został usunięty.');
    }

    public function edit($id_klienta)
{
    $klient = \App\Models\Klient::findOrFail($id_klienta);
    return view('klienci.edit', compact('klient'));
}

public function update(Request $request, $id_klienta)
{
    $klient = \App\Models\Klient::findOrFail($id_klienta);

    $validated = $request->validate([
        'email' => 'required|email|unique:klienci,email,' . $klient->id_klienta . ',id_klienta',
        'haslo' => 'nullable|min:6',
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

    if ($request->filled('haslo')) {
        $validated['haslo'] = bcrypt($request->input('haslo'));
    } else {
        unset($validated['haslo']);
    }

    $klient->update($validated);

    return redirect()->route('klienci.index')->with('success', 'Dane klienta zostały zaktualizowane.');
}


}

