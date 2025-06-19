<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>{{ $course->title }} - Szkoła Językowa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/course-details.css') }}">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Szkoła Językowa</a>
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

  <div class="course-header">
    <div class="container text-center">
      <h1 class="display-5 mb-3">{{ $course->jezyk }} - {{ $course->poziom }}</h1>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="d-flex justify-content-between mb-2">
            <span><strong>Start:</strong> {{ \Carbon\Carbon::parse($course->data_rozpoczecia)->format('Y-m-d') }}</span>
            <span><strong>Koniec:</strong> {{ \Carbon\Carbon::parse($course->data_zakonczenia)->format('Y-m-d') }}</span>
            <span><strong>Poziom:</strong> {{ $course->poziom }}</span>
          </div>
          <div class="d-flex justify-content-center gap-3 mt-3">
            <a href="{{ url('rezerwacja?course=' . urlencode($course->jezyk . ' - ' . $course->poziom)) }}" class="btn btn-light btn-lg">
              Zapisz się na kurs
            </a>
            <a href="{{ route('oferta') }}" class="btn btn-outline-primary btn-lg">
              <i class="bi bi-arrow-left"></i> Wróć do oferty
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container mb-5">
    <div class="row">
      <div class="col-md-8">
        <h2 class="mb-4">O kursie</h2>
        <p>Ten kurs języka {{ $course->jezyk }} na poziomie {{ $course->poziom }} został przygotowany z myślą o Tobie.</p>
        <h4 class="mt-5 mb-3">Dla kogo jest ten kurs?</h4>
        <ul>
          <li>Dla osób rozpoczynających naukę języka {{ $course->jezyk }}</li>
          <li>Dla osób, które miały kontakt z językiem, ale chcą usystematyzować swoją wiedzę</li>
          <li>Dla osób, które potrzebują podstaw języka do pracy lub podróży</li>
        </ul>
      </div>

      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">
            Szczegóły kursu
          </div>
          <div class="card-body">
            <p><strong>Cena:</strong> {{ $course->cena }} PLN</p>
            <p><strong>Język:</strong> {{ $course->jezyk }}</p>
            <p><strong>Liczba miejsc:</strong> {{ $course->liczba_miejsc }}</p>
            <p><strong>Liczba zajęć:</strong> 24 (2 razy w tygodniu)</p>
            <p><strong>Czas trwania zajęć:</strong> 90 minut</p>
            <a href="{{ url('rezerwacja?course=' . urlencode($course->jezyk . ' - ' . $course->poziom)) }}" class="btn btn-primary w-100">Zapisz się na kurs</a>
          </div>
        </div>

        <div class="instructor-card p-4 mt-4">
  <h5 class="mb-3">Instruktor kursu</h5>
  <div class="d-flex align-items-center mb-3">
    <img src="{{ $course->instructor->zdjecie ?? 'https://via.placeholder.com/100' }}" alt="Zdjęcie instruktora" class="instructor-img me-3">
    <div>
      <h6 class="mb-1">{{ $course->instructor->imie }} {{ $course->instructor->nazwisko }}</h6>
    </div>
  </div>
</div>

      </div>
    </div>
  </div>

  <footer class="text-center mt-5 py-4 bg-light">
    <div>
      <p>Kontakt: kontakt@szkolajezykowa.pl | tel. 123 456 789</p>
      <a href="#"><img src="https://img.icons8.com/color/48/000000/facebook.png" width="32"/></a>
      <a href="#"><img src="https://img.icons8.com/color/48/000000/instagram-new.png" width="32"/></a>
      <a href="#"><img src="https://img.icons8.com/color/48/000000/youtube-play.png" width="32"/></a>
    </div>
    &copy; 2025 Szkoła Językowa
  </footer>
</body>
</html>
