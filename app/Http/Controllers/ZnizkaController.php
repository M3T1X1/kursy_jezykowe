<?php

namespace App\Http\Controllers;

use App\Models\Znizka;
use Illuminate\Http\Request;

class ZnizkaController extends Controller
{
    // Wyświetl listę zniżek
    public function index()
    {
        $znizki = Znizka::all();
        return view('znizki.znizki', compact('znizki'));  // <--- zmienione na 'znizki.znizki'
    }

    // Pokaż formularz dodawania nowej zniżki
  public function create()
{
    return view('znizki.dodajZnizke');
}
    // Zapisz nową zniżkę do bazy
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nazwa_znizki' => 'required|string|max:255',
            'wartosc' => 'required|integer|min:0|max:100',
            'opis' => 'nullable|string',
        ]);

        Znizka::create($validated);

        return redirect()->route('znizki.index')->with('success', 'Zniżka została dodana.');
    }

    // Pokaż formularz edycji zniżki
    public function edit(Znizka $znizka)
    {
        return view('znizki.edit', compact('znizka'));
    }

    // Zaktualizuj zniżkę w bazie
    public function update(Request $request, Znizka $znizka)
    {
        $validated = $request->validate([
            'nazwa_znizki' => 'required|string|max:255',
            'wartosc' => 'required|integer|min:0|max:100',
            'opis' => 'nullable|string',
        ]);

        $znizka->update($validated);

        return redirect()->route('znizki.index')->with('success', 'Zniżka została zaktualizowana.');
    }

    // Usuń zniżkę
    public function destroy(Znizka $znizka)
    {
        $znizka->delete();

        return redirect()->route('znizki.index')->with('success', 'Zniżka została usunięta.');
    }
}
