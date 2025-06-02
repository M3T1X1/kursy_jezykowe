<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktor;

class InstruktorzyController extends Controller
{
    public function index()
    {
        $instruktorzy = Instruktor::with('kursy')->get();
        return view('instruktorzy.index', compact('instruktorzy'));
    }

    public function show($id)
    {
        $instruktor = Instruktor::with('kursy')->findOrFail($id);
        return view('instruktorzy.show', compact('instruktor'));
    }
}
