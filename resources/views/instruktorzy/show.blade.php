<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Instruktor - {{ $instruktor->imie }} {{ $instruktor->nazwisko }}</title>
</head>
<body>
    <h1>Instruktor: {{ $instruktor->imie }} {{ $instruktor->nazwisko }}</h1>

    <p><strong>Email:</strong> {{ $instruktor->email }}</p>
    <p><strong>Język:</strong> {{ $instruktor->jezyk }}</p>
    <p><strong>Poziom:</strong> {{ $instruktor->poziom }}</p>
    <p><strong>Płaca:</strong> {{ $instruktor->placa }} PLN</p>

    <h3>Kursy przypisane do instruktora:</h3>
    @if($instruktor->kursy->isEmpty())
        <p>Brak kursów.</p>
    @else
        <ul>
            @foreach($instruktor->kursy as $kurs)
                <li>{{ $kurs->nazwa }}</li>
            @endforeach
        </ul>
    @endif

    <p><a href="{{ url('instruktorzy') }}">Powrót do listy instruktorów</a></p>
</body>
</html>
