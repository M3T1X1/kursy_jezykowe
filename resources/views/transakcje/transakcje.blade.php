<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Transakcje</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/transactions.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
  $(document).ready(function () {
    $(".filter-transakcje").on("input change", function () {
      const $filters = $(".filter-transakcje");
      $("#transakcjeTable tbody tr").each(function () {
        let showRow = true;
        $(this).find("td").each(function (index) {
          const input = $filters.filter(`[data-column='${index}']`);
          if (input.length) {
            const filterVal = input.val().toLowerCase().trim();
            const cellText = $(this).text().toLowerCase().trim();
            if (filterVal && !cellText.includes(filterVal)) {
              showRow = false;
            }
          }
        });
        $(this).toggle(showRow);
      });
    });
  });
</script>
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
      <a href="{{ url('instruktorzy') }}" class="nav-link">
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
      <a href="{{ url('/home') }}" class="nav-link mt-auto" target="_blank">
        <i class="bi bi-house"></i> Strona główna
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="nav-link btn btn-link" style="color: inherit; text-align: left;">
          <i class="bi bi-box-arrow-left"></i> Wyloguj
        </button>
      </form>
    </div>
  </div>

  <div class="main-content">
    <!-- Transakcje Tab -->
    <div id="transakcje" class="tab-pane active">
      <h2 class="admin-title mb-4">Transakcje</h2>
      <div class="row mb-3">
        <div class="col-md-3">
          <input type="text" class="form-control filter-transakcje" placeholder="Kursant" data-column="0" />
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control filter-transakcje" placeholder="Email" data-column="1" />
        </div>
        <div class="col-md-3">
          <input type="text" class="form-control filter-transakcje" placeholder="Kurs" data-column="2" />
        </div>
        <div class="col-md-3">
          <select class="form-select filter-transakcje" data-column="6">
            <option value="">Status</option>
            <option>Opłacone</option>
            <option>Oczekuje</option>
            <option>Anulowane</option>
          </select>

          <form action="{{ route('transakcje.anuluj_przeterminowane') }}" method="GET" onsubmit="return confirm('Czy na pewno chcesz anulować przeterminowane transakcje i usunąć powiązane rezerwacje?');" class="mt-3">
            <button type="submit" class="btn btn-danger w-100">
              <i class="bi bi-ban"></i> Anuluj przeterminowane transakcje
            </button>
          </form>

        </div>
      </div>

      <div class="table-responsive bg-white">
        <table class="table table-hover mb-0" id="transakcjeTable">
          <thead>
            <tr>
              <th>Kursant</th>
              <th>Email kursanta</th>
              <th>Kurs</th>
              <th>Data kursu</th>
              <th>Instruktor</th>
              <th>Cena ostateczna</th>
              <th>Status</th>
              <th>Data transakcji</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transactions as $transaction)
              <tr>
                <td>{{ $transaction->kursant }}</td>
                <td>{{ $transaction->email }}</td>
                <td>
                  {{ $transaction->kurs }}
                </td>
                <td>{{ $transaction->data_kursu }}</td>
                <td>{{ $transaction->instructor ?? 'Brak instruktora' }}</td>
                <td>{{ $transaction->cena }}</td>
                <td>
                  <span class="badge
                    @if($transaction->status == 'Opłacone') bg-success
                    @elseif($transaction->status == 'Oczekuje') bg-warning text-dark
                    @else bg-danger
                    @endif
                  ">
                    {{ $transaction->status }}
                  </span>
                </td>
                <td>{{ $transaction->data_transakcji }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
