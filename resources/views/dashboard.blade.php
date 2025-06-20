<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Panel Administratora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4 py-2">Szkoła Językowa</h4>
    <div class="d-flex flex-column">
      <a href="{{ route('admin.index') }}" class="nav-link">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ route('kursy.index') }}" class="nav-link">
        <i class="bi bi-book"></i> Kursy
      </a>
      <a href="{{ route('instruktorzy.instruktorzy') }}" class="nav-link">
        <i class="bi bi-person-workspace"></i> Instruktorzy
      </a>
      <a href="{{ route('klienci.index') }}" class="nav-link">
        <i class="bi bi-people"></i> Klienci
      </a>
      <a href="{{ route('transakcje') }}" class="nav-link">
        <i class="bi bi-cash-coin"></i> Transakcje
      </a>
      <a href="{{ route('znizki.index') }}" class="nav-link">
        <i class="bi bi-tag"></i> Zniżki
      </a>
      <a href="{{ url('/') }}" class="nav-link mt-auto">
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
  <!-- Main Content -->
  <div class="main-content">
    <div id="dashboard" class="tab-pane active">
      <h2 class="admin-title mb-4">Panel administratora</h2>
      <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="stat-card">
            <i class="bi bi-book"></i>
            <h4>{{ $coursesCount }}</h4>
            <p>Kursy</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <i class="bi bi-people"></i>
            <h4>{{ $clientsCount }}</h4>
            <p>Klienci</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <i class="bi bi-person-workspace"></i>
            <h4>{{ $instructorsCount }}</h4>
            <p>Instruktorzy</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-card">
            <i class="bi bi-tag"></i>
            <h4>{{ $discountsCount }}</h4>
            <p>Zniżki</p>
          </div>
        </div>
      </div>
      <h3 class="mb-3">Ostatnie zapisy</h3>
      <div class="table-responsive bg-white">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>Kursant</th>
              <th>Email kursanta</th>
              <th>Kurs</th>
              <th>Data kursu</th>
              <th>Instruktor</th>
              <th>Cena</th>
              <th>Status</th>
              <th>Data transakcji</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentEnrollments as $enrollment)
              <tr>
                <td>{{ $enrollment->client_name }}</td>
                <td>{{ $enrollment->client_email }}</td>
                <td>{{ $enrollment->course_name }}</td>
                <td>{{ \Carbon\Carbon::parse($enrollment->course_date)->format('Y-m-d') }}</td>
                <td>{{ $enrollment->instructor }}</td>
                <td>{{ number_format((float)$enrollment->amount, 2, ',', ' ') }} PLN</td>
                <td>
                  <span class="badge rounded-pill
                    @if($enrollment->status == 'Opłacone') bg-success
                    @elseif($enrollment->status == 'Oczekuje') bg-warning text-dark
                    @else bg-danger
                    @endif
                  ">
                    {{ $enrollment->status }}
                  </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($enrollment->transaction_date)->format('Y-m-d') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">Brak danych</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
