<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Szkoła Językowa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8fafc; }
    .course-card img { border-radius: 8px 8px 0 0; }
    .course-card { box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-radius: 8px; transition: transform 0.3s; }
    .course-card:hover { transform: translateY(-5px); }
    .hero { background: linear-gradient(90deg, #4f8cff 0%, #38b6ff 100%); color: #fff; padding: 60px 0; border-radius: 0 0 30px 30px; }
    .instructors img { border-radius: 50%; width: 120px; height: 120px; object-fit: cover; transition: transform 0.3s; }
    .instructor-card:hover img { transform: scale(1.05); }
    .testimonial { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 20px; margin: 10px 0; }
    .btn-group-auth { gap: 10px; }
    .instructor-name { color: #2c3e50; text-decoration: none; font-weight: 600; }
    .course-title { color: #2c3e50; text-decoration: none; font-weight: 600; }
    .instructor-name:hover, .course-title:hover { color: #3498db; }
    .instruktorzy-scroll::-webkit-scrollbar {
        height: 8px;
    }

  </style>
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

  <div class="container mb-5">
    <h2 class="mb-4">Dostępne kursy</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card course-card">
          <img src="{{ asset('img/UKFlag.png') }}" alt="UK Flag" style="width: 414px; height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5><a href="course-detail.html?id=1" class="course-title">Angielski - podstawowy</a></h5>
            <p class="card-text">
              Instruktor: <a href="instructor-detail.html?id=1" class="instructor-name">Jan Kowalski</a><br>
              Start: 2025-06-01<br>
              Cena: 1200 PLN
            </p>
            <a href="{{ route('rezerwacja.create', ['course' => 1]) }}" class="btn btn-primary">Zapisz się na kurs</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card course-card">
          <img src="{{ asset('img/SpainFlag.png') }}" alt="SpainFlag" style="width: 414px; height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5><a href="course-detail.html?id=2" class="course-title">Hiszpański - średniozaawansowany</a></h5>
            <p class="card-text">
              Instruktor: <a href="instructor-detail.html?id=2" class="instructor-name">Maria Nowak</a><br>
              Start: 2025-06-15<br>
              Cena: 1350 PLN
            </p>
            <a href="{{ route('rezerwacja.create', ['course' => 2]) }}" class="btn btn-primary">Zapisz się na kurs</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card course-card">
          <img src="{{ asset('img/FranceFlag.webp') }}" alt="FrenchFlag" style="width: 414px; height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5><a href="course-detail.html?id=3" class="course-title">Francuski - początkujący</a></h5>
            <p class="card-text">
              Instruktor: <a href="instructor-detail.html?id=3" class="instructor-name">Piotr Wiśniewski</a><br>
              Start: 2025-07-01<br>
              Cena: 1100 PLN
            </p>
            <a href="{{ route('rezerwacja.create', ['course' => 3]) }}" class="btn btn-primary">Zapisz się na kurs</a>
          </div>
        </div>
      </div>
    </div>
        <div class="text-center mb-5 mt-5">
            <a href="{{ route ('oferta') }}" class ="btn btn-primary"> Zobacz wszystkie kursy</a>
        </div>
  </div>
  <div class="container my-5">
    <h3 class="text-center mb-4">Poznaj naszych instruktorów</h3>

    @if($instruktorzy->count() > 0)
        <div class="py-3">
            <h4 class="text-center mb-4"></h4>

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



