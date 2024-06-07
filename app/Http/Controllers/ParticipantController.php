<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParticipantController extends Controller
{
    /**
     * Affiche la liste des participants d'une formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Formation $formation)
    {
        $participants = $formation->participants;
        return view('formations.participants.index', compact('formation', 'participants'));
    }

    /**
     * Affiche le formulaire d'ajout de participant.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Formation $formation)
    {
        return view('formations.participants.create', compact('formation'));
    }

    /**
     * Enregistre un nouveau participant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Formation $formation)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $participant = Participant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
        ]);

        $formation->participants()->attach($participant);

        return redirect()->route('formations.participants.index', $formation)->with('success', 'Participant ajouté avec succès !');
    }

    /**
     * Supprime un participant.
     *
     * @param  \App\Models\Formation  $formation
     * @param  \App\Models\Participant  $participant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Formation $formation, Participant $participant)
    {
        $formation->participants()->detach($participant);
        return redirect()->route('formations.participants.index', $formation)->with('success', 'Participant supprimé avec succès !');
    }
}