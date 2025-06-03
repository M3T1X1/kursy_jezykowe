<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dodaj Instruktora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <style>
    body {
      background: #f4f6fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .sidebar {
      min-height: 100vh;
      background: #343a40;
      color: #fff;
      padding: 30px 0;
      position: fixed;
      width: 250px;
      top: 0;
      left: 0;
      z-index: 100;
      transition: all 0.3s;
    }
    .sidebar .nav-link {
      color: rgba(255, 255, 255, 0.8);
      padding: 12px 30px;
      display: flex;
      align-items: center;
      margin: 4px 16px;
      border-radius: 6px;
      transition: all 0.2s;
    }
    .sidebar .nav-link i {
      margin-right: 10px;
      font-size: 1.1rem;
    }
    .sidebar .nav-link.active, .sidebar .nav-link:hover {
      background: #495057;
      color: #fff;
    }
    .main-content {
      margin-left: 250px;
      padding: 40px 30px;
      transition: all 0.3s;
    }
    .admin-title {
      font-weight: 600;
      color: #2c3e50;
    }
    @media (max-width: 991px) {
      .main-content { margin-left: 0; }
      .sidebar { position: static; width: 100%; min-height: unset; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4 py-2">Szkoła Językowa</h4>
    <div class="d-flex flex-column">
      <a href="{{ url('dashboard') }}" class="nav-link">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ url('kursy') }}" class="nav-link">
        <i class="bi bi-book"></i> Kursy
      </a>
      <a href="{{ url('instruktorzy') }}" class="nav-link active">
        <i class="bi bi-person-workspace"></i> Instruktorzy
      </a>
      <a href="{{ url('klienci') }}" class="nav-link">
        <i class="bi bi-people"></i> Klienci
      </a>
      <a href="{{ url('transakcje') }}" class="nav-link">
        <i class="bi bi-cash-coin"></i> Transakcje
      </a>
      <a href="{{ url('znizki') }}" class="nav-link">
        <i class="bi bi-tag"></i> Zniżki
      </a>
      <a href="{{ url('/') }}" class="nav-link mt-auto" target="_blank">
        <i class="bi bi-house"></i> Strona główna
      </a>
      <a href="{{ url('logout') }}" class="nav-link">
        <i class="bi bi-box-arrow-left"></i> Wyloguj
      </a>
    </div>
  </div>

  <div class="main-content">
    <h2 class="admin-title mb-4">Dodaj Instruktora</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ url('instruktorzy/store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="imie" class="form-label">Imię</label>
        <input type="text" class="form-control" id="imie" name="imie" value="{{ old('imie') }}" required />
      </div>

      <div class="mb-3">
        <label for="nazwisko" class="form-label">Nazwisko</label>
        <input type="text" class="form-control" id="nazwisko" name="nazwisko" value="{{ old('nazwisko') }}" required />
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required />
      </div>

      <div class="mb-3">
        <label for="jezyk" class="form-label">Specjalizacja (język)</label>
        <select id="jezyk" name="jezyk" class="form-select" required>
          <option value="" disabled selected>Wybierz język</option>
          <option value="Angielski" {{ old('jezyk') == 'Angielski' ? 'selected' : '' }}>Angielski</option>
          <option value="Niemiecki" {{ old('jezyk') == 'Niemiecki' ? 'selected' : '' }}>Niemiecki</option>
          <option value="Hiszpański" {{ old('jezyk') == 'Hiszpański' ? 'selected' : '' }}>Hiszpański</option>
          <option value="Francuski" {{ old('jezyk') == 'Francuski' ? 'selected' : '' }}>Francuski</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="poziom" class="form-label">Poziom</label>
        <input type="text" class="form-control" id="poziom" name="poziom" value="{{ old('poziom') }}" required />
      </div>

      <div class="mb-3">
        <label for="placa" class="form-label">Płaca (zł/h)</label>
        <input type="number" step="0.01" min="0" class="form-control" id="placa" name="placa" value="{{ old('placa') }}" required />
      </div>

      <button type="submit" class="btn btn-primary float-end">Dodaj Instruktora</button>
      <a href="{{ url('instruktorzy') }}" class="btn btn-secondary">Anuluj</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
