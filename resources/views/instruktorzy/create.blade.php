<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dodaj Instruktora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="{{ asset('css/form.css') }}" />
</head>
<body>
  <div class="container my-5">
    <h2 class="text-center mb-4">Dodaj Instruktora</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ url('instruktorzy/store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
            <label for="imie" class="form-label">Imię</label>
            <input type="text" name="imie" id="imie" class="form-control" value="{{ old('imie') }}" required>
          </div>

          <div class="mb-3">
            <label for="nazwisko" class="form-label">Nazwisko</label>
            <input type="text" name="nazwisko" id="nazwisko" class="form-control" value="{{ old('nazwisko') }}" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
          </div>

          <div class="mb-3">
            <label for="jezyk" class="form-label">Specjalizacja (język)</label>
            <select name="jezyk" id="jezyk" class="form-select" required>
              <option value="" disabled selected>Wybierz język</option>
              <option value="Angielski" {{ old('jezyk') == 'Angielski' ? 'selected' : '' }}>Angielski</option>
              <option value="Niemiecki" {{ old('jezyk') == 'Niemiecki' ? 'selected' : '' }}>Niemiecki</option>
              <option value="Hiszpański" {{ old('jezyk') == 'Hiszpański' ? 'selected' : '' }}>Hiszpański</option>
              <option value="Francuski" {{ old('jezyk') == 'Francuski' ? 'selected' : '' }}>Francuski</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="poziom" class="form-label">Poziom</label>
            <select name="poziom" id="poziom" class="form-select" required>
              <option value="" disabled selected>Wybierz poziom</option>
              <option value="Początkujący" {{ old('poziom') == 'Początkujący' ? 'selected' : '' }}>Początkujący</option>
              <option value="Średniozaawansowany" {{ old('poziom') == 'Średniozaawansowany' ? 'selected' : '' }}>Średniozaawansowany</option>
              <option value="Zaawansowany" {{ old('poziom') == 'Zaawansowany' ? 'selected' : '' }}>Zaawansowany</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="placa" class="form-label">Płaca (zł/h)</label>
            <input type="number" step="0.01" min="0" name="placa" id="placa" class="form-control" value="{{ old('placa') }}" required>
          </div>

          <div class="mb-3">
            <label for="zdjecie" class="form-label">Zdjęcie profilowe (opcjonalne)</label>
            <input type="file" name="zdjecie" id="zdjecie" class="form-control" accept="image/*">
          </div>

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary">Dodaj Instruktora</button>
            <a href="{{ url('instruktorzy') }}" class="btn btn-secondary">Anuluj</a>
        </div>
      </form>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
