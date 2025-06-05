<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <title>Rezerwacja kursu - Szkoła Językowa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body { background: #f8fafc; }
    .booking-box { max-width: 520px; margin: 50px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.07); padding: 40px; }
    .booking-title { font-weight: bold; }
    .logo { display: block; margin: 0 auto 20px auto; width: 80px; }
  </style>
</head>
<body>
  <div class="booking-box">
    <img src="https://img.icons8.com/color/96/000000/language.png" class="logo" alt="Logo szkoły" />
    <h2 class="booking-title mb-4 text-center">Rezerwacja kursu językowego</h2>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('rezerwacja.submit') }}">
      @csrf

      <h5 class="mb-3">Dane uczestnika</h5>
      <div class="mb-3">
        <label for="imie" class="form-label">Imię:</label>
        <input type="text" class="form-control" id="imie" name="imie" required value="{{ old('imie') }}">
      </div>
      <div class="mb-3">
        <label for="nazwisko" class="form-label">Nazwisko:</label>
        <input type="text" class="form-control" id="nazwisko" name="nazwisko" required value="{{ old('nazwisko') }}">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
      </div>
      <div class="mb-3">
        <label for="nr_telefonu" class="form-label">Telefon:</label>
        <input type="tel" class="form-control" id="nr_telefonu" name="nr_telefonu" required value="{{ old('nr_telefonu') }}">
      </div>

      <h5 class="mb-3 mt-4">Szczegóły kursu</h5>

      @php
        // $selectedCourse jest przekazywany z kontrolera
      @endphp

      @if($selectedCourse)
        <div class="mb-3">
          <label class="form-label">Język:</label>
          <p>{{ $selectedCourse->jezyk }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label">Poziom zaawansowania:</label>
          <p>{{ $selectedCourse->poziom }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label">Data rozpoczęcia kursu:</label>
          <p>{{ \Illuminate\Support\Carbon::parse($selectedCourse->data_rozpoczecia)->format('Y-m-d') }}</p>
        </div>
        <div class="mb-3">
          <label class="form-label">Cena bazowa:</label>
          <p>{{ number_format($selectedCourse->cena, 2, ',', ' ') }} zł</p>
        </div>
        <input type="hidden" name="course" value="{{ $selectedCourse->id_kursu }}">
        <input type="hidden" name="base_price" value="{{ $selectedCourse->cena }}">
      @else
        <div class="alert alert-warning">Brak dostępnych kursów do rezerwacji.</div>
      @endif

      <button type="submit" class="btn btn-success w-100 mt-4">Zarezerwuj miejsce</button>
    </form>
  </div>
</body>
</html>
