<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Participant;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PresenceController extends Controller
{
    /**
     * Affiche la page de scan du code QR.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Contracts\View\View
     */
    public function scan(Formation $formation)
    {
        return view('presence.scan', compact('formation'));
    }

    /**
     * Enregistre la présence d'un participant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Formation $formation)
    {
        $validator = Validator::make($request->all(), [
            'participant_id' => 'required|exists:participants,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier si la présence n'est pas déjà enregistrée pour ce participant et cette formation
        $presenceExists = Presence::where('formation_id', $formation->id)
            ->where('participant_id', $request->participant_id)
            ->exists();

        if ($presenceExists) {
            return redirect()->route('presence.scan', $formation)->with('error', 'Présence déjà enregistrée pour ce participant.');
        }

        $presence = new Presence();
        $presence->formation_id = $formation->id;
        $presence->participant_id = $request->participant_id;
        $presence->date_presence = date('Y-m-d');
        $presence->save();

        return redirect()->route('presence.scan', $formation)->with('success', 'Présence enregistrée avec succès !');
    }

    /**
     * Affiche la page de génération des attestations.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function attestation()
    {
        $formations = Formation::all();
        return view('attestations.index', compact('formations'));
    }

    /**
     * Génère et télécharge l'attestation d'un participant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateAttestation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'formation_id' => 'required|exists:formations,id',
            'participant_id' => 'required|exists:participants,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formation = Formation::findOrFail($request->formation_id);
        $participant = Participant::findOrFail($request->participant_id);

        // Vérifier si le participant a une présence pour la formation sélectionnée
        $presenceExists = Presence::where('formation_id', $formation->id)
            ->where('participant_id', $participant->id)
            ->exists();

        if (!$presenceExists) {
            return redirect()->route('attestations.index')->with('error', 'Ce participant n\'a pas assisté à cette formation.');
        }

        // Générer le PDF avec la bibliothèque Dompdf
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('attestations.show', [
            'formation' => $formation,
            'participant' => $participant,
        ]);
        return $pdf->download('attestation_' . $participant->nom . '_' . $participant->prenom . '.pdf');
    }
}