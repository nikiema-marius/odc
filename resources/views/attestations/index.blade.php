@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des attestations pour la formation: {{ $formation->nom }}</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Date d'émission</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attestations as $attestation)
                    <tr>
                        <td>{{ $attestation->participant->nom }} {{ $attestation->participant->prenom }}</td>
                        <td>{{ $attestation->created_at }}</td>
                        <td>
                            <a href="{{ route('attestations.show', $attestation) }}" class="btn btn-info">Voir</a>
                            <a href="{{ route('attestations.download', $attestation) }}" class="btn btn-primary">Télécharger</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
