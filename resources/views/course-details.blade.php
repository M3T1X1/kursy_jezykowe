<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>{{ $course->jezyk }} - {{ $course->poziom }} - Szkoła Językowa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/course-details.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Szkoła Językowa</a>
        @if(auth()->check())
            <span class="navbar-text ms-3 me-3">
                Zalogowany jako: <strong>{{ auth()->user()->imie }} {{ auth()->user()->nazwisko }}</strong>
            </span>

            <div class="d-inline-flex align-items-center" style="gap: 10px;">
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.index') }}" class="btn btn-outline-primary btn-sm">
                    Dashboard
                </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Wyloguj się</button>
                </form>
            </div>
            @else
            <div class="btn-group btn-group-auth">
                <a href="{{ route('login') }}" class="btn btn-primary">Zaloguj się</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Zarejestruj się</a>
            </div>
            @endif
    </div>
</nav>

<!-- Hero section z zdjęciem kursu -->
<div class="course-header" style="position: relative; background: linear-gradient(135deg, #007bff, #0056b3); min-height: 250px;">
    @if($course->zdjecie)
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('{{ asset('storage/' . $course->zdjecie) }}'); background-size: contain; background-repeat: no-repeat; background-position: center; opacity: 0.6;"></div>
    @endif
    <div class="container text-center py-5" style="position: relative; z-index: 2; color: white;">
        <h1 class="display-5 mb-3">{{ $course->jezyk }} - {{ $course->poziom }}</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-center flex-wrap gap-4 mb-3">
                    <span><strong>Start:</strong> {{ $course->data_rozpoczecia->format('d.m.Y') }}</span>
                    <span><strong>Koniec:</strong> {{ $course->data_zakonczenia->format('d.m.Y') }}</span>
                    <span><strong>Cena:</strong> {{ number_format($course->cena, 0, ',', ' ') }} PLN</span>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="{{ route('rezerwacja.create', ['course' => $course->id_kursu]) }}" class="btn btn-light btn-lg">
                        Zapisz się na kurs
                    </a>
                    <a href="{{ route('oferta') }}" class="btn btn-outline-light btn-lg">
                        Wróć do oferty
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">O kursie</h2>
            <p class="lead">Ten kurs języka {{ $course->jezyk }} na poziomie {{ strtolower($course->poziom) }} został przygotowany z myślą o skutecznej nauce w przyjaznej atmosferze.</p>

            <h4 class="mt-5 mb-3">Dla kogo jest ten kurs?</h4>
            <ul>
                @if(strtolower($course->poziom) === 'początkujący')
                    <li>Dla osób rozpoczynających naukę języka {{ $course->jezyk }}</li>
                    <li>Dla osób bez wcześniejszego doświadczenia z tym językiem</li>
                    <li>Dla osób, które potrzebują podstaw do pracy lub podróży</li>
                @elseif(strtolower($course->poziom) === 'średniozaawansowany')
                    <li>Dla osób znających podstawy języka {{ $course->jezyk }}</li>
                    <li>Dla osób, które chcą rozwinąć swoje umiejętności komunikacyjne</li>
                    <li>Dla osób potrzebujących języka do celów zawodowych</li>
                @else
                    <li>Dla osób z dobrą znajomością języka {{ $course->jezyk }}</li>
                    <li>Dla osób chcących doskonalić płynność wypowiedzi</li>
                    <li>Dla osób przygotowujących się do egzaminów certyfikatowych</li>
                @endif
            </ul>

            <h4 class="mt-5 mb-3">Co zyskasz?</h4>
            <ul>
                <li>Pewność w komunikacji</li>
                <li>Praktyczne umiejętności</li>
                <li>Certyfikat ukończenia</li>
                <li>Materiały do nauki</li>
                <li>Małe grupy (max {{ $course->liczba_miejsc }} osób)</li>
                <li>Elastyczne podejście</li>
            </ul>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Szczegóły kursu</h5>
                </div>
                <div class="card-body">
                    <p><strong>Cena:</strong> <span class="fs-5 text-primary fw-bold">{{ number_format($course->cena, 0, ',', ' ') }} PLN</span></p>
                    <p><strong>Język:</strong> {{ $course->jezyk }}</p>
                    <p><strong>Poziom:</strong> {{ $course->poziom }}</p>
                    <p><strong>Liczba miejsc:</strong> {{ $course->liczba_miejsc }}</p>
                    <a href="{{ route('rezerwacja.create', ['course' => $course->id_kursu]) }}" class="btn btn-primary w-100">
                        Zapisz się na kurs
                    </a>
                </div>
            </div>

            @if($course->instructor)
            <div class="mt-4" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background: white; padding: 12px; min-height: auto !important; height: auto !important;">
                <div class="d-flex align-items-center">
                    <img
                        src="{{ $course->instructor->zdjecie_url ?? asset('img/ZdjeciaInstruktorow/brak.png') }}"
                        alt="Instruktor"
                        class="rounded-circle me-2"
                        style="width: 35px; height: 35px; object-fit: cover;"
                    >
                    <span style="font-weight: 500;">Instruktor - {{ $course->instructor->imie }} {{ $course->instructor->nazwisko }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<footer class="text-center mt-5 py-4 bg-light">
    <div class="container">
        <p class="mb-3">Kontakt: kontakt@szkolajezykowa.pl | tel. 123 456 789</p>
        <div class="mb-3">
            <a href="#" class="me-3"><img src="https://img.icons8.com/color/48/000000/facebook.png" width="32" alt="Facebook"/></a>
            <a href="#" class="me-3"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" width="32" alt="Instagram"/></a>
            <a href="#"><img src="https://img.icons8.com/color/48/000000/youtube-play.png" width="32" alt="YouTube"/></a>
        </div>
        <p class="mb-0">&copy; 2025 Szkoła Językowa</p>
    </div>
</footer>
</body>
</html>
