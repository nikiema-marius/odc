<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de présence</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('formations.index') }}">Gestion de présence</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('formations.index') }}">Formations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('attestations.index') }}">Attestations</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>


<script>
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif

    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>
