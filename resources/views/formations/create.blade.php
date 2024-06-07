@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter une nouvelle formation</h1>
        <form action="{{ route('formations.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom') }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}">
            </div>
            <div class="form-group">
                <label for="heure">Heure</label>
                <input type="time" class="form-control" id="heure" name="heure" value="{{ old('heure') }}">
            </div>
            <div class="form-group">
                <label for="lieu">Lieu</label>
                <input type="text" class="form-control" id="lieu" name="lieu" value="{{ old('lieu') }}">
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection
