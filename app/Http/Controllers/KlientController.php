<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Klient;

class KlientController extends Controller
{
    public function index()
    {
        // Pobierz wszystkich klientów
        $klienci = Klient::all();

        // Mapowanie danych (opcjonalnie, jeśli chcesz ujednolicić strukturę)
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
        $klient = \App\Models\Klient::findOrFail($id_klienta);
        $klient->delete();

        // Możesz dodać komunikat flash, jeśli chcesz
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
        'adres' => 'required',
        'nr_telefonu' => 'required',
        'adres_zdjecia' => 'nullable',
        'zdjecie' => 'nullable|image|max:2048',
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

