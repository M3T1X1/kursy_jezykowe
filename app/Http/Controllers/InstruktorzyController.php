<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktor;
use Illuminate\Support\Facades\File;

class InstruktorzyController extends Controller
{
    public function index()
    {
        $instruktorzy = Instruktor::paginate(10);
        return view('instruktorzy.instruktorzy', compact('instruktorzy'));
    }

    public function create()
    {
        return view('instruktorzy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'email' => 'required|email|unique:instruktorzy,email',
            'jezyk' => 'required|string',
            'poziom' => 'required|string',
            'placa' => 'required|numeric|min:0',
            'zdjecie' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $folder = public_path('img/ZdjeciaInstruktorow');
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        if ($request->hasFile('zdjecie')) {
            $plik = $request->file('zdjecie');
            $nazwaPliku = time() . '_' . $plik->getClientOriginalName();
            $plik->move($folder, $nazwaPliku);
            $sciezkaZdjecia = 'img/ZdjeciaInstruktorow/' . $nazwaPliku;
        } else {
            $sciezkaZdjecia = null; // lub domyślne zdjęcie, jeśli chcesz
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

        return redirect()->route('instruktorzy.instruktorzy')->with('success', 'Instruktor został dodany.');
    }

    public function destroy($id)
    {
        $instruktor = Instruktor::findOrFail($id);
        if ($instruktor->adres_zdjecia && File::exists(public_path($instruktor->adres_zdjecia))) {
            File::delete(public_path($instruktor->adres_zdjecia));
        }

        $instruktor->delete();

        return redirect()->route('instruktorzy.instruktorzy')->with('success', 'Instruktor został usunięty.');
    }

    public function edit($id)
    {
        $instruktor = Instruktor::findOrFail($id);
        return view('instruktorzy.edit', compact('instruktor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'email' => 'required|email|unique:instruktorzy,email,' . $id,
            'jezyk' => 'required|string',
            'poziom' => 'required|string',
            'placa' => 'required|numeric|min:0',
            'zdjecie' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
            $nazwaPliku = time() . '_' . $plik->getClientOriginalName();
            $plik->move($folder, $nazwaPliku);

            $instruktor->adres_zdjecia = 'img/ZdjeciaInstruktorow/' . $nazwaPliku;
        }

        $instruktor->save();

        return redirect()->route('instruktorzy.instruktorzy')->with('success', 'Instruktor został zaktualizowany.');
    }
}
