<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Panel Administratora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
    .tab-pane {
      display: none;
    }
    .tab-pane.active {
      display: block;
    }
    .admin-title {
      font-weight: 600;
      color: #2c3e50;
    }
    .stat-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      padding: 20px;
      text-align: center;
      transition: transform 0.2s;
      height: 100%;
    }
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .stat-card h4 {
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 5px;
      color: #3498db;
    }
    .stat-card p {
      color: #7f8c8d;
      margin-bottom: 0;
    }
    .stat-card i {
      font-size: 32px;
      margin-bottom: 15px;
      color: #3498db;
    }
    .table th {
      font-weight: 600;
      color: #2c3e50;
    }
    .table-hover tbody tr:hover {
      background-color: rgba(52, 152, 219, 0.05);
    }
    .search-input {
      border-radius: 20px;
      padding-left: 40px;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>');
      background-repeat: no-repeat;
      background-position: 15px center;
      background-size: 15px;
    }
    .btn-action {
      border-radius: 4px;
      transition: all 0.2s;
    }
    .table-responsive {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .filter-row .form-select, .filter-row .form-control {
      margin-bottom: 8px;
    }
    .instructor-name, .course-title {
      color: #3498db;
      text-decoration: none;
      transition: all 0.2s;
    }
    .instructor-name:hover, .course-title:hover {
      color: #2980b9;
      text-decoration: underline;
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
      <a href="{{ route('admin.index') }}" class="nav-link">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      <a href="{{ route('kursy.index') }}" class="nav-link">
        <i class="bi bi-book"></i> Kursy
      </a>
      <a href="#" class="nav-link">
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
      <a href="{{ url('/') }}" class="nav-link mt-auto" target="_blank">
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
            <p>Aktywne zniżki</p>
          </div>
        </div>
      </div>
      <h3 class="mb-3">Ostatnie zapisy</h3>
      <div class="table-responsive bg-white">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>Kursant</th>
              <th>Kurs</th>
              <th>Data</th>
              <th>Status</th>
              <th>Kwota</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recentEnrollments as $enrollment)
              <tr>
                <td>{{ $enrollment->client_name }}</td>
                <td>{{ $enrollment->course_name }}</td>
                <td>{{ $enrollment->date }}</td>
                <td>
                  @if($enrollment->status === 'paid')
                    <span class="badge bg-success">Opłacone</span>
                  @elseif($enrollment->status === 'pending')
                    <span class="badge bg-warning text-dark">Oczekuje</span>
                  @else
                    <span class="badge bg-secondary">{{ $enrollment->status }}</span>
                  @endif
                </td>
                <td>{{ $enrollment->amount }} PLN</td>
              </tr>
            @endforeach
            @if($recentEnrollments->isEmpty())
              <tr>
                <td colspan="5" class="text-center text-muted">Brak danych</td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
