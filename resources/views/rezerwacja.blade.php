<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <title>Rezerwacja kursu - Szkoła Językowa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">

</head>
<body>
  <div class="form-container">
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

    @include('rezerwacja-form')
  </div>
</body>
</html>
