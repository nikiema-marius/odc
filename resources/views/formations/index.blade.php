@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des formations</h1>
        <a href="{{ route('formations.create') }}" class="btn btn-primary">Ajouter une formation</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Lieu</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formations as $formation)
                    <tr>
                        <td>{{ $formation->nom }}</td>
                        <td>{{ $formation->description }}</td>
                        <td>{{ $formation->date }}</td>
                        <td>{{ $formation->heure }}</td>
                        <td>{{ $formation->lieu }}</td>
                        <td>{{ $formation->statut ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('formations.edit', $formation) }}" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('formations.destroy', $formation) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                            <form action="{{ route('formations.toggleStatus', $formation) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-secondary">{{ $formation->statut ? 'Désactiver' : 'Activer' }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
