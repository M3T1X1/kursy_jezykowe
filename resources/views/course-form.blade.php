<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">

<div class="mb-3">
    <label for="jezyk" class="form-label">Język</label>
    <input type="text" name="jezyk" id="jezyk" class="form-control"
           value="{{ old('jezyk', $course->jezyk ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="poziom" class="form-label">Poziom</label>
    <select name="poziom" id="poziom" class="form-select" required>
        <option value="">Wybierz poziom</option>
        <option value="Początkujący" {{ old('poziom', $course->poziom ?? '') == 'Początkujący' ? 'selected' : '' }}>Początkujący</option>
        <option value="Średniozaawansowany" {{ old('poziom', $course->poziom ?? '') == 'Średniozaawansowany' ? 'selected' : '' }}>Średniozaawansowany</option>
        <option value="Zaawansowany" {{ old('poziom', $course->poziom ?? '') == 'Zaawansowany' ? 'selected' : '' }}>Zaawansowany</option>
    </select>
</div>

<div class="mb-3">
    <label for="data_rozpoczecia" class="form-label">Data rozpoczęcia</label>
    <input type="date" name="data_rozpoczecia" id="data_rozpoczecia" class="form-control"
           value="{{ old('data_rozpoczecia', isset($course) && $course->data_rozpoczecia ? $course->data_rozpoczecia->format('Y-m-d') : '') }}" required>
</div>

<div class="mb-3">
    <label for="data_zakonczenia" class="form-label">Data zakończenia</label>
    <input type="date" name="data_zakonczenia" id="data_zakonczenia" class="form-control"
           value="{{ old('data_zakonczenia', isset($course) && $course->data_zakonczenia ? $course->data_zakonczenia->format('Y-m-d') : '') }}" required>
</div>

<div class="mb-3">
    <label for="cena" class="form-label">Cena</label>
    <input type="number" name="cena" id="cena" class="form-control"
           value="{{ old('cena', $course->cena ?? '') }}" min="0" step="0.01" required>
</div>

<div class="mb-3">
    <label for="liczba_miejsc" class="form-label">Liczba miejsc</label>
    <input type="number" name="liczba_miejsc" id="liczba_miejsc" class="form-control"
           value="{{ old('liczba_miejsc', $course->liczba_miejsc ?? '') }}" min="1" required>
</div>

<div class="mb-3">
    <label for="id_instruktora" class="form-label">Instruktor</label>
    <select name="id_instruktora" id="id_instruktora" class="form-select" required>
        <option value="">Wybierz instruktora</option>
        @foreach($instruktorzy as $instruktor)
            <option value="{{ $instruktor->id }}"
                {{ old('id_instruktora', $course->id_instruktora ?? '') == $instruktor->id ? 'selected' : '' }}>
                {{ $instruktor->imie }} {{ $instruktor->nazwisko }} ({{ $instruktor->jezyk }})
            </option>
        @endforeach
    </select>
</div>


<div class="mb-3">
    <label for="zdjecie" class="form-label">Zdjęcie kursu</label>
    <input type="file" name="zdjecie" id="zdjecie" class="form-control" accept="image/*">
    @if(isset($course) && $course->zdjecie)
        <div class="mt-2">
            <small class="text-muted">Obecne zdjęcie:</small><br>
            <img src="{{ asset('storage/' . $course->zdjecie) }}" alt="Zdjęcie kursu" style="max-width: 200px; max-height: 150px; object-fit: cover;" class="rounded">
        </div>
    @endif
</div>

@if(isset($course) && $course->zdjecie)
<div class="mb-3 form-check">
    <input type="checkbox" name="usun_zdjecie" id="usun_zdjecie" value="1" class="form-check-input">
    <label for="usun_zdjecie" class="form-check-label">Usuń obecne zdjęcie</label>
</div>
@endif
