<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Nasza oferta kursów</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f8fafc;
    }
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
  </style>
</head>
<body>
  <div class="container py-5">
    <h2 class="mb-4 text-center">Nasza oferta kursów</h2>
    <div class="row g-4">
      @foreach ($courses as $course)
        <div class="col-md-4">
          <div class="card h-100">
            {{-- <img src="{{ $course->image_url ?? 'https://via.placeholder.com/400x200' }}" class="card-img-top" alt="{{ $course->jezyk }}"> --}}
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $course->jezyk }} - {{ $course->poziom }}</h5>
              <p class="card-text mb-4">
                Cena: <strong>{{ $course->cena }} PLN</strong><br>
                Start: <strong>{{ \Carbon\Carbon::parse($course->data_rozpoczecia)->format('Y-m-d') }}</strong>
              </p>
              <a href="{{ route('rezerwacja', ['course' => $course->jezyk . ' - ' . $course->poziom]) }}" class="btn btn-primary mt-auto">Zapisz się</a>
              <a href="{{ route('kursy.show', $course->id_kursu) }}" class="btn btn-outline-secondary w-100">Zobacz szczegóły</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
