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
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">Szkoła Językowa</a>
        @if(auth()->check())
        <span class="navbar-text ms-3">
            Zalogowany jako: <strong>{{ auth()->user()->imie }} {{ auth()->user()->nazwisko }}</strong>
        </span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline; margin-left: 15px;">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Wyloguj się</button>
        </form>
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
          <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Angielski">
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
          <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Hiszpański">
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
          <img src="https://images.unsplash.com/photo-1498855926480-d98e83099315?auto=format&fit=crop&w=400&q=80" class="card-img-top" alt="Francuski">
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
  </div>
  <div class="text-center mb-5">
  <a href="{{ route('oferta') }}" class="btn btn-primary">Zobacz wszystkie kursy</a>
  </div>
  <div class="container mb-5">
    <h2 class="mb-4">Nasi instruktorzy</h2>
    <div class="row text-center">
      <div class="col-md-3 instructor-card mb-4">
        <a href="instructor-detail.html?id=1">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Jan Kowalski" class="mb-3">
          <h5 class="instructor-name">Jan Kowalski</h5>
        </a>
        <p>Angielski</p>
        <a href="instructor-detail.html?id=1" class="btn btn-sm btn-outline-primary">Profil instruktora</a>
      </div>
      <div class="col-md-3 instructor-card mb-4">
        <a href="instructor-detail.html?id=2">
          <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Maria Nowak" class="mb-3">
          <h5 class="instructor-name">Maria Nowak</h5>
        </a>
        <p>Hiszpański</p>
        <a href="instructor-detail.html?id=2" class="btn btn-sm btn-outline-primary">Profil instruktora</a>
      </div>
      <div class="col-md-3 instructor-card mb-4">
        <a href="instructor-detail.html?id=3">
          <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Piotr Wiśniewski" class="mb-3">
          <h5 class="instructor-name">Piotr Wiśniewski</h5>
        </a>
        <p>Francuski</p>
        <a href="instructor-detail.html?id=3" class="btn btn-sm btn-outline-primary">Profil instruktora</a>
      </div>
      <div class="col-md-3 instructor-card mb-4">
        <a href="instructor-detail.html?id=4">
          <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Anna Kowalczyk" class="mb-3">
          <h5 class="instructor-name">Anna Kowalczyk</h5>
        </a>
        <p>Niemiecki</p>
        <a href="instructor-detail.html?id=4" class="btn btn-sm btn-outline-primary">Profil instruktora</a>
      </div>
    </div>
  </div>
  <div class="container mb-5">
    <h2 class="mb-4">Opinie kursantów</h2>
    <div class="row">
