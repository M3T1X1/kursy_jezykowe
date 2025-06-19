<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kursy - Panel Administratora</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
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
      <a href="{{ url('znizki') }}" class="nav-link"><i class="bi bi-tag"></i> Zniżki</a>
      <a href="{{ url('/home') }}" class="nav-link mt-auto"><i class="bi bi-house"></i> Strona główna</a>
      <a href="{{ url('logout') }}" class="nav-link"><i class="bi bi-box-arrow-left"></i> Wyloguj</a>
    </div>
  </div>

  <div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="admin-title">Kursy</h2>
      <a href="{{ route('kursy.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Dodaj kurs
      </a>
    </div>

    <!-- Filtry -->
    <div class="row mb-4 filters">
  <div class="col-md-2">
    <input class="form-control filter-kursy" name="jezyk" placeholder="Język" value="{{ request('jezyk') }}" />
  </div>
  <div class="col-md-2">
    <input class="form-control filter-kursy" name="poziom" placeholder="Poziom" value="{{ request('poziom') }}" />
  </div>
  <div class="col-md-2">
    <input class="form-control filter-kursy" name="cena_max" type="number" placeholder="Cena max" value="{{ request('cena_max') }}" />
  </div>
  <div class="col-md-2">
    <input class="form-control filter-kursy" name="instruktor" placeholder="Instruktor" value="{{ request('instruktor') }}" />
  </div>
  <div class="col-md-2">
    <input class="form-control filter-kursy" name="miejsca" placeholder="Miejsca" value="{{ request('miejsca') }}" />
  </div>
</div>

<div class="table-responsive bg-white p-3 rounded shadow-sm">
  <table class="table" id="coursesTable">
    <thead>
      <tr>
        <th>Nazwa kursu</th>
        <th>Język</th>
        <th>Poziom</th>
        <th>Instruktor</th>
        <th>Start</th>
        <th>Koniec</th>
        <th>Cena</th>
        <th>Miejsca</th>
        <th>Akcje</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($courses as $course)
      <tr>
        <td>
          {{ $course->jezyk }} {{ $course->poziom }}
        </td>
        <td>
          {{ $course->jezyk }}
        </td>
        <td>{{ $course->poziom }}</td>
        <td>
          <td>
            @if ($course->hasInstructor())
                {{ $course->instructor_full_name }}
            @else
                <span class="text-muted">Brak instruktora</span>
            @endif
</td>
        </td>
        <td>{{ \Carbon\Carbon::parse($course->data_rozpoczecia)->format('Y-m-d') }}</td>
        <td>{{ \Carbon\Carbon::parse($course->data_zakonczenia)->format('Y-m-d') }}</td>
        <td>{{ $course->cena }}</td>
        <td>{{ $course->liczba_miejsc }}</td>
        <td class="d-flex gap-1">
          <a href="{{ route('kursy.edit', $course->id_kursu) }}" class="btn btn-sm btn-outline-primary" title="Edytuj">
            <i class="bi bi-pencil"></i>
          </a>

          <form action="{{ route('kursy.destroy', $course->id_kursu) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć ten kurs?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger" title="Usuń">
              <i class="bi bi-trash"></i>
            </button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputJezyk = document.querySelector('input[name="jezyk"]');
    const inputPoziom = document.querySelector('input[name="poziom"]');
    const inputCenaMax = document.querySelector('input[name="cena_max"]');
    const inputInstruktor = document.querySelector('input[name="instruktor"]');
    const inputMiejsca = document.querySelector('input[name="miejsca"]');

    const table = document.getElementById('coursesTable');
    const rows = table.querySelectorAll('tbody tr');

    if (!table) {
        console.error('Tabela coursesTable nie znaleziona');
        return;
    }

    [inputJezyk, inputPoziom, inputCenaMax, inputInstruktor, inputMiejsca].forEach(input => {
        if(input) {
            input.addEventListener('input', function() {
                console.log(`Filtrowanie po: ${input.name} = ${input.value}`);
                filterRows();
            });
        } else {
            console.warn('Nie znaleziono inputa:', input);
        }
    });

    function filterRows() {
        const filterJezyk = inputJezyk?.value.trim().toLowerCase() || '';
        const filterPoziom = inputPoziom?.value.trim().toLowerCase() || '';
        const filterCena = parseFloat(inputCenaMax?.value.replace(',', '.') || NaN);
        const filterInstruktor = inputInstruktor?.value.trim().toLowerCase() || '';
        const filterMiejsca = parseInt(inputMiejsca?.value) || NaN;

        rows.forEach(row => {
            const cells = row.children;

            const jezyk = cells[1].textContent.trim().toLowerCase();
            const poziom = cells[2].textContent.trim().toLowerCase();
            const instruktor = cells[3].textContent.trim().toLowerCase();
            const cena = parseFloat(cells[6].textContent.replace(',', '.')) || NaN;
            const miejsca = parseInt(cells[7].textContent) || NaN;

            let show = true;

            if(filterJezyk && !jezyk.includes(filterJezyk)) {
                show = false;
            }
            if(filterPoziom && !poziom.includes(filterPoziom)) {
                show = false;
            }
            if(!isNaN(filterCena) && (isNaN(cena) || cena > filterCena)) {
                show = false;
            }
            if(filterInstruktor && !instruktor.includes(filterInstruktor)) {
                show = false;
            }
            if(!isNaN(filterMiejsca) && miejsca !== filterMiejsca) {
                show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }
});
</script>
</body>
