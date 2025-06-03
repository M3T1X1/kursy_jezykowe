<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edytuj Instruktora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="background: #f4f6fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px 30px;">

  <div class="container bg-white p-4 rounded shadow-sm" style="max-width: 700px; margin: auto;">
    <h2 class="mb-4">Edytuj Instruktora</h2>

    <form action="{{ url('instruktorzy/update/' . $instruktor->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="imie" class="form-label">Imię</label>
        <input type="text" name="imie" id="imie" class="form-control" value="{{ old('imie', $instruktor->imie) }}" required>
      </div>

      <div class="mb-3">
        <label for="nazwisko" class="form-label">Nazwisko</label>
        <input type="text" name="nazwisko" id="nazwisko" class="form-control" value="{{ old('nazwisko', $instruktor->nazwisko) }}" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $instruktor->email) }}" required>
      </div>

      <div class="mb-3">
        <label for="jezyk" class="form-label">Specjalizacja</label>
        <select name="jezyk" id="jezyk" class="form-select" required>
          <option value="">Wybierz język</option>
          <option value="Angielski" {{ old('jezyk', $instruktor->jezyk) == 'Angielski' ? 'selected' : '' }}>Angielski</option>
          <option value="Niemiecki" {{ old('jezyk', $instruktor->jezyk) == 'Niemiecki' ? 'selected' : '' }}>Niemiecki</option>
          <option value="Hiszpański" {{ old('jezyk', $instruktor->jezyk) == 'Hiszpański' ? 'selected' : '' }}>Hiszpański</option>
          <!-- Dodaj więcej jeśli potrzeba -->
        </select>
      </div>

    @php
    $currentLevel = old('poziom', $instruktor->poziom);
    @endphp

    <div class="mb-3">
    <label for="poziom" class="form-label">Poziom</label>
    <select name="poziom" id="poziom" class="form-select" required>
        <option value="" disabled {{ $currentLevel ? '' : 'selected' }}>Wybierz poziom</option>
        <option value="Początkujący" {{ $currentLevel == 'Początkujący' ? 'selected' : '' }}>Początkujący</option>
        <option value="Średniozaawansowany" {{ $currentLevel == 'Średniozaawansowany' ? 'selected' : '' }}>Średniozaawansowany</option>
        <option value="Zaawansowany" {{ $currentLevel == 'Zaawansowany' ? 'selected' : '' }}>Zaawansowany</option>
        <option value="Ekspert" {{ $currentLevel == 'Ekspert' ? 'selected' : '' }}>Ekspert</option>
    </select>
    </div>


      <div class="mb-3">
        <label for="placa" class="form-label">Płaca (zł/h)</label>
        <input type="number" step="0.01" name="placa" id="placa" class="form-control" value="{{ old('placa', $instruktor->placa) }}" required>
      </div>

      <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
      <a href="{{ url('instruktorzy') }}" class="btn btn-secondary ms-2">Anuluj</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
