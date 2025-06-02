<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Transakcje</title>
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
      <a href="{{ url('logout') }}" class="nav-link">
        <i class="bi bi-box-arrow-left"></i> Wyloguj
      </a>
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
              <th>Akcje</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transactions as $transaction)
              <tr>
                <td>{{ $transaction->kursant }}</td>
                <td>{{ $transaction->email }}</td>
                <td>
                  <a href="{{ url('course-detail?id=' . $transaction->kurs_id) }}" class="course-title">
                    {{ $transaction->kurs }}
                  </a>
                </td>
                <td>{{ $transaction->data_kursu }}</td>
                <td>{{ $transaction->instruktor }}</td>
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
                <td>
                  <button
                    class="btn btn-sm btn-outline-info btn-action view-transaction"
                    data-kursant="{{ $transaction->kursant }}"
                    data-email="{{ $transaction->email }}"
                    data-kurs="{{ $transaction->kurs }}"
                    data-datakursu="{{ $transaction->data_kursu }}"
                    data-instruktor="{{ $transaction->instruktor }}"
                    data-cena="{{ $transaction->cena }}"
                    data-status="{{ $transaction->status }}"
                    data-data="{{ $transaction->data_transakcji }}"
                  >
                    <i class="bi bi-eye"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
