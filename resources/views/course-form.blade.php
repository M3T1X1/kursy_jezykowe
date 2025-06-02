<style>
  .container {
    max-width: 700px;
    margin: 2rem auto;
    padding: 2rem;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
  }

  h2 {
    color: #2c3e50;
    margin-bottom: 1.5rem;
    font-weight: 600;
    font-size: 1.8rem;
  }

  form {
    display: flex;
    flex-direction: column;
  }

  form > div.form-group {
    margin-bottom: 1rem;
  }

  label {
    font-weight: 600;
    margin-bottom: 0.4rem;
    display: block;
    color: #34495e;
  }

  input[type="text"],
  input[type="number"],
  input[type="date"],
  select {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1rem;
    box-sizing: border-box;
  }

  button {
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    margin-top: 1rem;
    font-weight: 600;
  }

  .btn-primary {
    background-color: #3498db;
    color: white;
  }

  .btn-primary:hover {
    background-color: #2980b9;
  }

  .btn-success {
    background-color: #2ecc71;
    color: white;
  }

  .btn-success:hover {
    background-color: #27ae60;
  }

  .btn-secondary {
    background-color: #95a5a6;
    color: white;
    margin-left: 0.5rem;
  }

  .btn-secondary:hover {
    background-color: #7f8c8d;
  }

  .form-actions {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-top: 1.5rem;
  }
</style>
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
