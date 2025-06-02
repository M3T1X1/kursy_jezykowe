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
    
   
    // Szczegóły kursu
    public function show($id) {
        $course = Course::with('instructor')->findOrFail($id);
        return view('course-details', compact('course'));
    }

    public function create() {
        $instruktorzy = Instruktor::all();
        return view('create-course', compact('instruktorzy'));
    }
    
    public function edit($id) {
        $course = Course::findOrFail($id);
        $instruktorzy = Instruktor::all();
        return view('edit-course', compact('course', 'instruktorzy'));
    }

    public function update(Request $request, $id) {

    $course = Course::findOrFail($id);

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

    public function destroy($id) {

    $course = Course::findOrFail($id);
    $course->delete();

    return redirect()->route('kursy.index')->with('success', 'Kurs został usunięty.');
    }
}
