<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use PDF;

class UploadController extends Controller
{
    /**
     * Affiche le formulaire d'upload de liste de présence.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Formation $formation)
    {
        return view('formations.participants.upload', compact('formation'));
    }

    /**
     * Télécharge et traite la liste de présence.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Formation $formation)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName);

        // Utiliser la bibliothèque PDF pour extraire les données du PDF
        $pdf = PDF::loadFile(Storage::path($filePath));
        $text = $pdf->getText();

        // Extraire les données des participants du texte
        $participants = explode("\n", $text);
        $participantsData = [];
        foreach ($participants as $participant) {
            // Supprimer les espaces en trop et les caractères inutiles
            $participant = trim($participant);
            $participant = preg_replace('/[^a-zA-Z0-9\s]/', '', $participant);

            // Diviser le nom et le prénom
            $parts = explode(' ', $participant);
            $nom = $parts[0];
            $prenom = implode(' ', array_slice($parts, 1));

            $participantsData[] = ['nom' => $nom, 'prenom' => $prenom];
        }

        // Enregistrer les participants dans la base de données
        foreach ($participantsData as $data) {
            $participant = Participant::firstOrCreate([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
            ]);
            $formation->participants()->attach($participant);
        }

        return redirect()->route('formations.participants.index', $formation)->with('success', 'Liste de présence téléchargée avec succès !');
    }
}