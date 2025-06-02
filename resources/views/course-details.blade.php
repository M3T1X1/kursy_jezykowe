{{-- resources/views/course-detail.blade.php --}}
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>{{ $course->title }} - Szkoła Językowa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body { background: #f8fafc; }
    .course-header { background: linear-gradient(90deg, #4f8cff 0%, #38b6ff 100%); color: #fff; padding: 60px 0; border-radius: 0 0 30px 30px; margin-bottom: 30px; }
    .feature-card { border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px; height: 100%; background: white; }
    .feature-card i { font-size: 36px; margin-bottom: 15px; color: #3498db; }
    .instructor-card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; }
    .instructor-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; }
    .timeline-item { position: relative; padding-left: 30px; margin-bottom: 20px; }
    .timeline-item:before { content: ""; position: absolute; left: 0; top: 0; width: 12px; height: 12px; border-radius: 50%; background: #3498db; }
    .timeline-item:after { content: ""; position: absolute; left: 5px; top: 12px; height: calc(100% + 8px); width: 2px; background: #3498db; }
    .timeline-item:last-child:after { display: none; }
    .btn-group-auth { gap: 10px; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">Szkoła Językowa</a>
      <div class="btn-group btn-group-auth">
        <a class="btn btn-outline-primary" href="{{ route('login') }}">Zaloguj się</a>
        <a class="btn btn-success" href="{{ route('register') }}">Zarejestruj się</a>
      </div>
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
          <a href="{{ url('rezerwacja?course=' . urlencode($course->jezyk . ' - ' . $course->poziom)) }}" class="btn btn-light btn-lg mt-3">Zapisz się na kurs</a>
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
            <img src="{{ $course->instructor->zdjecie ?? 'https://via.placeholder.com/100' }}" alt="{{ $course->instructor->imie }} {{ $course->instructor->nazwisko }}" class="instructor-img me-3">
            <div>
              <h6 class="mb-1">{{ $course->instructor->imie }} {{ $course->instructor->nazwisko }}</h6>
              <p class="mb-0 text-muted">Język: {{ $course->instructor->jezyk_specjalizacja }}</p>
            </div>
          </div>
          <a href="{{ url('instructor-detail?id=' . $course->instructor->id) }}" class="btn btn-outline-primary btn-sm w-100">Profil instruktora</a>
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