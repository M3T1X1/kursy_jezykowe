<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Zniżki - Panel Administratora</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4 py-2">Szkoła Językowa</h4>
    <div class="d-flex flex-column">
      <a href="{{ url('dashboard') }}" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="{{ url('kursy') }}" class="nav-link"><i class="bi bi-book"></i> Kursy</a>
      <a href="{{ url('instruktorzy') }}" class="nav-link"><i class="bi bi-person-workspace"></i> Instruktorzy</a>
      <a href="{{ url('klienci') }}" class="nav-link"><i class="bi bi-people"></i> Klienci</a>
      <a href="{{ url('transakcje') }}" class="nav-link"><i class="bi bi-cash-coin"></i> Transakcje</a>
      <a href="{{ url('znizki') }}" class="nav-link active"><i class="bi bi-tag"></i> Zniżki</a>
      <a href="{{ url('/home') }}" class="nav-link mt-auto"><i class="bi bi-house"></i> Strona główna</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="nav-link btn btn-link" style="color: inherit; text-align: left;">
          <i class="bi bi-box-arrow-left"></i> Wyloguj
        </button>
      </form>
    </div>
  </div>

  <div class="main-content p-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="admin-title">Zniżki</h2>
    <a href="{{ route('znizki.create') }}" class="btn btn-primary">
      Dodaj zniżkę
    </a>
  </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive bg-white">
      <table class="table table-hover mb-0" id="znizkiTable">
        <thead>
          <tr>
            <th>Nazwa zniżki</th>
            <th>Wartość (%)</th>
            <th>Opis</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          @foreach($znizki as $znizka)
            <tr>
              <td>{{ $znizka->nazwa_znizki }}</td>
              <td>{{ $znizka->wartosc }}</td>
              <td>{{ $znizka->opis ?? '-' }}</td>
              <td>
                <a href="{{ route('znizki.edit', $znizka->id_znizki) }}" class="btn btn-sm btn-outline-primary btn-action" title="Edytuj">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('znizki.destroy', $znizka->id_znizki) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Czy na pewno chcesz usunąć tę zniżkę?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
