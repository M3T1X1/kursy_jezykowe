<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nasza oferta kursów</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/oferta.css') }}">

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
