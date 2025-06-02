<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj zniżkę</title>
    <style>
        .form-container {
            max-width: 400px;
            margin: 40px auto;
            padding: 24px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fafbfc;
            font-family: Arial, sans-serif;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 6px;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Arial, sans-serif;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .alert {
            background: #f8d7da;
            color: #721c24;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 16px;
        }
        .links {
            margin-top: 20px;
            text-align: center;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Dodaj nową zniżkę</h2>

    {{-- Komunikaty o błędach --}}
    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('znizki.store') }}">
        @csrf

        <div class="form-group">
            <label for="nazwa_znizki">Nazwa zniżki:</label>
            <input
                type="text"
                id="nazwa_znizki"
                name="nazwa_znizki"
                value="{{ old('nazwa_znizki') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="wartosc">Wartość (%):</label>
            <input
                type="number"
                id="wartosc"
                name="wartosc"
                min="0"
                max="100"
                value="{{ old('wartosc') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="opis">Opis (opcjonalnie):</label>
            <textarea
                id="opis"
                name="opis"
                rows="3"
            >{{ old('opis') }}</textarea>
        </div>

        <button type="submit">Dodaj zniżkę</button>
    </form>

    <div class="links">
        <p>
            <a href="{{ route('znizki.index') }}">← Powrót do listy zniżek</a>
        </p>
    </div>
</div>
</body>
</html>
