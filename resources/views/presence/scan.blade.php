@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Scanner le code QR pour la formation: {{ $formation->nom }}</h1>
        <form action="{{ route('presence.store', $formation) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="participant_id">ID du participant</label>
                <input type="text" class="form-control" />
                <input type="text" class="form-control" id="participant_id" name="participant_id">
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer la présence</button>
        </form>
    </div>
@endsection
