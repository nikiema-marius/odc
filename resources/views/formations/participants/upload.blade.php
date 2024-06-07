@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Télécharger une liste de participants pour la formation: {{ $formation->nom }}</h1>
        <form action="{{ route('formations.participants.upload.store', $formation) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Fichier PDF</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Télécharger</button>
        </form>
    </div>
@endsection
