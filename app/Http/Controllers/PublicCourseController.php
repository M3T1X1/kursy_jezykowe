<?php
namespace App\Http\Controllers;

use App\Models\Course; 
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('oferta', ['courses' => $courses]);
    }
    
    public function show($id)
    {
    $course = Course::findOrFail($id);
    return view('course-details', compact('course'));
    }
}
