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
<div class="container mt-5 p-4 bg-light rounded shadow-sm border">
  <h2 class="mb-4 text-success">Dodaj kurs</h2>

  <form method="POST" action="{{ route('kursy.store') }}">
    @csrf

    @include('course-form')

    <div class="mt-4 d-flex justify-content-between">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Zapisz
      </button>
      <a href="{{ route('kursy.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-x-lg"></i> Anuluj
      </a>
    </div>
  </form>
</div>
