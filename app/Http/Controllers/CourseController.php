<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Instruktor;
use Illuminate\Support\Facades\Storage;
use App\Models\Transakcja; 

class CourseController extends Controller
{
    public function index(Request $request) {
        $courses = Course::with(['instructor', 'transakcje'])->get();
        
        foreach ($courses as $course) {
            $today = now()->toDateString();
            $courseIsRunning = $course->data_rozpoczecia <= $today && $course->data_zakonczenia >= $today;
            
            if ($courseIsRunning) {
                $hasActiveTransactions = $course->transakcje()
                    ->whereIn('status', ['Oczekuje', 'Opłacone'])
                    ->exists();
                $course->canDelete = !$hasActiveTransactions;
            } else {
                $course->canDelete = true;
            }
        }
        
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
            'jezyk' => 'required|string|min:2|max:50|regex:/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$/',
            'poziom' => 'required|in:Początkujący,Średniozaawansowany,Zaawansowany',
            'data_rozpoczecia' => 'required|date|after_or_equal:today',
            'data_zakonczenia' => 'required|date|after:data_rozpoczecia',
            'cena' => 'required|numeric|min:1|max:99999999.99',
            'liczba_miejsc' => 'required|integer|min:1|max:1000',
            'id_instruktora' => 'required|exists:instruktorzy,id',
            'zdjecie' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'usun_zdjecie' => 'nullable|boolean'
        ], [
            // Walidacja języka
            'jezyk.required' => 'Pole język jest wymagane.',
            'jezyk.string' => 'Język musi być tekstem.',
            'jezyk.min' => 'Język musi mieć co najmniej 2 znaki.',
            'jezyk.max' => 'Język nie może mieć więcej niż 50 znaków.',
            'jezyk.regex' => 'Język może zawierać tylko litery i spacje.',
            
            // Walidacja poziomu
            'poziom.required' => 'Wybór poziomu jest wymagany.',
            'poziom.in' => 'Wybrany poziom jest nieprawidłowy.',
            
            // Walidacja dat
            'data_rozpoczecia.required' => 'Data rozpoczęcia jest wymagana.',
            'data_rozpoczecia.date' => 'Data rozpoczęcia musi być prawidłową datą.',
            'data_rozpoczecia.after_or_equal' => 'Data rozpoczęcia nie może być wcześniejsza niż dzisiaj.',
            'data_zakonczenia.required' => 'Data zakończenia jest wymagana.',
            'data_zakonczenia.date' => 'Data zakończenia musi być prawidłową datą.',
            'data_zakonczenia.after' => 'Data zakończenia musi być późniejsza niż data rozpoczęcia.',
            
            // Walidacja ceny
            'cena.required' => 'Cena jest wymagana.',
            'cena.numeric' => 'Cena musi być liczbą.',
            'cena.min' => 'Cena musi być większa od 0.',
            'cena.max' => 'Cena nie może przekraczać 99 999 999,99 zł.',
            
            // Walidacja miejsc
            'liczba_miejsc.required' => 'Liczba miejsc jest wymagana.',
            'liczba_miejsc.integer' => 'Liczba miejsc musi być liczbą całkowitą.',
            'liczba_miejsc.min' => 'Liczba miejsc musi być większa od 0.',
            'liczba_miejsc.max' => 'Liczba miejsc nie może przekraczać 1000.',
            
            // Walidacja instruktora
            'id_instruktora.required' => 'Wybór instruktora jest wymagany.',
            'id_instruktora.exists' => 'Wybrany instruktor nie istnieje w systemie.',
            
            // Walidacja zdjęcia
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
            'jezyk' => 'required|string|min:2|max:50|regex:/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$/',
            'poziom' => 'required|in:Początkujący,Średniozaawansowany,Zaawansowany',
            'data_rozpoczecia' => 'required|date|after_or_equal:today',
            'data_zakonczenia' => 'required|date|after:data_rozpoczecia',
            'cena' => 'required|numeric|min:1|max:99999999.99',
            'liczba_miejsc' => 'required|integer|min:1|max:1000',
            'id_instruktora' => 'required|exists:instruktorzy,id',
            'zdjecie' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ], [
            // Walidacja języka
            'jezyk.required' => 'Pole język jest wymagane.',
            'jezyk.string' => 'Język musi być tekstem.',
            'jezyk.min' => 'Język musi mieć co najmniej 2 znaki.',
            'jezyk.max' => 'Język nie może mieć więcej niż 50 znaków.',
            'jezyk.regex' => 'Język może zawierać tylko litery i spacje.',
            
            // Walidacja poziomu
            'poziom.required' => 'Wybór poziomu jest wymagany.',
            'poziom.in' => 'Wybrany poziom jest nieprawidłowy.',
            
            // Walidacja dat
            'data_rozpoczecia.required' => 'Data rozpoczęcia jest wymagana.',
            'data_rozpoczecia.date' => 'Data rozpoczęcia musi być prawidłową datą.',
            'data_rozpoczecia.after_or_equal' => 'Data rozpoczęcia nie może być wcześniejsza niż dzisiaj.',
            'data_zakonczenia.required' => 'Data zakończenia jest wymagana.',
            'data_zakonczenia.date' => 'Data zakończenia musi być prawidłową datą.',
            'data_zakonczenia.after' => 'Data zakończenia musi być późniejsza niż data rozpoczęcia.',
            
            // Walidacja ceny
            'cena.required' => 'Cena jest wymagana.',
            'cena.numeric' => 'Cena musi być liczbą.',
            'cena.min' => 'Cena musi być większa od 0.',
            'cena.max' => 'Cena nie może przekraczać 99 999 999,99 zł.',
            
            // Walidacja miejsc
            'liczba_miejsc.required' => 'Liczba miejsc jest wymagana.',
            'liczba_miejsc.integer' => 'Liczba miejsc musi być liczbą całkowitą.',
            'liczba_miejsc.min' => 'Liczba miejsc musi być większa od 0.',
            'liczba_miejsc.max' => 'Liczba miejsc nie może przekraczać 1000.',
            
            // Walidacja instruktora
            'id_instruktora.required' => 'Wybór instruktora jest wymagany.',
            'id_instruktora.exists' => 'Wybrany instruktor nie istnieje w systemie.',
            
            // Walidacja zdjęcia
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
        
       
        $today = now()->toDateString();
        $courseIsRunning = $course->data_rozpoczecia <= $today && $course->data_zakonczenia >= $today;
        
        if ($courseIsRunning) {
            $hasActiveTransactions = Transakcja::where('id_kursu', $course->id_kursu)
                ->whereIn('status', ['Oczekuje', 'Opłacone'])
                ->exists();
            
            if ($hasActiveTransactions) {
                return redirect()->back()->with('error', 
                    'Nie można usunąć kursu, który obecnie trwa i ma zapisanych uczestników.');
            }
        }
        
        
        if ($course->zdjecie && !str_starts_with($course->zdjecie, 'img/')) {
            Storage::disk('public')->delete($course->zdjecie);
        }
        
        $course->delete();
        
        return redirect()->route('kursy.index')->with('success', 'Kurs został usunięty.');
    }
    
}
