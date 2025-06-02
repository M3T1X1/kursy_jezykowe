<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Course;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        // Załaduj kursy i przekaż do widoku
        $courses = Course::all();
        return view('rezerwacja', compact('courses'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'course' => 'required|exists:kursy,id_kursu',  
    ]);

    $course = Course::findOrFail($validated['course']);
    $reservedCount = Reservation::where('course_id', $course->id_kursu)->count();

    if ($reservedCount >= $course->liczba_miejsc) {
        return back()->withErrors(['course' => 'Brak wolnych miejsc na ten kurs.'])->withInput();
    }

    Reservation::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'course_id' => $validated['course'],
    ]);

    return redirect()->route('rezerwacja.create')->with('success', 'Rezerwacja została pomyślnie dodana!');
}
}

