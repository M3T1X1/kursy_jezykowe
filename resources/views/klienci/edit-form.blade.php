<form method="POST" action="{{ route('klienci.update', $klient->id_klienta) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h2 class="mb-4 text-center">Edycja klienta</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" name="email" class="form-control"
               value="{{ old('email', $klient->email) }}" required>
    </div>

    <div class="mb-3">
        <label for="haslo" class="form-label">Hasło (zostaw puste, aby nie zmieniać):</label>
        <input type="password" id="haslo" name="haslo" class="form-control">
    </div>

    <div class="mb-3">
        <label for="imie" class="form-label">Imię:</label>
        <input type="text" id="imie" name="imie" class="form-control"
               value="{{ old('imie', $klient->imie) }}" required>
    </div>

    <div class="mb-3">
        <label for="nazwisko" class="form-label">Nazwisko:</label>
        <input type="text" id="nazwisko" name="nazwisko" class="form-control"
               value="{{ old('nazwisko', $klient->nazwisko) }}" required>
    </div>

    <div class="mb-3">
        <label for="adres" class="form-label">Adres:</label>
        <input type="text" id="adres" name="adres" class="form-control"
               value="{{ old('adres', $klient->adres) }}" required>
    </div>

    <div class="mb-3">
        <label for="nr_telefonu" class="form-label">Nr telefonu:</label>
        <input type="text" id="nr_telefonu" name="nr_telefonu" class="form-control"
               value="{{ old('nr_telefonu', $klient->nr_telefonu) }}" required>
    </div>

    <div class="mb-3">
        <label for="adres_zdjecia" class="form-label">Adres zdjęcia (opcjonalnie):</label>
        <input type="text" id="adres_zdjecia" name="adres_zdjecia" class="form-control"
               value="{{ old('adres_zdjecia', $klient->adres_zdjecia) }}">
    </div>

    <div class="mb-3">
        <label for="zdjecie" class="form-label">Lub prześlij nowe zdjęcie z dysku:</label>
        <input type="file" id="zdjecie" name="zdjecie" class="form-control" accept="image/*">
    </div>

    @if($klient->adres_zdjecia)
        <div class="mb-3">
            <strong>Obecne zdjęcie:</strong><br>
            <img src="{{ asset('storage/' . $klient->adres_zdjecia) }}" alt="Zdjęcie klienta"
                 style="width:70px; height:70px; object-fit:cover; border-radius:8px;">
        </div>
    @endif

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </div>

    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary btn-wroc">Anuluj</a>
    </div>
</form>
