<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktor;

class InstruktorzyController extends Controller
{
        public function index()
    {
        $instruktorzy = Instruktor::paginate(10);

        return view('instruktorzy.instruktorzy', compact('instruktorzy'));
    }


    public function show($id)
    {
        $instruktor = Instruktor::with('kursy')->findOrFail($id);
        return view('instruktorzy.show', compact('instruktor'));
    }



    public function create()
    {
        return view('instruktorzy.create'); // shows the form to add an instructor
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:instruktorzy,email',
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'jezyk' => 'required|string|max:255',
            'poziom' => 'required|string|max:255',
            'placa' => 'required|numeric|min:0',
        ]);

        Instruktor::create($validated);

        return redirect('instruktorzy')->with('success', 'Instruktor został dodany.');
    }

    public function edit($id)
    {
        $instruktor = Instruktor::findOrFail($id);
        return view('instruktorzy.edit', compact('instruktor'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'imie' => 'required|string|max:255',
            'nazwisko' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'jezyk' => 'required|string|max:255',
            'poziom' => 'required|string|max:255',
            'placa' => 'required|numeric|min:0',
        ]);

        $instruktor = Instruktor::findOrFail($id);
        $instruktor->update($validated);

        return redirect('instruktorzy')->with('success', 'Instruktor został zaktualizowany.');
    }

    public function destroy($id)
    {
        $instruktor = Instruktor::findOrFail($id);
        $instruktor->delete();

        return redirect('instruktorzy')->with('success', 'Instruktor został usunięty.');
    }

}
