<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Klienci - Panel Administratora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <script src="{{ asset('script.js') }}"></script>

</head>
<body>
  <div class="sidebar">
    <h4 class="text-center mb-4">Szkoła Językowa</h4>
    <div class="d-flex flex-column">
      <a href="{{ url('dashboard') }}" class="nav-link">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ url('kursy') }}" class="nav-link">
        <i class="bi bi-book"></i> Kursy
      </a>
      <a href="{{ url('instruktorzy') }}" class="nav-link">
        <i class="bi bi-person-workspace"></i> Instruktorzy
      </a>
      <a href="{{ url('klienci') }}" class="nav-link active">
        <i class="bi bi-people"></i> Klienci
      </a>
      <a href="{{ url('transakcje') }}" class="nav-link">
        <i class="bi bi-cash-coin"></i> Transakcje
      </a>
      <a href="{{ url('znizki') }}" class="nav-link">
        <i class="bi bi-tag"></i> Zniżki
      </a>
      <a href="{{ url('/home') }}" class="nav-link mt-auto">
        <i class="bi bi-house"></i> Strona główna
      </a>
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-link btn btn-link" style="color: inherit; text-align: left;">
              <i class="bi bi-box-arrow-left"></i> Wyloguj
          </button>
      </form>
    </div>
  </div>
 <div class="main-content">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="admin-title">Lista klientów</h2>
        <a href="{{ route('register.form', ['admin' => 1]) }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Dodaj klienta
        </a>
    </div>
    <!-- FILTRY -->
    <div class="row mb-3 filter-row">
      <div class="col-md-2">
        <input type="text" class="form-control filter-klienci" placeholder="Imię" data-column="0" />
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control filter-klienci" placeholder="Nazwisko" data-column="1" />
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control filter-klienci" placeholder="Email" data-column="2" />
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control filter-klienci" placeholder="Adres" data-column="3" />
      </div>
      <div class="col-md-3">
        <input type="text" class="form-control filter-klienci" placeholder="Telefon" data-column="4" />
      </div>
    </div>
    <!-- TABELA -->
    <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
        <tr>
            <th>Zdjęcie</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Email</th>
            <th>Adres</th>
            <th>Telefon</th>
            <th>Akcje</th>
        </tr>
        </thead>
        <tbody>
        @foreach($klienci as $klient)
            <tr>
            <td>
                @if($klient->adres_zdjecia)
                <img src="{{ asset('storage/' . $klient->adres_zdjecia) }}" alt="Zdjęcie klienta" style="width:48px; height:48px; object-fit:cover; border-radius:50%;">
                @else
                <span class="text-muted">Brak</span>
                @endif
            </td>
            <td>{{ $klient->imie }}</td>
            <td>{{ $klient->nazwisko }}</td>
            <td>{{ $klient->email }}</td>
            <td>{{ $klient->adres }}</td>
            <td>{{ $klient->nr_telefonu }}</td>
            <td>
                <a href="{{ route('klienci.edit', $klient->id_klienta) }}" class="btn btn-sm btn-outline-primary btn-action" title="Edytuj">
                <i class="bi bi-pencil"></i>
                </a>
                @if($klient->id_klienta != Auth::id())
                <form action="{{ route('klienci.destroy', $klient->id_klienta) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger btn-action" title="Usuń" onclick="return confirm('Czy na pewno chcesz usunąć tego klienta?')">
                    <i class="bi bi-trash"></i>
                </button>
                </form>
                @endif
            </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filters = document.querySelectorAll('.filter-klienci');
        const table = document.querySelector('.table');
        const rows = table.querySelectorAll('tbody tr');

        filters.forEach((input, colIndex) => {
            input.addEventListener('input', function() {
                rows.forEach(row => {
                    let show = true;
                    filters.forEach((f, i) => {
                        const cell = row.children[i+1]; // +1 bo pierwsza kolumna to zdjęcie
                        if (f.value && cell && !cell.textContent.toLowerCase().includes(f.value.toLowerCase())) {
                            show = false;
                        }
                    });
                    row.style.display = show ? '' : 'none';
                });
            });
        });
    });
</script>

</body>
</html>
