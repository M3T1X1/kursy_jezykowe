<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Instruktor;

class CourseController extends Controller
{
    public function index(Request $request) {
        $query = Course::with('instructor');
        $courses = $query->get();
        return view('course', compact('courses'));
    }
    
    public function show($kursy) { // MUSI BYĆ $kursy
        $course = Course::with('instructor')->findOrFail($kursy);
        return view('course-details', compact('course'));
    }

    public function create() {
        $instruktorzy = Instruktor::all();
        return view('create-course', compact('instruktorzy'));
    }
    
    public function edit($kursy) { // MUSI BYĆ $kursy
        $course = Course::findOrFail($kursy);
        $instruktorzy = Instruktor::all();
        return view('edit-course', compact('course', 'instruktorzy'));
    }

    public function update(Request $request, $kursy) { // MUSI BYĆ $kursy
        $course = Course::findOrFail($kursy);

        $validatedData = $request->validate([
            'jezyk' => 'required|string|max:255',
            'poziom' => 'required|string|max:255',
            'data_rozpoczecia' => 'required|date',
            'data_zakonczenia' => 'required|date|after_or_equal:data_rozpoczecia',
            'cena' => 'required|numeric|min:0',
            'liczba_miejsc' => 'required|integer|min:1',
            'id_instruktora' => 'required|exists:instruktorzy,id',
        ]);

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
        ]);

        Course::create($validatedData);

        return redirect()->route('kursy.index')->with('success', 'Kurs został dodany.');
    }

    public function destroy($kursy) { // MUSI BYĆ $kursy
        $course = Course::findOrFail($kursy);
        $course->delete();

        return redirect()->route('kursy.index')->with('success', 'Kurs został usunięty.');
    }
}
