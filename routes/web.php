<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransakcjeController;
use App\Http\Controllers\ZnizkaController;
use App\Http\Controllers\KlientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\RejestracjaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\InstruktorzyController;
use App\Http\Controllers\ReservationController;


// Test połączenia z bazą
Route::get('/test-db', function () {
    return DB::select('SELECT * FROM instruktorzy LIMIT 1');
});

// Strona główna
Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
});


//rezerwacja
Route::get('/rezerwacja', [ReservationController::class, 'create'])->name('rezerwacja.create');
Route::post('/rezerwacja', [ReservationController::class, 'store'])->name('rezerwacja.submit');



// Instruktorzy (publiczny widok)

Route::get('instruktorzy', [InstruktorzyController::class, 'index']);
Route::get('instruktorzy/create', [InstruktorzyController::class, 'create']);
Route::post('instruktorzy/store', [InstruktorzyController::class, 'store']);
Route::get('instruktorzy/edit/{id}', [InstruktorzyController::class, 'edit']);
Route::put('instruktorzy/update/{id}', [InstruktorzyController::class, 'update']);
Route::delete('instruktorzy/delete/{id}', [InstruktorzyController::class, 'destroy']);

// Login
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rejestracja
Route::get('/register', [RejestracjaController::class, 'showForm'])->name('register.form');
Route::post('/register', [RejestracjaController::class, 'register'])->name('register');

// Widok aplikacji (np. layout SPA)
Route::get('/app', function () {
    return view('app');
});

// Panel admina
    Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    //Route::get('/dashboard', function () {
    //    return view('dashboard');
    //});

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Klienci
    Route::get('/klienci', [KlientController::class, 'index'])->name('klienci.index');
    Route::resource('klienci', KlientController::class);
    Route::delete('/klienci/{id}', [KlientController::class, 'destroy'])->name('klienci.destroy');
    Route::get('/klienci/{id_klienta}/edit', [KlientController::class, 'edit'])->name('klienci.edit');
    Route::put('/klienci/{id_klienta}', [KlientController::class, 'update'])->name('klienci.update');

    // Kursy

    Route::resource('kursy', CourseController::class);
// Oferta kursów
Route::get('/oferta', [PublicCourseController::class, 'index'])->name('oferta');


    // Transakcje i zniżki
    Route::get('/admin/transakcje', [AdminController::class, 'showTransactions'])->name('admin.transakcje');
    Route::get('/transakcje', [TransakcjeController::class, 'index'])->name('transakcje');
    Route::resource('znizki', ZnizkaController::class);
});
