<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">


<div class="mb-3">
  <label for="jezyk" class="form-label">Język</label>
  <input type="text" name="jezyk" class="form-control" value="{{ old('jezyk', $course->jezyk ?? '') }}" required>
</div>

<div class="mb-3">
  <label for="poziom" class="form-label">Poziom</label>
  <input type="text" name="poziom" class="form-control" value="{{ old('poziom', $course->poziom ?? '') }}" required>
</div>

<div class="mb-3">
  <label for="data_rozpoczecia" class="form-label">Data rozpoczęcia</label>
  <input type="date" name="data_rozpoczecia" class="form-control" value="{{ old('data_rozpoczecia', isset($course) ? $course->data_rozpoczecia->format('Y-m-d') : '') }}" required>
</div>

<div class="mb-3">
  <label for="data_zakonczenia" class="form-label">Data zakończenia</label>
  <input type="date" name="data_zakonczenia" class="form-control" value="{{ old('data_zakonczenia', isset($course) ? $course->data_zakonczenia->format('Y-m-d') : '') }}" required>
</div>

<div class="mb-3">
  <label for="cena" class="form-label">Cena</label>
  <input type="number" name="cena" class="form-control" value="{{ old('cena', $course->cena ?? '') }}" required>
</div>

<div class="mb-3">
  <label for="liczba_miejsc" class="form-label">Liczba miejsc</label>
  <input type="number" name="liczba_miejsc" class="form-control" value="{{ old('liczba_miejsc', $course->liczba_miejsc ?? '') }}" required>
</div>

<div class="mb-3">
  <label for="id_instruktora" class="form-label">Instruktor</label>
  <select name="id_instruktora" class="form-select">
    @foreach($instruktorzy as $instruktor)
      <option value="{{ $instruktor->id }}" {{ (isset($course) && $course->id_instruktora == $instruktor->id) ? 'selected' : '' }}>
        {{ $instruktor->imie }} {{ $instruktor->nazwisko }}
      </option>
    @endforeach
  </select>
</div>
