<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
    @csrf

    @if(request('admin'))
        <input type="hidden" name="admin" value="1">
    @endif

    <h2 class="mb-4 text-center">Rejestracja</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" name="email" class="form-control"
               value="{{ old('email', request('email'))}}" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Hasło:</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="imie" class="form-label">Imię:</label>
        <input type="text" id="imie" name="imie" class="form-control"
               value="{{ old('imie') }}" required>
    </div>

    <div class="mb-3">
        <label for="nazwisko" class="form-label">Nazwisko:</label>
        <input type="text" id="nazwisko" name="nazwisko" class="form-control"
               value="{{ old('nazwisko') }}" required>
    </div>

    <div class="mb-3">
        <label for="adres" class="form-label">Adres:</label>
        <input type="text" id="adres" name="adres" class="form-control"
               value="{{ old('adres') }}" required>
    </div>

    <div class="mb-3">
        <label for="nr_telefonu" class="form-label">Nr telefonu:</label>
        <input type="text" id="nr_telefonu" name="nr_telefonu" class="form-control"
               value="{{ old('nr_telefonu') }}" required>
    </div>

    <div class="mb-3">
        <label for="adres_zdjecia" class="form-label">Adres zdjęcia (opcjonalnie):</label>
        <input type="text" id="adres_zdjecia" name="adres_zdjecia" class="form-control"
               value="{{ old('adres_zdjecia') }}">
    </div>

    <div class="mb-3">
        <label for="zdjecie" class="form-label">Lub prześlij zdjęcie z dysku:</label>
        <input type="file" id="zdjecie" name="zdjecie" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100">Zarejestruj się</button>
    </div>

    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary btn-wroc">Anuluj</a>
    </div>

    <div class="text-center mt-3">
        <small>
            Masz już konto?
            <a href="{{ url('/login') }}">Zaloguj się</a>
        </small>
    </div>
</form>
