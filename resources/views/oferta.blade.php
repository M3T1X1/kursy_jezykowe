<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nasza oferta kursów</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <style>
    .card {
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      border-radius: 10px;
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card-title {
      font-weight: 600;
      color: #2c3e50;
    }
    .btn-primary {
      background: #4f8cff;
      border: none;
    }
    .btn-primary:hover {
      background: #3b6ecc;
    }
    .btn-outline-secondary {
      margin-top: 10px;
    }
    .btn-back {
      background: linear-gradient(90deg, #4f8cff 0%, #38b6ff 100%);
      color: #fff;
      padding: 12px 30px;
      font-size: 1.1rem;
      border-radius: 50px;
      font-weight: 600;
      border: none;
      box-shadow: 0 4px 12px rgba(56, 182, 255, 0.4);
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }
    .btn-back:hover {
      background: linear-gradient(90deg, #38b6ff 0%, #4f8cff 100%);
      color: #fff;
      transform: translateY(-2px);
    }
    /* Równa wysokość kart */
.row.g-4 {
  display: flex;
  flex-wrap: wrap;
}

.col-md-4 {
  display: flex;
  margin-bottom: 1.5rem;
}

.card {
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  border-radius: 10px;
  transition: transform 0.3s;
  width: 100%;
  display: flex;
  flex-direction: column;
}

.card:hover {
  transform: translateY(-5px);
}

.card-body {
  display: flex;
  flex-direction: column;
  flex: 1;
  padding: 1.5rem;
}

.card-text {
  flex-grow: 1;
  margin-bottom: 1rem;
}

.btn {
  margin-top: auto;
}

.btn-outline-secondary {
  margin-top: 10px;
}

.row {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  margin: 0;
}

.course-col {
  flex: 0 0 calc(33.333% - 1rem);
  max-width: calc(33.333% - 1rem);
  display: flex;
}

@media (max-width: 768px) {
  .course-col {
    flex: 0 0 100%;
    max-width: 100%;
  }
}

@media (min-width: 769px) and (max-width: 1199px) {
  .col-md-4 {
    flex: 0 0 33.333333% !important;
    max-width: 33.333333% !important;
  }
}

@media (min-width: 1200px) {
  .col-md-4 {
    flex: 0 0 33.333333% !important;
    max-width: 33.333333% !important;
  }
}

  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="mb-4 text-center">Nasza oferta kursów</h2>
    
    <!-- Przycisk powrotu -->
    <div class="text-center mb-4">
      <a href="{{ route('home') }}" class="btn-back">
        ← Wróć do strony głównej
      </a>
    </div>
    
    <div class="row">
      @foreach ($courses as $course)
        <div class="course-col">
          <div class="card h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $course->jezyk }} - {{ $course->poziom }}</h5>
              <p class="card-text mb-4">
                Cena: <strong>{{ $course->cena }} PLN</strong><br>
                Start: <strong>{{ \Carbon\Carbon::parse($course->data_rozpoczecia)->format('Y-m-d') }}</strong>
              </p>
              <a href="{{ route('rezerwacja.create', ['course' => $course->id_kursu]) }}" class="btn btn-primary mt-auto">Zapisz się</a>
              <a href="{{ route('kurs.show', $course->id_kursu) }}" class="btn btn-outline-secondary w-100">Zobacz szczegóły</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
