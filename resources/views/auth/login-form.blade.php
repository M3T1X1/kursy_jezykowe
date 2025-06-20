<form method="POST" action="{{ route('login') }}">
    @csrf

    <h2 class="mb-4 text-center">Logowanie</h2>

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
               value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Hasło:</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100">Zaloguj się</button>
    </div>

    <div class="mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary btn-wroc">Anuluj</a>
    </div>

    <div class="text-center mt-3">
        <small>
            Nie masz konta?
            <a href="{{ url('/register') }}">Zarejestruj się</a>
        </small>
    </div>
</form>
