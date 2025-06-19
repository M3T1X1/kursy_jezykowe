<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Szkoła Językowa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

  <section class="hero text-center mb-5">
    <div class="container">
      <h1 class="display-4">Rozpocznij naukę języków z nami!</h1>
      <p class="lead">Nowoczesne kursy, doświadczeni instruktorzy, elastyczne terminy.</p>
    </div>
  </section>

  @if (session('success'))
    <div class="alert-container">
        <div class="alert alert-success auto-hide" id="success-alert">
            <strong>Sukces!</strong> {{ session('success') }}
        </div>
    </div>
  @endif

  @if (session('error'))
    <div class="alert-container">
        <div class="alert alert-danger auto-hide" id="error-alert">
            <strong>Błąd!</strong> {{ session('error') }}
        </div>
    </div>
  @endif

  <div class="container mb-5">
    <h2 class="mb-4">Dostępne kursy</h2>
    <div class="row g-4">
        @foreach($kursy as $kurs)
            <div class="col-md-4">
                <div class="card course-card h-100 d-flex flex-column">
                    <img src="{{ $kurs->zdjecie_url }}" alt="{{ $kurs->jezyk }} - {{ $kurs->poziom }}" class="course-card img">
                    <div class="card-body d-flex flex-column">
                        <h5><a href="course-detail.html?id={{ $kurs->id_kursu }}" class="course-title">{{ $kurs->jezyk }} - {{ $kurs->poziom }}</a></h5>
                        <p class="card-text flex-grow-1">
                            @if($kurs->instructor)
                                Instruktor: <a href="instructor-detail.html?id={{ $kurs->instructor->id }}" class="instructor-name">{{ $kurs->instructor->imie }} {{ $kurs->instructor->nazwisko }}</a><br>
                            @else
                                Instruktor: Brak przypisanego<br>
                            @endif
                            Start: {{ $kurs->data_rozpoczecia->format('Y-m-d') }}<br>
                            Cena: {{ number_format($kurs->cena, 0, ',', ' ') }} PLN
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('rezerwacja.create', ['course' => $kurs->id_kursu]) }}" class="btn btn-primary w-100">Zapisz się na kurs</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center mb-5 mt-5">
        <a href="{{ route('oferta') }}" class="btn btn-custom">Zobacz wszystkie kursy</a>
    </div>
</div>
<

  <div class="container my-5">
    <h3 class="text-center mb-4">Poznaj naszych instruktorów</h3>

    @if($instruktorzy->count() > 0)
        <div class="py-3">
            <div class="d-flex flex-wrap justify-content-center gap-3">
                @foreach($instruktorzy as $instruktor)
                    <div style="width: 220px;">
                        <div class="card h-100 text-center">
                            <div style="padding-top: 15px;">
                                <img
                                    src="{{ $instruktor->zdjecie_url }}"
                                    alt="Zdjęcie instruktora {{ $instruktor->imie }} {{ $instruktor->nazwisko }}"
                                    class="rounded-circle mx-auto"
                                    style="width: 120px; height: 120px; object-fit: cover;"
                                >
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $instruktor->imie }} {{ $instruktor->nazwisko }}</h5>
                                <p class="card-text mb-1"><strong>Język:</strong> {{ $instruktor->jezyk }}</p>
                                <p class="card-text"><strong>Poziom:</strong> {{ $instruktor->poziom }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center">Brak dostępnych instruktorów.</p>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
