<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Instruktorzy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    /* Wyśrodkowanie tekstu w komórkach tabeli */
    #instruktorzyTable td {
      vertical-align: middle;
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
      <a href="{{ url('/') }}" class="nav-link mt-auto">
        <i class="bi bi-house"></i> Strona główna
      </a>
      <a href="{{ url('logout') }}" class="nav-link">
        <i class="bi bi-box-arrow-left"></i> Wyloguj
      </a>
    </div>
  </div>

  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="admin-title">Instruktorzy</h2>
      <a href="{{ url('instruktorzy/create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Dodaj Instruktora
      </a>
    </div>

    <!-- Filtry -->
    <div class="row mb-4 filters">
      <div class="col-md-2">
        <input type="text" class="form-control filter-instruktorzy" placeholder="Imię" data-column="1" />
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control filter-instruktorzy" placeholder="Nazwisko" data-column="2" />
      </div>
      <div class="col-md-2">
        <input type="text" class="form-control filter-instruktorzy" placeholder="Email" data-column="3" />
      </div>
      <div class="col-md-2">
        <select class="form-select filter-instruktorzy" data-column="4">
          <option value="">Specjalizacja</option>
          <option>Angielski</option>
          <option>Niemiecki</option>
          <option>Hiszpański</option>
          <option>Francuski</option>
        </select>
      </div>
      <div class="col-md-2">
        <select class="form-select filter-instruktorzy" data-column="5">
          <option value="">Poziom</option>
          <option>Początkujący</option>
          <option>Średniozaawansowany</option>
          <option>Zaawansowany</option>
        </select>
      </div>
    </div>

    <!-- Tabela instruktorów -->
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
      <table class="table table-hover mb-0" id="instruktorzyTable">
        <thead>
          <tr>
            <th>Zdjęcie</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Email</th>
            <th>Specjalizacja</th>
            <th>Poziom</th>
            <th>Płaca</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($instruktorzy as $instruktor)
            <tr>
              <td style="text-align: center;">
                @if($instruktor->adres_zdjecia && file_exists(public_path($instruktor->adres_zdjecia)))
                  <img src="{{ asset($instruktor->adres_zdjecia) }}" alt="Zdjęcie instruktora" style="width:50px; height:50px; border-radius:50%; object-fit: cover;">
                @else
                  <img src="{{ asset('img/ZdjeciaInstruktorow/brak.png') }}" alt="Brak zdjęcia" style="width:50px; height:50px; border-radius:50%; object-fit: cover;">
                @endif
              </td>
              <td>{{ $instruktor->imie }}</td>
              <td>{{ $instruktor->nazwisko }}</td>
              <td>{{ $instruktor->email }}</td>
              <td>{{ $instruktor->jezyk }}</td>
              <td>{{ $instruktor->poziom }}</td>
              <td>{{ $instruktor->placa }} zł/h</td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ url('instruktorzy/edit/' . $instruktor->id) }}" class="btn btn-sm btn-outline-primary btn-action" title="Edytuj">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="{{ url('instruktorzy/delete/' . $instruktor->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Czy na pewno chcesz usunąć tego instruktora?')" title="Usuń">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      @if($instruktorzy->hasPages())
        <div class="mt-3">
          {{ $instruktorzy->links('pagination::simple-bootstrap-5') }}
          <div class="mt-2 text-muted">
            Strona {{ $instruktorzy->currentPage() }} z {{ $instruktorzy->lastPage() }}
          </div>
        </div>
      @endif
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Filter Script -->
  <script>
    document.querySelectorAll('.filter-instruktorzy').forEach(input => {
      if (input.tagName.toLowerCase() === 'input') {
        input.addEventListener('input', filterTable);
      } else if (input.tagName.toLowerCase() === 'select') {
        input.addEventListener('change', filterTable);
      }
    });

    function filterTable() {
      const filters = {};
      document.querySelectorAll('.filter-instruktorzy').forEach(f => {
        filters[f.dataset.column] = f.value.toLowerCase().trim();
      });

      const rows = document.querySelectorAll('#instruktorzyTable tbody tr');

      rows.forEach(row => {
        let show = true;

        for (const col in filters) {
          if (filters[col]) {
            const cellText = row.cells[col].textContent.toLowerCase();
            if (!cellText.includes(filters[col])) {
              show = false;
              break;
            }
          }
        }

        row.style.display = show ? '' : 'none';
      });
    }
  </script>
</body>
</html>
