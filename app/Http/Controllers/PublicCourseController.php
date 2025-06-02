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
}
