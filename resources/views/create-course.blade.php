<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dodaj kurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>
    <div class="container bg-white rounded shadow-sm">
        <h2>Dodaj kurs</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kursy.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @php $course = null; @endphp
            @include('course-form')
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Dodaj kurs</button>
                <a href="{{ route('kursy.index') }}" class="btn btn-secondary">Anuluj</a>
            </div>
        </form>
    </div>
</body>
</html>
