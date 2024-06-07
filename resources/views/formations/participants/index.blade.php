@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des participants de la formation: {{ $formation->nom }}</h1>
        <a href="{{ route('formations.participants.create', $formation) }}" class="btn btn-primary">Ajouter un participant</a>
        <a href="{{ route('formations.participants.upload', $formation) }}" class="btn btn-secondary">Télécharger liste des participants</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $participant)
                    <tr>
                        <td>{{ $participant->nom }}</td>
                        <td>{{ $participant->prenom }}</td>
                        <td>{{ $participant->email }}</td>
                        <td>
                            <form action="{{ route('formations.participants.destroy', [$formation, $participant]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
