<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">


<div class="container mt-5 p-4 bg-light rounded shadow-sm border">
  <h2 class="mb-4">Dodaj kurs</h2>

  <form method="POST" action="{{ route('kursy.store') }}">
    @csrf

    @include('course-form')

    <div class="mt-4 d-flex flex-column gap-3">
  <button type="submit" class="btn btn-lg btn-primary w-100">
    <i class="bi bi-check-circle"></i> Zapisz
  </button>
  <a href="{{ route('kursy.index') }}" class="btn-wroc btn btn-lg w-100">
    <i class="bi bi-arrow-left"></i> Wróć
  </a>
</div>


