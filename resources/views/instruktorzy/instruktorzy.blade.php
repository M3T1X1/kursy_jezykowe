<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Instruktorzy</title>
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
      margin-bottom: 15px;
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
    <h2 class="admin-title mb-4">Instruktorzy</h2>

    <!-- Filtry -->
    <div class="row mb-3 filter-row">
      <div class="col-md-4">
        <input type="text" class="form-control filter-instruktorzy" placeholder="Imię lub nazwisko" data-column="0" />
      </div>
      <div class="col-md-4">
        <input type="text" class="form-control filter-instruktorzy" placeholder="Email" data-column="1" />
      </div>
      <div class="col-md-4">
        <select class="form-select filter-instruktorzy" data-column="2">
          <option value="">Specjalizacja</option>
          <option>Angielski</option>
          <option>Niemiecki</option>
          <option>Hiszpański</option>
          <!-- Dodaj więcej specjalizacji jeśli trzeba -->
        </select>
      </div>
    </div>

    <!-- Tabela instruktorów -->
    <div class="table-responsive bg-white">
      <table class="table table-hover mb-0" id="instruktorzyTable">
        <thead>
          <tr>
            <th>Imię i nazwisko</th>
            <th>Email</th>
            <th>Specjalizacja</th>
            <th>Telefon</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($instruktorzy as $instruktor)
            <tr>
              <td>{{ $instruktor->name }}</td>
              <td>{{ $instruktor->email }}</td>
              <td>{{ $instruktor->specialization }}</td>
              <td>{{ $instruktor->phone }}</td>
              <td>
                <a href="{{ url('instruktorzy/edit/' . $instruktor->id) }}" class="btn btn-sm btn-outline-primary btn-action">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ url('instruktorzy/delete/' . $instruktor->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Czy na pewno chcesz usunąć tego instruktora?')">
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

  <!-- Bootstrap JS (opcjonalnie, jeśli potrzebujesz np. modalów) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
