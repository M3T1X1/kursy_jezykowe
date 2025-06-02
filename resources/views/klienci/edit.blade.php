<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edycja klienta</title>
    <style>
        body { background: #f7f7f7; font-family: Arial, sans-serif; }
        .edit-container {
            max-width: 430px;
            margin: 40px auto;
            padding: 28px 24px 20px 24px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 8px #eee;
        }
        h2 { text-align: center; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; }
        input[type="email"], input[type="password"], input[type="text"] {
            width: 100%; padding: 8px; margin-bottom: 8px;
            border: 1px solid #ccc; border-radius: 4px; font-size: 15px;
        }
        button {
            width: 100%; padding: 10px; background: #007bff; color: #fff;
            border: none; border-radius: 4px; font-size: 16px; margin-top: 8px;
        }
        .alert { background: #f8d7da; color: #721c24; padding: 8px 12px;
            border-radius: 4px; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="edit-container">
    <h2>Edycja klienta</h2>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('klienci.update', $klient->id_klienta) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $klient->email) }}" required>
        </div>

        <div class="form-group">
            <label for="haslo">Hasło (zostaw puste, aby nie zmieniać):</label>
            <input type="password" id="haslo" name="haslo">
        </div>

        <div class="form-group">
            <label for="imie">Imię:</label>
            <input type="text" id="imie" name="imie" value="{{ old('imie', $klient->imie) }}" required>
        </div>

        <div class="form-group">
            <label for="nazwisko">Nazwisko:</label>
            <input type="text" id="nazwisko" name="nazwisko" value="{{ old('nazwisko', $klient->nazwisko) }}" required>
        </div>

        <div class="form-group">
            <label for="adres">Adres:</label>
            <input type="text" id="adres" name="adres" value="{{ old('adres', $klient->adres) }}" required>
        </div>

        <div class="form-group">
            <label for="nr_telefonu">Nr telefonu:</label>
            <input type="text" id="nr_telefonu" name="nr_telefonu" value="{{ old('nr_telefonu', $klient->nr_telefonu) }}" required>
        </div>

        <div class="form-group">
            <label for="adres_zdjecia">Adres zdjęcia (opcjonalnie):</label>
            <input type="text" id="adres_zdjecia" name="adres_zdjecia" value="{{ old('adres_zdjecia', $klient->adres_zdjecia) }}">
        </div>

        <div class="form-group">
            <label for="zdjecie">Lub prześlij nowe zdjęcie z dysku:</label>
            <input type="file" id="zdjecie" name="zdjecie" accept="image/*">
        </div>

        @if($klient->adres_zdjecia)
            <div style="margin-bottom: 10px;">
                <strong>Obecne zdjęcie:</strong><br>
                <img src="{{ asset('storage/' . $klient->adres_zdjecia) }}" alt="Zdjęcie klienta" style="width:70px; height:70px; object-fit:cover; border-radius:8px;">
            </div>
        @endif

        <button type="submit">Zapisz zmiany</button>
    </form>
    <div style="text-align: center; margin-top: 16px;">
        <a href="{{ route('klienci.index') }}" style="color: #007bff; text-decoration: none; font-weight: bold;">
            ← Wróć do tabeli klientów
        </a>
    </div>
</div>
</body>
</html>
