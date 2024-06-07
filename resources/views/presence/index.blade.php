@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des présences pour la formation: {{ $formation->nom }}</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom du participant</th>
                    <th>Prénom</th>
                    <th>Date de présence</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($presences as $presence)
                    <tr>
                        <td>{{ $presence->participant->nom }}</td>
                        <td>{{ $presence->participant->prenom }}</td>
                        <td>{{ $presence->created_at }}</td>
                        <td>
                            <form action="{{ route('presence.destroy', $presence) }}" method="POST" style="display:inline-block;">
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
