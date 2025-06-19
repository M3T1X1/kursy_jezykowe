<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Instruktor;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request) {
        $query = Course::with('instructor');
        $courses = $query->get();
        return view('course', compact('courses'));
    }
    
    public function show($kursy) {
        $course = Course::with('instructor')->findOrFail($kursy);
        return view('course-details', compact('course'));
    }

    public function create() {
        $instruktorzy = Instruktor::all();
        return view('create-course', compact('instruktorzy'));
    }
    
    public function edit($kursy) {
        $course = Course::findOrFail($kursy);
        $instruktorzy = Instruktor::all();
        return view('edit-course', compact('course', 'instruktorzy'));
    }

    public function update(Request $request, $kursy) {
        $course = Course::findOrFail($kursy);
    
        $validatedData = $request->validate([
            'jezyk' => 'required|string|max:255',
            'poziom' => 'required|string|max:255',
            'data_rozpoczecia' => 'required|date',
            'data_zakonczenia' => 'required|date|after_or_equal:data_rozpoczecia',
            'cena' => 'required|numeric|min:0',
            'liczba_miejsc' => 'required|integer|min:1',
            'id_instruktora' => 'required|exists:instruktorzy,id',
            'zdjecie' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120', // Zmienione z 'image' na 'file'
            'usun_zdjecie' => 'nullable|boolean'
        ], [
            'jezyk.required' => 'Pole język jest wymagane.',
            'poziom.required' => 'Pole poziom jest wymagane.',
            'data_rozpoczecia.required' => 'Data rozpoczęcia jest wymagana.',
            'data_zakonczenia.required' => 'Data zakończenia jest wymagana.',
            'data_zakonczenia.after_or_equal' => 'Data zakończenia musi być późniejsza lub równa dacie rozpoczęcia.',
            'cena.required' => 'Cena jest wymagana.',
            'cena.numeric' => 'Cena musi być liczbą.',
            'cena.min' => 'Cena nie może być ujemna.',
            'liczba_miejsc.required' => 'Liczba miejsc jest wymagana.',
            'liczba_miejsc.integer' => 'Liczba miejsc musi być liczbą całkowitą.',
            'liczba_miejsc.min' => 'Liczba miejsc musi być większa od 0.',
            'id_instruktora.required' => 'Wybór instruktora jest wymagany.',
            'id_instruktora.exists' => 'Wybrany instruktor nie istnieje.',
            'zdjecie.file' => 'Pole musi zawierać plik.',
            'zdjecie.mimes' => 'Zdjęcie musi być w formacie: jpeg, png, jpg, gif lub webp.',
            'zdjecie.max' => 'Rozmiar zdjęcia nie może przekraczać 5MB.'
        ]);
    
        // Obsługa zdjęcia
        if ($request->hasFile('zdjecie')) {
            // Usuń stare zdjęcie jeśli istnieje
            if ($course->zdjecie) {
                Storage::disk('public')->delete($course->zdjecie);
            }
            
            // Zapisz nowe zdjęcie z bezpieczną nazwą
            $file = $request->file('zdjecie');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('courses', $filename, 'public');
            $validatedData['zdjecie'] = $path;
        } elseif ($request->has('usun_zdjecie') && $request->usun_zdjecie) {
            // Usuń zdjęcie jeśli zaznaczono checkbox
            if ($course->zdjecie) {
                Storage::disk('public')->delete($course->zdjecie);
            }
            $validatedData['zdjecie'] = null;
        }
    
        // Usuń checkbox z danych do aktualizacji
        unset($validatedData['usun_zdjecie']);
    
        $course->update($validatedData);
    
        return redirect()->route('kursy.index')->with('success', 'Kurs został zaktualizowany.');
    }


    public function store(Request $request) {
        $validatedData = $request->validate([
            'jezyk' => 'required|string|max:255',
            'poziom' => 'required|string|max:255',
            'data_rozpoczecia' => 'required|date',
            'data_zakonczenia' => 'required|date|after_or_equal:data_rozpoczecia',
            'cena' => 'required|numeric|min:0',
            'liczba_miejsc' => 'required|integer|min:1',
            'id_instruktora' => 'required|exists:instruktorzy,id',
            'zdjecie' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ], [
            'jezyk.required' => 'Pole język jest wymagane.',
            'poziom.required' => 'Pole poziom jest wymagane.',
            'data_rozpoczecia.required' => 'Data rozpoczęcia jest wymagana.',
            'data_zakonczenia.required' => 'Data zakończenia jest wymagana.',
            'data_zakonczenia.after_or_equal' => 'Data zakończenia musi być późniejsza lub równa dacie rozpoczęcia.',
            'cena.required' => 'Cena jest wymagana.',
            'cena.numeric' => 'Cena musi być liczbą.',
            'cena.min' => 'Cena nie może być ujemna.',
            'liczba_miejsc.required' => 'Liczba miejsc jest wymagana.',
            'liczba_miejsc.integer' => 'Liczba miejsc musi być liczbą całkowitą.',
            'liczba_miejsc.min' => 'Liczba miejsc musi być większa od 0.',
            'id_instruktora.required' => 'Wybór instruktora jest wymagany.',
            'id_instruktora.exists' => 'Wybrany instruktor nie istnieje.',
            'zdjecie.file' => 'Pole musi zawierać plik.',
            'zdjecie.mimes' => 'Zdjęcie musi być w formacie: jpeg, png, jpg, gif lub webp.',
            'zdjecie.max' => 'Rozmiar zdjęcia nie może przekraczać 5MB.'
        ]);
    
        // Obsługa zdjęcia
        if ($request->hasFile('zdjecie')) {
            $file = $request->file('zdjecie');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('courses', $filename, 'public');
            $validatedData['zdjecie'] = $path;
        }
    
        Course::create($validatedData);
    
        return redirect()->route('kursy.index')->with('success', 'Kurs został dodany.');
    }
    

    public function destroy($kursy) {
        $course = Course::findOrFail($kursy);
        
        // Usuń zdjęcie jeśli istnieje
        if ($course->zdjecie) {
            Storage::disk('public')->delete($course->zdjecie);
        }
        
        $course->delete();

        return redirect()->route('kursy.index')->with('success', 'Kurs został usunięty.');
    }
}
