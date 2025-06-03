<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            $request->session()->regenerate();

            //Poniżej fragment dla automatycznych zniżek
            //Zniżki są dodawane w momencie logowania przez klienta

            $user = Auth::user();
            if ($user instanceof \App\Models\Klient) {
                $user->updateAutomaticDiscounts();
            }

            return redirect()->intended('/home'); // lub inna strona po zalogowaniu
        }

        return back()->withErrors([
            'email' => 'Podany email lub hasło są nieprawidłowe.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->intended('/home');
    }

}

