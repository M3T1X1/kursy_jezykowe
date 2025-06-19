<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/form.css') }}">

  <form method="POST" action="{{ route('rezerwacja.submit') }}">
  @csrf

  <h5 class="mb-3">Twoje dane</h5>
  <div class="user-info mb-4">
    <div class="mb-2">
      <label class="form-label">Imię:</label>
      <p class="form-control-plaintext">{{ $user->imie ?? $user->name ?? 'Nie podano' }}</p>
    </div>
    <div class="mb-2">
      <label class="form-label">Nazwisko:</label>
      <p class="form-control-plaintext">{{ $user->nazwisko ?? 'Nie podano' }}</p>
    </div>
    <div class="mb-2">
      <label class="form-label">Email:</label>
      <p class="form-control-plaintext">{{ $user->email }}</p>
    </div>
    <div class="mb-2">
      <label class="form-label">Telefon:</label>
      <p class="form-control-plaintext">{{ $user->nr_telefonu ?? 'Nie podano' }}</p>
    </div>
  </div>

  <h5 class="mb-3 mt-4">Szczegóły kursu</h5>
  @if($selectedCourse)
    <div class="mb-3">
      <label class="form-label">Język:</label>
      <p class="form-control-plaintext">{{ $selectedCourse->jezyk }}</p>
    </div>
    <div class="mb-3">
      <label class="form-label">Poziom zaawansowania:</label>
      <p class="form-control-plaintext">{{ $selectedCourse->poziom }}</p>
    </div>
    <div class="mb-3">
      <label class="form-label">Data rozpoczęcia kursu:</label>
      <p class="form-control-plaintext">{{ \Illuminate\Support\Carbon::parse($selectedCourse->data_rozpoczecia)->format('Y-m-d') }}</p>
    </div>
    <div class="mb-3">
      <label class="form-label">Cena bazowa:</label>
      <p class="form-control-plaintext">{{ number_format($selectedCourse->cena, 2, ',', ' ') }} zł</p>
    </div>
    <input type="hidden" name="course" value="{{ $selectedCourse->id_kursu }}">
  @else
    <div class="alert alert-warning">Brak dostępnych kursów do rezerwacji.</div>
  @endif

  <div class="d-flex flex-column gap-3 mt-4">
    <button type="submit" class="btn btn-lg btn-primary w-100">
      <i class="bi bi-check-circle"></i> Zarezerwuj miejsce
    </button>
    <a href="{{ route('home') }}" class="btn-wroc btn btn-lg w-100">
      <i class="bi bi-arrow-left"></i> Wróć na stronę główną
    </a>
  </div>
</form>
