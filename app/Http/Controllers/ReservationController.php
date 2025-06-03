<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Course;
use Illuminate\Support\Carbon;

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

    try {
        \DB::transaction(function () use ($validated) {
            $course = Course::lockForUpdate()->findOrFail($validated['course']);

            if (now()->between($course->data_rozpoczecia, $course->data_zakonczenia)) {
                throw new \Exception('Nie można zapisać się na kurs, który już się rozpoczął.');
            }

            if ($course->reservations()->count() >= $course->liczba_miejsc) {
                throw new \Exception('Brak wolnych miejsc na ten kurs.');
            }

            Reservation::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'course_id' => $course->id_kursu,
            ]);
        });

        return redirect()
            ->route('rezerwacja.create')
            ->with('success', 'Rezerwacja została pomyślnie dodana!');
    } catch (\Exception $e) {
        return back()
            ->withErrors(['course' => $e->getMessage()])
            ->withInput();
    }
}

}

