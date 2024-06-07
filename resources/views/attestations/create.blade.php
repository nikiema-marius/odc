@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Générer une attestation pour la formation: {{ $formation->nom }}</h1>
        <form action="{{ route('attestations.store', $formation) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="participant_id">Participant</label>
                <select class="form-control" id="participant_id" name="participant_id">
                    @foreach($participants as $participant)
                        <option value="{{ $participant->id }}">{{ $participant->nom }} {{ $participant->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Générer l'attestation</button>
        </form>
    </div>
@endsection
