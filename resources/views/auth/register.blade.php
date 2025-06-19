<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>
<div class="register-container">
    <h2>Rejestracja</h2>

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

    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf

        @if(request('admin'))
        <input type="hidden" name="admin" value="1">
        @endif

        <div class="form-group">
            <label for="email">Email:</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', request('email'))}}" 
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Hasło:</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <div class="form-group">
            <label for="imie">Imię:</label>
            <input
                type="text"
                id="imie"
                name="imie"
                value="{{ old('imie') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="nazwisko">Nazwisko:</label>
            <input
                type="text"
                id="nazwisko"
                name="nazwisko"
                value="{{ old('nazwisko') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="adres">Adres:</label>
            <input
                type="text"
                id="adres"
                name="adres"
                value="{{ old('adres') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="nr_telefonu">Nr telefonu:</label>
            <input
                type="text"
                id="nr_telefonu"
                name="nr_telefonu"
                value="{{ old('nr_telefonu') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="adres_zdjecia">Adres zdjęcia (opcjonalnie):</label>
            <input
                type="text"
                id="adres_zdjecia"
                name="adres_zdjecia"
                value="{{ old('adres_zdjecia') }}"
            >
        </div>

        <div class="form-group">
            <label for="zdjecie">Lub prześlij zdjęcie z dysku:</label>
            <input
                type="file"
                id="zdjecie"
                name="zdjecie"
                accept="image/*"
            >
        </div>

        <button type="submit">Zarejestruj się</button>
    </form>

    <div class="links">
        <p>
            Masz już konto?
            <a href="{{ url('/login') }}">Zaloguj się</a>
        </p>
    </div>
</div>
</body>
</html>
